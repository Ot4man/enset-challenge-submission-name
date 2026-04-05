<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [EmergencyController::class, 'home'])->name('home');
    Route::get('/history', [EmergencyController::class, 'history'])->name('history');
    Route::get('/nearby', [EmergencyController::class, 'nearby'])->name('nearby');
    Route::get('/dashboard', [EmergencyController::class, 'dashboard'])->name('dashboard');
    Route::get('/about', [EmergencyController::class, 'about'])->name('about');
    Route::get('/contact', [EmergencyController::class, 'contact'])->name('contact');
    Route::post('/analyze', [EmergencyController::class, 'analyze'])->name('analyze');
});
