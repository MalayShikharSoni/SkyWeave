<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WaypointController;
use App\Http\Controllers\NavaidController;
use App\Http\Controllers\ATSRouteController;
use App\Http\Controllers\DraftRouteController;
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

    // === Draft Route (session-based route builder — must be before resource) ===
    Route::prefix('routes/draft')->name('draft.')->group(function () {
        Route::get('/', [DraftRouteController::class, 'getDraft'])->name('get');
        Route::post('/add', [DraftRouteController::class, 'addWaypoint'])->name('add');
        Route::post('/remove', [DraftRouteController::class, 'removeWaypoint'])->name('remove');
        Route::post('/reorder', [DraftRouteController::class, 'reorderWaypoints'])->name('reorder');
        Route::post('/clear', [DraftRouteController::class, 'clearDraft'])->name('clear');
    });

    // === ATS Routes ===
    Route::resource('routes', ATSRouteController::class);
});

require __DIR__.'/auth.php';
