<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventCategoryController; // Ganti jika path controller Anda berbeda

// Rute Publik
Route::get('/', [EventController::class, 'guestIndex'])->name('home');
Route::get('/events', [EventController::class, 'guestIndex'])->name('events.guest.index');
Route::get('/events/{event}', [EventController::class, 'showPublic'])->name('events.show.public');

// Rute untuk Administrator
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('event-categories', EventCategoryController::class);
});

// Rute untuk Panitia Kegiatan
Route::middleware(['auth', 'role:panitia_kegiatan'])->prefix('committee')->name('committee.')->group(function () {
    Route::resource('events', EventController::class);
});

// Grup Rute Umum untuk Pengguna yang Sudah Login
Route::middleware('auth')->group(function () {
    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('home'); // Arahkan dashboard ke halaman utama
    })->middleware('verified')->name('dashboard');

    // **TAMBAHKAN RUTE INI UNTUK REGISTRASI EVENT**
    Route::post('/events/{event}/register', [EventController::class, 'register'])
         ->middleware('role:member') // Pastikan hanya member yang bisa mendaftar
         ->name('events.register');
});


require __DIR__.'/auth.php';