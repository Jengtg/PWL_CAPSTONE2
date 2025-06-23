<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EventRegister extends Model
{
    use HasFactory;

    protected $table = 'event_register';
    
    /**
     * Kunci utama untuk model ini adalah komposit.
     */
    protected $primaryKey = ['user_id', 'event_session_id'];
    
    /**
     * Kunci utama tidak auto-increment.
     */
    public $incrementing = false;

    /**
     * Kolom yang diizinkan untuk diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'event_session_id', // Diperbarui dari 'event_id'
        'status_id',
        'payment_file',
    ];

    /**
     * Relasi ke pengguna yang mendaftar.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relasi ke sesi event yang didaftarkan.
     */
    public function eventSession()
    {
        return $this->belongsTo(EventSession::class);
    }

    /**
     * Relasi ke status pendaftaran.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Menangani composite primary key saat melakukan update.
     * * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }

        return $query;
    }
}
