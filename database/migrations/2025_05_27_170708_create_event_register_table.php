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
            // === PERUBAHAN PENTING DI SINI untuk user_id ===
            // Ganti baris ini:
            // $table->unsignedInteger('user_id');
            // Dengan salah satu dari dua pilihan di bawah ini:

            // Pilihan 1: Ubah tipe data secara eksplisit
            $table->unsignedBigInteger('user_id');
            // ATAU Pilihan 2 (Direkomendasikan): Gunakan foreignId()
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('event_id');    // Biarkan jika events.id adalah unsignedInteger
            $table->unsignedTinyInteger('status_id'); // Biarkan jika status.id adalah unsignedTinyInteger
            $table->string('payment_file')->nullable();
            $table->timestamps();

            $table->primary(['user_id', 'event_id']);

            // Jika menggunakan Pilihan 1 di atas (unsignedBigInteger), baris foreign key ini tetap diperlukan.
            // Jika menggunakan Pilihan 2 (foreignId), baris foreign key untuk user_id ini bisa dihapus/dikomentari.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
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