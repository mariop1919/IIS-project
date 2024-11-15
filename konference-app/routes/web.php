<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConferenceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;

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


Route::get('conferences/create', [ConferenceController::class, 'create'])->name('conferences.create')->middleware('auth');

Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

Route::middleware(['auth'])->group(function () {
    Route::prefix('conferences/{conference}')->group(function () {
        Route::get('rooms/create', [RoomController::class, 'create'])->name('conference_rooms.create');
        Route::post('rooms', [RoomController::class, 'store'])->name('conference_rooms.store');
    });
});
