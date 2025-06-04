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
        Schema::create('files', function (Blueprint $table) {
            $table->unsignedInteger('id'); // Was INT(10) in last SQL
            $table->primary('id');
            // If you want this to be auto-incrementing, use:
            // $table->increments('id');

            $table->string('file_name');
            $table->string('file_path');
            $table->binary('file_type'); // In SQL it was MEDIUMBLOB
            $table->unsignedInteger('event_register_user_id')->nullable();
            $table->unsignedInteger('event_register_event_id')->nullable();
            $table->timestamps();

            $table->foreign(['event_register_user_id', 'event_register_event_id'], 'files_event_register_fk')
                  ->references(['user_id', 'event_id'])->on('event_registers')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};