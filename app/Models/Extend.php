<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class Extend extends Model
{
    use UsedByTeams;

    protected $fillable = ['name', 'type', 'content', 'team_id'];

    protected $casts = [
        'content' => 'array'
    ];

    public function extendable()
    {
        return $this->morphTo();
    }
}
