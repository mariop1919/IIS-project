<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConferenceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\AdminController;

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
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/conference-rooms/create', [RoomController::class, 'create'])->name('conference_rooms.create');
    Route::post('/conference-rooms', [RoomController::class, 'store'])->name('conference_rooms.store');
});


Route::middleware(['auth'])->group(function () {
    // Form to create a presentation with conference selection
    Route::get('/presentations/create', [PresentationController::class, 'create'])->name('presentations.create');

    // Submitting the form to register a presentation for a selected conference
    Route::post('/presentations', [PresentationController::class, 'store'])->name('presentations.store');
    Route::get('/conferences/{conference_id}/presentations/manage', [PresentationController::class, 'manage'])->name('presentations.manage');
    Route::delete('/presentations/{id}', [PresentationController::class, 'destroy'])->name('presentations.destroy');

    Route::post('/presentations/{presentation}/approve', [PresentationController::class, 'approve'])->name('presentations.approve');
    Route::post('/presentations/{presentation}/reject', [PresentationController::class, 'reject'])->name('presentations.reject');
    Route::get('/presentations/{presentation}/edit', [PresentationController::class, 'edit'])->name('presentations.edit');
    Route::put('/presentations/{presentation}', [PresentationController::class, 'update'])->name('presentations.update');
    Route::get('/presentations/timetable', [PresentationController::class, 'timetable'])->name('presentations.timetable');
    Route::get('/conferences/{conference_id}/reservations/manage', [ReservationController::class, 'manage'])->name('reservations.manage');
    Route::post('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    // Attendee schedule
    Route::get('/presentations/attendeeSchedule', [PresentationController::class, 'attendeeSchedule'])->name('presentations.attendeeSchedule');
    Route::post('/presentations/{presentation}/add-to-schedule', [PresentationController::class, 'addToPersonalSchedule'])->name('personal_schedule.add');
    Route::post('/presentations/{presentation}/remove-from-schedule', [PresentationController::class, 'removeFromPersonalSchedule'])->name('personal_schedule.remove');
    // Personal schedule
    Route::post('/presentations/{presentation}/add-to-schedule', [PresentationController::class, 'addToPersonalSchedule'])->name('presentations.personalSchedule.add');
    Route::post('/presentations/{presentation}/remove-from-schedule', [PresentationController::class, 'removeFromPersonalSchedule'])->name('presentations.personalSchedule.remove');
    Route::get('/presentations/personal-schedule', [PresentationController::class, 'personalSchedule'])->name('presentations.personalSchedule');
});

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [AdminController::class, 'index'])->name('index');
    Route::get('users/{user}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('users/{user}', [AdminController::class, 'update'])->name('update');
    Route::delete('users/{user}', [AdminController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->group(function () {
    
});