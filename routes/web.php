<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController; // <-- TAMBAHKAN BARIS INI

Route::get('/', function () {
    return view('guest');
});


Route::get('/events', [EventController::class, 'guestIndex'])->name('events.guest.index');

Route::get('/dashboard', function () {
    return view('guest');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:panitia_kegiatan'])->prefix('committee')->name('committee.')->group(function () {
    // Dashboard Khusus Panitia (jika ada)
    // Route::get('/dashboard', [CommitteeDashboardController::class, 'index'])->name('dashboard');

    // CRUD untuk Event oleh Panitia
    Route::get('/events', [EventController::class, 'index'])->name('events.index'); // Daftar event (tampilan panitia)
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create'); // Form tambah event
    Route::post('/events', [EventController::class, 'store'])->name('events.store'); // Proses simpan event baru
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show'); // Detail event (tampilan panitia)
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit'); // Form edit event
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update'); // Proses update event
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy'); // Proses hapus event
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';