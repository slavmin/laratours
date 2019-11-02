<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use App\Models\Traits\HasProfile;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;

class TourAttendant extends Model
{
    use UsedByTeams, HasProfile, HasPagination, SoftDeletes, ActionButtonsAttribute;

    protected $fillable = ['name', 'description', 'price', 'extra'];

    protected $casts = [
        'price' => 'float',
        'extra' => 'array',
    ];

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'attendant';
    }

    public function tours()
    {
        return $this->morphToMany('App\Models\Tour\Tour', 'tourable');
    }
}
