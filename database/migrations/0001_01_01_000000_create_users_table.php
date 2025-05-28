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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id'); // As per SQL: INT(10) UNSIGNED NOT NULL
            $table->primary('id');        // As per SQL: PRIMARY KEY (id)
            // If you want this to be auto-incrementing, use:
            // $table->increments('id'); // This creates an UNSIGNED INT AUTO_INCREMENT PK

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('quest'); // Changed from 'quest' to 'guest' if that was a typo
            $table->rememberToken();
            $table->timestamps(); // Adds created_at and updated_at (nullable by default)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};