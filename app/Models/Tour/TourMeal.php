<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use App\Models\Traits\HasProfile;
use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tour\Traits\UsedByCity;
use App\Models\Tour\Traits\HasObjectAttributes;
use App\Models\Traits\HasPagination;

class TourMeal extends Model
{
    use SoftDeletes, UsedByTeams, UsedByCity, HasPagination, HasProfile, HasObjectAttributes, ActionButtonsAttribute;

    protected $fillable = ['name', 'city_id', 'description', 'qnt'];

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'meal';
    }

    public function tours()
    {
        return $this->morphToMany('App\Models\Tour\Tour', 'tourable');
    }
}
