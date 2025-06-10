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
    Schema::create('event_register', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('event_id');

        $table->unsignedTinyInteger('status_id');
        $table->string('payment_file')->nullable();
        $table->timestamps();

        $table->primary(['user_id', 'event_id']); 

        $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->foreign('event_id')
              ->references('id')->on('events')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->foreign('status_id')
              ->references('id')->on('status')
              ->onDelete('cascade')
              ->onUpdate('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_register');
    }
};