<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConferenceController;

Route::get('/', [ConferenceController::class, 'index'])->name('home');
Route::resource('conferences', ConferenceController::class);
//Route::get('/conferences/{id}/details', [ConferenceController::class, 'details']);