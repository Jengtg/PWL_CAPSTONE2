<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventSessionController; // Controller baru

// Rute Publik
Route::get('/', [EventController::class, 'guestIndex'])->name('home');
Route::get('/events', [EventController::class, 'guestIndex'])->name('events.guest.index');
Route::get('/events/{event}', [EventController::class, 'showPublic'])->name('events.show.public');

// Grup Rute Umum Pengguna Login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', fn() => redirect()->route('home'))->name('dashboard');

    // Rute untuk mendaftar ke sebuah SESI
    Route::post('/sessions/{session}/register', [EventSessionController::class, 'register'])
         ->middleware('role:member')
         ->name('sessions.register');
});

// Grup Rute Panitia Kegiatan
Route::middleware(['auth', 'role:panitia_kegiatan'])->prefix('committee')->name('committee.')->group(function () {
    // CRUD untuk Event Induk
    Route::resource('events', EventController::class); 
    // CRUD untuk Sesi (Nested di bawah Event)
    Route::resource('events.sessions', EventSessionController::class)->shallow();
});

// Grup Rute Administrator
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('event-categories', EventCategoryController::class);
});

require __DIR__.'/auth.php';