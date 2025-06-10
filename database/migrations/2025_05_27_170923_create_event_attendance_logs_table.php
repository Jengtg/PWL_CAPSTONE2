<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_attendance_logs', function (Blueprint $table) {
            // 1. Menggunakan $table->id() untuk primary key auto-increment standar
            $table->id();
        
            // 2. Menyesuaikan tipe data foreign key menjadi unsignedBigInteger
            $table->unsignedBigInteger('event_register_user_id');
            $table->unsignedBigInteger('event_register_event_id');
        
            $table->timestamp('scan_time')->useCurrent()->useCurrentOnUpdate();
            $table->string('qr_code');
            $table->timestamps();
        
            // Nama constraint kustom Anda sudah benar
            $table->foreign(
                ['event_register_user_id', 'event_register_event_id'],
                'event_attendance_logs_event_register_fk'
            )
            ->references(['user_id', 'event_id'])->on('event_register')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendance_logs');
    }
};