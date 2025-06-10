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
            // 1. Menggunakan $table->id() untuk primary key auto-increment standar.
            $table->id();
        
            $table->string('file_name');
            $table->string('file_path');
        
            // 2. Mengubah tipe data 'file_type' menjadi string untuk MIME type.
            $table->string('file_type')->nullable();
        
            // 3. Menyesuaikan tipe data foreign key menjadi unsignedBigInteger.
            $table->unsignedBigInteger('event_register_user_id')->nullable();
            $table->unsignedBigInteger('event_register_event_id')->nullable();
            
            $table->timestamps();
        
            // 4. Mendefinisikan foreign key dengan nama kustom yang sudah Anda buat.
            $table->foreign(
                ['event_register_user_id', 'event_register_event_id'], 
                'files_event_register_fk'
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