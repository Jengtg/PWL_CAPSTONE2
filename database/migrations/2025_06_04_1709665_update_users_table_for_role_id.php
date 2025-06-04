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
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing 'role' column first
            $table->dropColumn('role');

            // Add the new 'role_id' column
            // Make it unsigned to match the 'id' in roles table
            // Set it nullable initially if you might have users without a role,
            // or if you'll populate it in a seeder immediately.
            $table->unsignedInteger('role_id')->nullable()->after('password'); // Place it after password for logical order

            // Add the foreign key constraint
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete('set null'); // If a role is deleted, set user's role_id to null
                                         // Consider 'restrict' or 'cascade' if roles must always exist
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint before dropping the column
            $table->dropForeign(['role_id']);

            // Drop the 'role_id' column
            $table->dropColumn('role_id');

            // Re-add the original 'role' column (for rollback purposes)
            $table->string('role')->default('guest')->after('password');
        });
    }
};