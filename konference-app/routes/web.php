<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConferenceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VoteController;
Route::get('/', [ConferenceController::class, 'index'])->name('home');
//Route::resource('conferences', ConferenceController::class);
Route::get('/conferences', [ConferenceController::class, 'index'])->name('conferences.index');
Route::get('/conferences/{conference}', [ConferenceController::class, 'show'])->name('conferences.show');
Route::middleware(['auth'])->group(function (){
    Route::get('/conferences/create', [ConferenceController::class, 'create'])->name('conferences.create');
    Route::post('/conferences', [ConferenceController::class, 'store'])->name('conferences.store');

    Route::get('/conference-rooms/create', [RoomController::class, 'create'])->name('conference_rooms.create');     //rooms
    Route::post('/conference-rooms', [RoomController::class, 'store'])->name('conference_rooms.store');

    Route::get('/presentations/create', [PresentationController::class, 'create'])->name('presentations.create');   // create presentations
    Route::post('/presentations', [PresentationController::class, 'store'])->name('presentations.store');

    Route::get('/presentations/timetable', [PresentationController::class, 'timetable'])->name('presentations.timetable');  //timetable presentation

    Route::get('/presentations/attendeeSchedule', [PresentationController::class, 'attendeeSchedule'])->name('presentations.attendeeSchedule');     //attendee schedule
    Route::post('/presentations/{presentation}/add-to-schedule', [PresentationController::class, 'addToPersonalSchedule'])->name('personal_schedule.add');
    Route::post('/presentations/{presentation}/remove-from-schedule', [PresentationController::class, 'removeFromPersonalSchedule'])->name('personal_schedule.remove');
    Route::post('/presentations/{presentation}/add-question', [PresentationController::class, 'addQuestion'])->name('presentations.addQuestion');

    Route::post('/presentations/{presentation}/add-to-schedule', [PresentationController::class, 'addToPersonalSchedule'])->name('presentations.personalSchedule.add');         //my schedule
    Route::post('/presentations/{presentation}/remove-from-schedule', [PresentationController::class, 'removeFromPersonalSchedule'])->name('presentations.personalSchedule.remove');
    Route::get('/presentations/personal-schedule', [PresentationController::class, 'personalSchedule'])->name('presentations.personalSchedule');

    Route::get('/presentations/leaderboard', [PresentationController::class, 'showLeaderboard'])->name('presentations.leaderboard');    //voting for best presentation
    Route::post('/presentations/{presentation}/vote', [VoteController::class, 'vote'])->name('presentations.vote');
    Route::delete('/presentations/{presentation}/unvote', [VoteController::class, 'unvote'])->name('presentations.unvote');
});
Route::middleware(['conference_creator'])->group(function () {
    
    Route::get('/conferences/{conference}/edit', [ConferenceController::class, 'edit'])->name('conferences.edit');
    Route::put('/conferences/{conference}', [ConferenceController::class, 'update'])->name('conferences.update');
    Route::delete('/conferences/{conference}', [ConferenceController::class, 'destroy'])->name('conferences.destroy');

    Route::get('/conferences/{conference}/presentations/manage', [PresentationController::class, 'manage'])->name('presentations.manage');       //manage presentations
    Route::delete('/presentations/{conference}/{id}', [PresentationController::class, 'destroy'])->name('presentations.destroy');
    Route::post('/presentations/{conference}/{presentation}/approve', [PresentationController::class, 'approve'])->name('presentations.approve');
    Route::get('/presentations/{conference}/{presentation}/edit', [PresentationController::class, 'edit'])->name('presentations.edit');
    Route::put('/presentations/{conference}/{presentation}', [PresentationController::class, 'update'])->name('presentations.update');

    Route::get('/conferences/{conference}/reservations/manage', [ReservationController::class, 'manage'])->name('reservations.manage');  //reservation manage
    Route::post('/reservations/{conference}/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::post('/reservations/{conference}/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    
});

//Route::get('/conferences/{id}/details', [ConferenceController::class, 'details']);
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');  //Redirect to home page after logout
})->name('logout');
Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);


//Route::get('conferences/create', [ConferenceController::class, 'create'])->name('conferences.create')->middleware('auth');

Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');

// Admin panel
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [AdminController::class, 'index'])->name('index');
    Route::get('users/add', [AdminController::class, 'add'])->name('add'); 
    Route::post('users', [AdminController::class, 'store'])->name('store');
    Route::get('users/{user}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('users/{user}', [AdminController::class, 'update'])->name('update');
    Route::delete('users/{user}', [AdminController::class, 'destroy'])->name('destroy');
    Route::post('users/{user}/deactivate', [AdminController::class, 'deactivate'])->name('deactivate');
    Route::post('users/{user}/activate', [AdminController::class, 'activate'])->name('activate');
});
