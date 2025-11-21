<?php

use App\Http\Controllers\AiDiagnoseController;
use App\Http\Controllers\PengobatanSOController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
   return Inertia::render('Welcome', [
      'canRegister' => Features::enabled(Features::registration()),
   ]);
})->name('home');


Route::get('/hotspot-map', [PengobatanSOController::class, 'index'])->name('hotspot_map');
Route::get('/pengobatan_so_2023', [PengobatanSOController::class, 'getData'])->name('pengobatan_so_2023');

Route::get('dashboard', function () {
   return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'check.dashboard'])->name('dashboard');

// User Management Routes
Route::middleware(['auth', 'verified', 'check.dashboard'])->prefix('dashboard')->name('dashboard.')->group(function () {
   Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show', 'create', 'edit']);

   // Predictions list for Fasyankes only
   Route::get('/predictions', [\App\Http\Controllers\PredictionHistoryController::class, 'index'])
      ->middleware('role.fasyankes')
      ->name('predictions');
});

// Profile Routes
Route::middleware(['auth', 'verified'])->group(function () {
   Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
   Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
   Route::resource('/ai-cxr-diagnose', AiDiagnoseController::class)->only(['index', 'store']);
   Route::get('/search-patients', [AiDiagnoseController::class, 'searchPatients'])->name('search.patients');
});

// Prediction History for Pasien only
Route::middleware(['auth', 'verified'])->group(function () {
   Route::middleware('role:Pasien,Fasyankes')->get('/prediction-history', [\App\Http\Controllers\PredictionHistoryController::class, 'history'])
      ->name('prediction.history.pasien');
   // Route::middleware('role.fasyankes')->get('/prediction-history', [\App\Http\Controllers\PredictionHistoryController::class, 'history'])
   //    ->name('prediction.history.fasyankes');
});

require __DIR__ . '/settings.php';
