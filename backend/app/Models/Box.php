<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    /** @use HasFactory<\Database\Factories\BoxFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'number',
        'type',
        'current_room_id',
        'current_location',
        'target_room_id',
        'target_location',
        'parent_box_id',
        'description',
        'custom_fields',
    ];

    protected $casts = [
        'custom_fields' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentRoom()
    {
        return $this->belongsTo(Room::class, 'current_room_id');
    }

    public function targetRoom()
    {
        return $this->belongsTo(Room::class, 'target_room_id');
    }

    public function parentBox()
    {
        return $this->belongsTo(Box::class, 'parent_box_id');
    }

    public function childBoxes()
    {
        return $this->hasMany(Box::class, 'parent_box_id');
    }

    public function items()
    {
        return $this->hasMany(BoxItem::class);
    }

    public function photos()
    {
        return $this->hasMany(BoxPhoto::class)->orderBy('order');
    }
}
