<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    public function index()
    {
        // Fetch projects from the API using config
        $response = Http::get(config('api.backend_url') . '/projects');
        $projects = $response->successful() ? $response->json() : [];

        // dd($projects);
        // exit();

        return view('welcome', compact('projects'));
    }
}
