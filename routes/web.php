<?php

use App\Http\Controllers\CheckOrSaveGivingEnteryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::post('check-or-create-giving-entry', CheckOrSaveGivingEnteryController::class)->name('check-or-create-giving-entry');
});
