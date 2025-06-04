<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_details', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->unsignedTinyInteger('session_number');
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->primary(['event_id', 'session_number']);

            $table->foreign('event_id')
                  ->references('id')->on('events')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_details');
    }
};
