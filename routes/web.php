<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmergencyController;

Route::get('/', [EmergencyController::class, 'home'])->name('home');
Route::get('/history', [EmergencyController::class, 'history'])->name('history');
Route::get('/nearby', [EmergencyController::class, 'nearby'])->name('nearby');
Route::get('/dashboard', [EmergencyController::class, 'dashboard'])->name('dashboard');
Route::get('/about', [EmergencyController::class, 'about'])->name('about');
Route::get('/contact', [EmergencyController::class, 'contact'])->name('contact');

Route::post('/analyze', [EmergencyController::class, 'analyze'])->name('analyze');
