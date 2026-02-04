<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxPhoto extends Model
{
    /** @use HasFactory<\Database\Factories\BoxPhotoFactory> */
    use HasFactory;

    protected $fillable = [
        'box_id',
        'path',
        'filename',
        'order',
        'ai_description',
    ];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
