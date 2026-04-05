<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmergencyController;

Route::post('/analyze', [EmergencyController::class, 'analyze']);
