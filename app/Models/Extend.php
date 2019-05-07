<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extend extends Model
{
    protected $fillable = ['name', 'type', 'content'];

    protected $casts = [
        'content' => 'array'
    ];

    public function extendable()
    {
        return $this->morphTo();
    }
}
