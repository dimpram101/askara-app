<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/ai-cxr-diagnose', function () {
   return inertia('AiDiagnose');
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'check.dashboard'])->name('dashboard');

// User Management Routes
Route::middleware(['auth', 'verified', 'check.dashboard'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show', 'create', 'edit']);
});

// Profile Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/settings.php';
