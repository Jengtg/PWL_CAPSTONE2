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
            $table->unsignedInteger('id');
            $table->primary('id');
            // If you want this to be auto-incrementing, use:
            // $table->increments('id');

            $table->unsignedInteger('event_register_user_id');
            $table->unsignedInteger('event_register_event_id');
            $table->timestamp('scan_time')->useCurrent()->useCurrentOnUpdate();
            $table->string('qr_code');
            $table->timestamps();

            $table->foreign(['event_register_user_id', 'event_register_event_id'], 'event_attendance_logs_event_register_fk')
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