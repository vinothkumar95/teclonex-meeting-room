<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Models\Booking;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',[
        'booking_history' => Booking::where('user_id', Auth::user()->id)->with(['room','timeSlot'])->get()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/rooms',[RoomController::class,'index'])->name('room.index');
    Route::post('/room/book', [RoomController::class, 'book']);
    Route::post('/room/booked-slots', [RoomController::class, 'bookedSlots']);
    Route::delete('/room/bookings/{booking}', [RoomController::class, 'destroy']);
});

require __DIR__.'/auth.php';
