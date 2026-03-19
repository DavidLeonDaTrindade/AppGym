<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClientDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isTrainer()
            ? redirect('/admin')
            : redirect()->route('dashboard');
    }

    return view('home');
})->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'active'])->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('can:access-client-area')->group(function (): void {
        Route::get('/dashboard', [ClientDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/mi-rutina', [ClientDashboardController::class, 'routine'])->name('client.routine');
        Route::get('/mi-dieta', [ClientDashboardController::class, 'diet'])->name('client.diet');
        Route::get('/mi-progreso', [ClientDashboardController::class, 'progress'])->name('client.progress');
        Route::put('/mi-perfil', [ClientDashboardController::class, 'updateProfile'])->name('client.profile.update');
        Route::post('/mi-progreso/mediciones', [ClientDashboardController::class, 'storeMeasurement'])->name('client.measurements.store');
        Route::put('/mi-progreso/mediciones/{measurement}', [ClientDashboardController::class, 'updateMeasurement'])->name('client.measurements.update');
        Route::delete('/mi-progreso/mediciones/{measurement}', [ClientDashboardController::class, 'destroyMeasurement'])->name('client.measurements.destroy');
    });
});
