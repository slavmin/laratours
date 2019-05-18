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

    protected $fillable = ['name', 'description', 'price'];

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'guide';
    }

    protected $casts = [
        'price' => 'float',
    ];
}
