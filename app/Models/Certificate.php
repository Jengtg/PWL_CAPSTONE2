<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';
    protected $primaryKey = 'id';
    public $incrementing = false; // Based on migration: unsignedInteger('id')->primary()
    protected $keyType = 'int';

    protected $fillable = [
        'id', // If you manually assign IDs
        'event_register_user_id',
        'event_register_event_id',
    ];

    /**
     * Get the event registration that this certificate belongs to.
     * This is a simplified way to get the parent without full Eloquent relation magic for composite keys.
     */
    public function eventRegister()
    {
        // This doesn't return a full Eloquent Relationship object for easy eager loading with dot notation
        // from Certificate side in a simple way without packages.
        // You'd typically load certificates via an EventRegister instance.
        return EventRegister::where('user_id', $this->event_register_user_id)
                            ->where('event_id', $this->event_register_event_id)
                            ->first(); // Returns a single EventRegister model or null
    }

    // For easier access to user and event directly:
    public function user() {
        return $this->belongsTo(User::class, 'event_register_user_id', 'id');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_register_event_id', 'id');
    }
}