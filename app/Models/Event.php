<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'start_date', // Jika kolom database Anda bernama start_date dan bertipe DATETIME
        'end_date',   // Jika kolom database Anda bernama end_date dan bertipe DATETIME
        'event_category_id',
        'lokasi',
        'narasumber',
        'poster_kegiatan',
        'biaya_registrasi',
        'jumlah_maksimal_peserta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime', // Mengasumsikan Anda menyimpan tanggal dan waktu
        'end_date' => 'datetime',   // Mengasumsikan Anda menyimpan tanggal dan waktu
        'biaya_registrasi' => 'decimal:2', // Contoh jika ingin biaya sebagai desimal
    ];

    /**
     * Get the category that owns the event.
     */
    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id'); // 'id' sebagai foreign key kedua adalah default, bisa dihilangkan
    }

    /**
     * Get the registrations for the event.
     */
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegister::class, 'event_id'); // 'id' sebagai local key kedua adalah default, bisa dihilangkan
    }

    // Optional: Relationship to users through registrations
    // public function registeredUsers()
    // {
    //     return $this->belongsToMany(User::class, 'event_register', 'event_id', 'user_id')
    //                  ->withTimestamps(); 
    // }
}