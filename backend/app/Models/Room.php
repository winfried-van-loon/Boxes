<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boxesInRoom()
    {
        return $this->hasMany(Box::class, 'current_room_id');
    }

    public function boxesTargetingRoom()
    {
        return $this->hasMany(Box::class, 'target_room_id');
    }
}
