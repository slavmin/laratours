<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class CustomField extends Model
{
    use UsedByTeams;

    protected $table = 'custom_fields';

    protected $fillable = ['name', 'type', 'content', 'team_id'];

    protected $casts = [
        'content' => 'array'
    ];

    public function fieldable()
    {
        return $this->morphTo();
    }
}
