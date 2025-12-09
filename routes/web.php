<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Welcome page (public)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Dashboard (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Todos resource routes
    Route::resource('todos', TodoController::class)->except(['show']);
    
    // Additional todo actions
    Route::post('/todos/{id}/complete', [TodoController::class, 'complete'])
        ->name('todos.complete');
    Route::post('/todos/{id}/pending', [TodoController::class, 'pending'])
        ->name('todos.pending');
    Route::post('/todos/{id}/toggle-status', [TodoController::class, 'toggleStatus'])
        ->name('todos.toggle-status');
});

require __DIR__.'/auth.php';