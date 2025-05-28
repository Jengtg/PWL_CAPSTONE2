<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // Required for composite key handling

class EventRegister extends Model
{
    use HasFactory;

    protected $table = 'event_register';

    /**
     * The primary key associated with the table.
     * This model uses a composite primary key.
     * Eloquent doesn't natively support composite primary keys for find() etc.
     * We set $primaryKey to null and handle lookups with where clauses.
     * Or, override newEloquentBuilder.
     *
     * @var string|array
     */
    protected $primaryKey = ['user_id', 'event_id']; // Informational, won't make find([1,1]) work

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int'; // Both parts of the key are integers


    protected $fillable = [
        'user_id',
        'event_id',
        'status_id',
        'payment_file',
    ];

    /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the event that owns the registration.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    /**
     * Get the status of the registration.
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    /**
     * Get the certificates for this event registration.
     */
    public function certificates()
    {
        // Custom handling for composite foreign key on Certificate model
        // Certificate model has event_register_user_id and event_register_event_id
        return $this->hasMany(Certificate::class, 'event_register_user_id', 'user_id')
                    ->where('certificates.event_register_event_id', $this->event_id);
    }

    /**
     * Get the attendance logs for this event registration.
     */
    public function eventAttendanceLogs()
    {
        return $this->hasMany(EventAttendanceLog::class, 'event_register_user_id', 'user_id')
                    ->where('event_attendance_logs.event_register_event_id', $this->event_id);
    }

    /**
     * Get the files for this event registration.
     */
    public function files()
    {
        return $this->hasMany(File::class, 'event_register_user_id', 'user_id')
                    ->where('files.event_register_event_id', $this->event_id);
    }


    /**
     * Set the keys for a save update query.
     * This is needed to correctly update models with composite primary keys.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        /** @var array<int, string> $keys */ // Corrected PHPDoc
        $keys = $this->getKeyName();

        foreach ($keys as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }
        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @return mixed
     */
    // public function getKey()
    // {
    //     $attributes = [];
    //     foreach ($this->getKeyName() as $key) {
    //         $attributes[$key] = $this->getAttribute($key);
    //     }
    //     return $attributes; // Not ideal, Eloquent expects a single value for some operations
    // }
}