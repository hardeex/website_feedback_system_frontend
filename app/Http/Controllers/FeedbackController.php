<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        // Fetch projects from the API
        $response = Http::get(config('api.backend_url') . '/projects');
        $projects = $response->successful() ? $response->json() : [];

        // Compute feedback summaries
        $projectSummaries = [];
        foreach ($projects as &$project) {
            $response = Http::get(config('api.backend_url') . "/projects/{$project['id']}/feedback");
            $feedbacks = $response->successful() ? $response->json()['data'] : [];
            $project['feedback_count'] = count($feedbacks);
            $project['average_rating'] = $project['feedback_count'] > 0
                ? round(array_sum(array_column($feedbacks, 'rating')) / $project['feedback_count'], 1)
                : 0;
            $projectSummaries[$project['id']] = [
                'feedback_count' => $project['feedback_count'],
                'average_rating' => $project['average_rating'],
            ];
        }

        // Get project_id from query parameter
        $selectedProjectId = $request->query('project_id');

        // Get search query
        $search = $request->query('search', '');

        // Filter projects by search term
        if ($search) {
            $projects = array_filter($projects, function ($project) use ($search) {
                return stripos($project['name'], $search) !== false;
            });
        }

        return view('feedback', compact('projects', 'selectedProjectId', 'projectSummaries', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required',
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
        ]);

        // Submit feedback to the API
        $response = Http::post(config('api.backend_url') . "/projects/{$validated['project_id']}/feedback", [
            'comment' => $validated['comment'],
            'rating' => $validated['rating'],
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Feedback submitted successfully!');
        }

        return redirect()->back()->withErrors(['error' => 'Failed to submit feedback.']);
    }

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('login');
        }

        $request->validate([
            'passcode' => 'required|string',
        ]);

        $passcode = trim($request->passcode); // Trim to remove any whitespace
        $expectedPasscode = config('api.developer_passcode');

        Log::debug('Developer login attempt', [
            'entered_passcode' => $passcode,
            'expected_passcode' => $expectedPasscode,
            'config_value' => config('api.developer_passcode'),
        ]);

        if ($passcode === $expectedPasscode) {
            $request->session()->put('developer_authenticated', true);
            Log::info('Developer login successful', ['passcode' => $passcode]);
            return redirect()->route('feedback.index')->with('success', 'Logged in as developer.');
        }

        Log::warning('Developer login failed: Invalid passcode', [
            'entered_passcode' => $passcode,
            'expected_passcode' => $expectedPasscode,
        ]);
        return back()->withErrors(['error' => 'Invalid passcode. Please try again.']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('developer_authenticated');
        return redirect()->route('developer.login')->with('success', 'Logged out successfully.');
    }
}