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
        Schema::table('files', function (Blueprint $table) {
            $table->increments('id')->change(); // Make ID auto-incrementing
            $table->string('file_type')->change(); // Change BLOB to VARCHAR
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            // Revert changes for `id` and `file_type` if necessary.
            // Reverting BLOB is not straightforward, consider if needed.
        });
    }
};