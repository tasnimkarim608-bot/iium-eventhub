<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organiser_id', 'title', 'description', 'venue', 
        'event_date', 'category', 'max_slots'
    ];

    public function organiser()
    {
        return $this->belongsTo(User::class, 'organiser_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}