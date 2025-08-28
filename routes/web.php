<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/developer/login', [FeedbackController::class, 'login'])->name('developer.login');
Route::post('/developer/login', [FeedbackController::class, 'login'])->name('developer.login');
Route::post('/developer/logout', [FeedbackController::class, 'logout'])->name('developer.logout');