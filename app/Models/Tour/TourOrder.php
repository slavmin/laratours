<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourOrder extends Model
{
    use UsedByTeams, HasPagination, SoftDeletes;

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'order';
    }

    public function tours()
    {
        return $this->morphToMany('App\Models\Tour\Tour', 'tourable');
    }
}
