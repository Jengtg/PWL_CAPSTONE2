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
            // Sebaiknya gunakan $table->id(); jika ingin ID auto-increment standar Laravel
            $table->unsignedInteger('id')->primary();

            // PERUBAHAN UTAMA DI SINI:
            $table->unsignedBigInteger('event_register_user_id'); // Agar cocok dengan event_register.user_id

            $table->unsignedInteger('event_register_event_id');  // Biarkan ini jika event_register.event_id adalah unsignedInteger

            $table->timestamp('scan_time')->useCurrent()->useCurrentOnUpdate();
            $table->string('qr_code');
            $table->timestamps();

            $table->foreign(
                ['event_register_user_id', 'event_register_event_id'],
                'fk_event_attendance_event_reg'
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