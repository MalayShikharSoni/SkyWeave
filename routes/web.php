<?php

use App\Http\Controllers\ProfileController;
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

    // === Waypoints (placeholder routes for Phase 1) ===
    Route::get('/waypoints', function () {
        return view('placeholder', ['title' => 'Waypoints', 'description' => 'Waypoint management coming in Phase 3']);
    })->name('waypoints.index');

    Route::get('/waypoints/create', function () {
        return view('placeholder', ['title' => 'Add Waypoint', 'description' => 'Waypoint creation coming in Phase 3']);
    })->name('waypoints.create');

    // === NAVAIDs (placeholder routes for Phase 1) ===
    Route::get('/navaids', function () {
        return view('placeholder', ['title' => 'NAVAIDs', 'description' => 'NAVAID management coming in Phase 4']);
    })->name('navaids.index');

    Route::get('/navaids/create', function () {
        return view('placeholder', ['title' => 'Add NAVAID', 'description' => 'NAVAID creation coming in Phase 4']);
    })->name('navaids.create');

    // === ATS Routes (placeholder routes for Phase 1) ===
    Route::get('/routes', function () {
        return view('placeholder', ['title' => 'ATS Routes', 'description' => 'Route management coming in Phase 5']);
    })->name('routes.index');

    Route::get('/routes/create', function () {
        return view('placeholder', ['title' => 'Build Route', 'description' => 'Route builder coming in Phase 5']);
    })->name('routes.create');
});

require __DIR__.'/auth.php';
