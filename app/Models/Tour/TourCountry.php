<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\UsedByTeams;

class TourCountry extends Model
{
    use SoftDeletes, UsedByTeams;

    protected $fillable = ['name', 'description'];

    public function cities()
    {
        return $this->hasMany('App\Models\Tour\TourCity', 'country_id')->withTrashed();
    }


    protected static function boot()
    {
        parent::boot();

        static::restored(function (Model $model) {
            DB::transaction(function () use ($model) {
                $model->cities()->restore();
            });
        });

        static::deleted(function (Model $model) {
            DB::transaction(function () use ($model) {
                if ($model->isForceDeleting()) {
                    $model->cities()->forceDelete();
                } else {
                    if ($model->trashed()) {
                        // Delete permanently trashed cities when country soft deleted?
                        $model->cities()->whereNotNull('deleted_at')->forceDelete();
                        $model->cities()->delete();
                    }
                }
            });
        });
    }
}
