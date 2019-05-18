<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use App\Models\Traits\HasProfile;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Tour\Traits\UsedByCity;
use App\Models\Tour\Traits\HasObjectAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasPagination;

class TourMuseum extends Model
{
    use SoftDeletes, UsedByTeams, UsedByCity, HasPagination, HasProfile, HasObjectAttributes, ActionButtonsAttribute;

    protected $fillable = ['name', 'city_id', 'description', 'qnt'];

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'museum';
    }
}
