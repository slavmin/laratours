<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use App\Models\Tour\Traits\UsedByCity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Tour extends Model
{
    use Uuid, SoftDeletes, UsedByTeams, HasPagination, UsedByCity, ActionButtonsAttribute;

    protected $fillable = ['name', 'city_id', 'tour_type_id', 'description', 'duration'];

    protected $casts = [
        'extra' => 'array'
    ];

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'tour';
    }

    public static function findByUuid($uuid)
    {
        return self::uuid($uuid)->firstOrFail();
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

//    public function orders()
//    {
//        return $this->hasMany('App\Models\Tour\TourOrder', 'tour_id')->withTrashed();
//    }


    public static function getTourTypeIds()
    {
        return TourType::pluck('id')->all();
    }

    public function getAllRelations()
    {
        $this->load('hotels', 'meals', 'museums', 'transports', 'guides', 'attendants');
        return $this->getRelations();
    }

    public function getAllAttributes($out_arr = [])
    {
        $relations = $this->getAllRelations();
        foreach ($relations as $k => $v){
            $out_arr[$k] = $v->pluck('id')->toArray();
        }
        return $out_arr;
    }


    // Get Tour Options
    public static function getGuidesOption()
    {
        return TourGuide::orderBy('name', 'asc')->get()->pluck('name','id')->toArray();
    }

    public static function getAttendantsOption()
    {
        return TourAttendant::orderBy('name', 'asc')->get()->pluck('name','id')->toArray();
    }

    public static function getTransportsOption()
    {
        return self::sortByCity(TourTransport::orderBy('name', 'asc')->get()->toArray());
    }

    public static function getHotelsOption()
    {
        return self::sortByCity(TourHotel::orderBy('name', 'asc')->get()->toArray());
    }

    public static function getMuseumsOption()
    {
        return self::sortByCity(TourMuseum::orderBy('name', 'asc')->get()->toArray());
    }

    public static function getMealsOption()
    {
        return self::sortByCity(TourMeal::orderBy('name', 'asc')->get()->toArray());
    }

    public static function sortByCity($in_arr = [], $out_arr = [])
    {
        foreach ($in_arr as $item){
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
                    foreach ($model->getAllRelations() as $k => $v){
                        $model->$k()->sync([]);
                    }
                }
            });
        });
    }

//    public static function getOwnName()
//    {
//        $class_name = (new \ReflectionClass(get_called_class()))->getShortName();
//        $arr = preg_split('/(?=[A-Z])/', $class_name, -1, PREG_SPLIT_NO_EMPTY);
//        $out = str_replace('tour-', '', strtolower(implode('-', $arr)));
//        return  $out;
//    }
}
