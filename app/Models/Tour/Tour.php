<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use App\Models\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use App\Models\Tour\Traits\UsedByCity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Tour extends Model
{
    use Uuid, SoftDeletes, UsedByTeams, HasPagination, UsedByCity, ActionButtonsAttribute;

    protected $fillable = ['name', 'cities_list', 'city_id', 'tour_type_id', 'description', 'duration', 'commission', 'extra', 'published'];

    protected $casts = [
        'extra' => 'array',
        'cities_list' => 'array',
        'published' => 'boolean',
    ];

    protected $supportedRelations = ['dates', 'hotels', 'meals', 'museums', 'transports', 'guides', 'attendants'];

    protected $morphedRelations = ['hotels', 'meals', 'museums', 'transports', 'guides', 'attendants'];

    protected $appends = ['model_alias', 'tour_dates'];

    public static function getModelAliasAttribute()
    {
        return 'tour';
    }

    public static function findByUuid($uuid)
    {
        return self::uuid($uuid)->firstOrFail();
    }

    public function scopeWithAll($query)
    {
        return $query->with($this->supportedRelations);
    }

    public function getTourDatesAttribute()
    {
        return $this->dates()->pluck('date');
    }


    // Tour model relations

    public function hotels()
    {
        return $this->morphedByMany('App\Models\Tour\TourHotel', 'tourable')->withTimestamps();
    }

    public function meals()
    {
        return $this->morphedByMany('App\Models\Tour\TourMeal', 'tourable')->withTimestamps();
    }

    public function museums()
    {
        return $this->morphedByMany('App\Models\Tour\TourMuseum', 'tourable')->withTimestamps();
    }

    public function transports()
    {
        return $this->morphedByMany('App\Models\Tour\TourTransport', 'tourable')->withTimestamps();
    }

    public function attendants()
    {
        return $this->morphedByMany('App\Models\Tour\TourAttendant', 'tourable')->withTimestamps();
    }

    public function guides()
    {
        return $this->morphedByMany('App\Models\Tour\TourGuide', 'tourable')->withTimestamps();
    }

    public function dates()
    {
        return $this->hasMany('App\Models\Tour\TourDate', 'tour_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Tour\TourOrder', 'tour_id');
    }

    public function orderprofiles()
    {
        return $this->hasManyThrough('App\Models\Profile', 'App\Models\Tour\TourOrder', 'tour_id', 'profileable_id')->where('profileable_type', 'App\Models\Tour\TourOrder');
    }


    // Get Tour attributes
    public static function getTourTypeIds()
    {
        return TourType::pluck('id')->all();
    }

    public function getAllRelations()
    {
        $this->load($this->morphedRelations);
        return $this->getRelations();
    }

    public function getAllAttributes($out_arr = [])
    {
        $relations = $this->getAllRelations();
        foreach ($relations as $k => $v) {
            $out_arr[$k] = $v->pluck('id')->toArray();
        }
        return $out_arr;
    }


    // Get Tour Options
    public static function getGuidesOption()
    {
        return TourGuide::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
    }

    public static function getAttendantsOption()
    {
        return TourAttendant::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
    }

    public static function getTransportsOption($sort = 'no')
    {
        if ($sort == 'city') {
            return self::sortByCity(TourTransport::orderBy('name', 'asc')->get()->toArray());
        } else {
            return TourTransport::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
        }
    }

    public static function getHotelsOption($sort = 'no')
    {
        if ($sort == 'city') {
            return self::sortByCity(TourHotel::orderBy('name', 'asc')->get()->toArray());
        } else {
            return TourHotel::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
        }
    }

    public static function getMuseumsOption($sort = 'no')
    {
        if ($sort == 'city') {
            return self::sortByCity(TourMuseum::orderBy('name', 'asc')->get()->toArray());
        } else {
            return TourMuseum::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
        }
    }

    public static function getMealsOption($sort = 'no')
    {
        if ($sort == 'city') {
            return self::sortByCity(TourMeal::orderBy('name', 'asc')->get()->toArray());
        } else {
            return TourMeal::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
        }
    }

    public static function sortByCity($in_arr = [], $out_arr = [])
    {
        foreach ($in_arr as $item) {
            $out_arr[$item['city_id']][$item['id']] = $item['name'];
        }
        return $out_arr;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Model $model) {
            DB::transaction(function () use ($model) {
                if ($model->isForceDeleting()) {
                    $model->dates()->delete();
                    foreach ($model->getAllRelations() as $k => $v) {
                        $model->$k()->sync([]);
                    }
                }
            });
        });
    }
}
