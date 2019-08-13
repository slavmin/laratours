<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use App\Models\Traits\HasProfile;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourGuide extends Model
{
    use UsedByTeams, HasProfile, HasPagination, SoftDeletes, ActionButtonsAttribute;

    protected $fillable = ['name', 'description', 'price', 'extra'];

    protected $appends = ['model_alias'];

    protected $casts = [
        'price' => 'float',
        'extra' => 'array',
    ];

    public static function getModelAliasAttribute()
    {
        return 'guide';
    }

    public function tours()
    {
        return $this->morphToMany('App\Models\Tour\Tour', 'tourable');
    }

}
