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
        Schema::create('certificates', function (Blueprint $table) {
            // PRIMARY KEY: Use increments() for auto-incrementing unsigned integer ID
            $table->increments('id'); 

            // Foreign key columns for event_register
            // These must match the data types (unsignedInteger) of user_id and event_id in event_registers
            $table->unsignedInteger('event_register_user_id'); 
            $table->unsignedInteger('event_register_event_id');

            // Other essential certificate columns
            $table->string('file_path')->nullable(); 
            $table->string('unique_code')->unique()->nullable();

            $table->timestamps();

            // IMPORTANT: Explicitly add an index for the composite foreign key.
            // This is crucial for MySQL's foreign key constraint creation.
            $table->index(['event_register_user_id', 'event_register_event_id'], 'idx_certificates_event_register');

            // Define the composite foreign key constraint
            $table->foreign(['event_register_user_id', 'event_register_event_id'], 'certificates_event_register_fk')
                  ->references(['user_id', 'event_id'])
                  ->on('event_registers') // Ensure table name is exactly 'event_register'
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};