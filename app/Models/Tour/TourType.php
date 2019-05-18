<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;

class TourType extends Model
{
    use SoftDeletes, UsedByTeams, HasPagination, ActionButtonsAttribute;

    protected $fillable = ['name', 'description'];

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'type';
    }
}
