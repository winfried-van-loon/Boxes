<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    /** @use HasFactory<\Database\Factories\CustomFieldFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_name',
        'field_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
