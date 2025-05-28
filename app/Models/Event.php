<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    // primaryKey is 'id' by default
    // incrementing is true by default for integer primary keys
    // keyType is 'int' by default

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'event_category_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the category that owns the event.
     */
    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id', 'id');
    }

    /**
     * Get the registrations for the event.
     */
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegister::class, 'event_id', 'id');
    }

    // Optional: Relationship to users through registrations
    // public function registeredUsers()
    // {
    //     return $this->belongsToMany(User::class, 'event_register', 'event_id', 'user_id')
    //                 ->withTimestamps(); // if you want to access created_at/updated_at on the pivot
    // }
}