<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\RegisterController;

Route::get('/', [ConferenceController::class, 'index'])->name('home');
Route::resource('conferences', ConferenceController::class);
//Route::get('/conferences/{id}/details', [ConferenceController::class, 'details']);
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');  //Redirect to home page after logout
})->name('logout');
Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);



// zatial som povolil len admina na vytvaranie konferencii
Route::get('conferences/create', [ConferenceController::class, 'create'])->name('conferences.create')->middleware('role:admin');
