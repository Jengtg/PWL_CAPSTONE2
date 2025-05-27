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
            // Sebaiknya gunakan $table->id(); jika ingin ID auto-increment standar Laravel
            // Tapi jika Anda kelola manual dan yakin unik, unsignedInteger bisa saja.
            $table->unsignedInteger('id')->primary(); 

            // PERUBAHAN UTAMA DI SINI:
            $table->unsignedBigInteger('event_register_user_id'); // Agar cocok dengan event_register.user_id (yang seharusnya unsignedBigInteger)
            
            $table->unsignedInteger('event_register_event_id');  // Biarkan ini jika event_register.event_id adalah unsignedInteger

            // Disarankan menambahkan kolom untuk path file sertifikat
            // $table->string('file_path')->nullable(); 
            $table->timestamps();

            $table->foreign(
                ['event_register_user_id', 'event_register_event_id'],
                'fk_certificates_event_registration' 
            )
            ->references(['user_id', 'event_id'])->on('event_register')
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