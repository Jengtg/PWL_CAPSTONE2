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
            $table->id(); // Saran: Gunakan ini jika ingin ID auto-increment

            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable(); // Saran: Ubah ke string untuk MIME type

            // PERUBAHAN PENTING PADA TIPE DATA FOREIGN KEY:
            $table->unsignedBigInteger('event_register_user_id')->nullable(); // Agar cocok dengan event_register.user_id
            $table->unsignedInteger('event_register_event_id')->nullable();  // Biarkan jika event_register.event_id adalah unsignedInteger
            
            $table->timestamps();

            $table->foreign(
                ['event_register_user_id', 'event_register_event_id'],
                'files_event_reg_fk' // Contoh nama kustom yang lebih pendek (opsional tapi baik)
            )
            ->references(['user_id', 'event_id'])->on('event_register')
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