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
            $table->unsignedInteger('user_id'); // Matches users.id
            $table->unsignedInteger('event_id'); // Matches events.id (which is increments())
            $table->unsignedTinyInteger('status_id'); // Matches status.id
            $table->string('payment_file')->nullable();
            $table->timestamps();

            $table->primary(['user_id', 'event_id']); // Composite primary key

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
                  ->onDelete('cascade') // Or restrict/set null depending on logic
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