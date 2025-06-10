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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Membuat ID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
        
            $table->string('title');
            $table->text('description');
        
            // Menggunakan dateTime untuk menyimpan tanggal dan waktu
            $table->dateTime('start_date');
            $table->dateTime('end_date');
        
            // Foreign key ke tabel kategori
            $table->foreignId('event_category_id')
                  ->constrained('event_categories')
                  ->onDelete('cascade');
        
            // ===== KOLOM-KOLOM BARU YANG HILANG DITAMBAHKAN DI SINI =====
            $table->string('lokasi');
            $table->string('narasumber');
            $table->string('poster_kegiatan')->nullable(); // Boleh kosong
            $table->decimal('biaya_registrasi', 10, 2)->default(0); // Untuk uang, default 0
            $table->unsignedInteger('jumlah_maksimal_peserta');
            // ==========================================================
        
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};