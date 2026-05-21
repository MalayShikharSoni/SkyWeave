<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WaypointController;
use App\Http\Controllers\NavaidController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === Waypoints ===
    Route::resource('waypoints', WaypointController::class)->except(['show']);

    // === NAVAIDs ===
    Route::resource('navaids', NavaidController::class)->except(['show']);

    // === ATS Routes (placeholder routes — Phase 4) ===
    Route::get('/routes', function () {
        return view('placeholder', ['title' => 'ATS Routes', 'description' => 'Route management coming in Phase 4']);
    })->name('routes.index');

    Route::get('/routes/create', function () {
        return view('placeholder', ['title' => 'Build Route', 'description' => 'Route builder coming in Phase 4']);
    })->name('routes.create');
});

require __DIR__.'/auth.php';
