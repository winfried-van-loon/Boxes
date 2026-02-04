<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConnection extends Model
{
    /** @use HasFactory<\Database\Factories\UserConnectionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'connected_user_id',
        'status',
        'connection_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function connectedUser()
    {
        return $this->belongsTo(User::class, 'connected_user_id');
    }
}
