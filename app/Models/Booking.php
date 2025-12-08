<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Time;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'time_slot_id',
        'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
