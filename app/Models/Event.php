<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'event_category_id', 'poster_kegiatan', 'start_date', 'end_date'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];

    public function eventCategory() { return $this->belongsTo(EventCategory::class); }
    public function sessions() { return $this->hasMany(EventSession::class)->orderBy('session_date')->orderBy('start_time'); }
    public function eventRegistrations() { return $this->hasManyThrough(EventRegister::class, EventSession::class); }
}