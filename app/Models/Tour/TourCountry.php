<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;

class TourCountry extends Model
{
    use SoftDeletes, UsedByTeams, HasPagination, ActionButtonsAttribute;

    protected $fillable = ['name', 'description'];

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'country';
    }

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
