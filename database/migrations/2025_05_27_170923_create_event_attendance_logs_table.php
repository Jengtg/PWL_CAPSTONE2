<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('event_attendance_logs', function (Blueprint $table) {
            $table->increments('id'); // Primary key for the attendance log entry
            
            // Kita akan menggunakan kombinasi user_id dan event_id sebagai referensi ke pendaftaran
            $table->unsignedInteger('user_id'); 
            $table->unsignedInteger('event_id');
            
            $table->unsignedTinyInteger('session_number');
            $table->timestamp('scan_time')->useCurrent(); // Records the time of scan
            // Kolom 'qr_code' dihapus karena data QR sudah ada di event_registers.
            // Di sini kita hanya mencatat hasil pemindaian.
            
            $table->unsignedInteger('status_kehadiran_id'); // Foreign key for attendance status
            $table->timestamps();

            // Composite unique index to ensure a user only has one attendance log per session per event
            // Kombinasi ini efektif untuk memastikan uniknya kehadiran per sesi
            $table->unique(['user_id', 'event_id', 'session_number'], 'unique_attendance_per_session');

            // --- Foreign keys ---

            // Mengacu ke tabel 'users'
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            // Mengacu ke tabel 'event_registers' menggunakan composite key
            // Ini penting untuk memastikan kehadiran terdaftar untuk pendaftaran yang valid
            $table->foreign(['user_id', 'event_id'])
                ->references(['user_id', 'event_id'])->on('event_registers')
                ->onDelete('cascade') // Jika pendaftaran dihapus, log kehadiran ikut dihapus
                ->onUpdate('cascade');

            // Mengacu ke tabel 'event_details' untuk detail sesi
            $table->foreign(['event_id', 'session_number']) 
                ->references(['event_id', 'session_number'])->on('event_details')
                ->onDelete('cascade') // Jika detail sesi dihapus, log kehadiran untuk sesi itu ikut dihapus
                ->onUpdate('cascade');

            // Mengacu ke tabel 'status_kehadiran'
            $table->foreign('status_kehadiran_id')
                ->references('id')->on('status_kehadiran')
                ->onDelete('restrict') // Ganti cascade jadi restrict atau set null lebih aman
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendance_logs');
    }
};