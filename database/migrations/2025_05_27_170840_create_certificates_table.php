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
            $table->id();
        
        
            $table->unsignedBigInteger('event_register_user_id');
            $table->unsignedBigInteger('event_register_event_id');
        
        
            $table->string('file_path');
            
            $table->timestamps();
        
        
            $table->foreign(
                ['event_register_user_id', 'event_register_event_id'], 
                'certificates_event_register_fk'
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