<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxItem extends Model
{
    /** @use HasFactory<\Database\Factories\BoxItemFactory> */
    use HasFactory;

    protected $fillable = [
        'box_id',
        'name',
        'description',
        'quantity',
    ];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
