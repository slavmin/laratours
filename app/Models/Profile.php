<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['type', 'content'];

    protected $casts = [
        'content' => 'array'
    ];

    public function profileable()
    {
        return $this->morphTo();
    }
}
