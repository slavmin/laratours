<?php

namespace App\Models\Tour\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class HasExtendedFields
 */
trait HasObjectAttributes
{
    /**
     * @return mixed
     */
    public function objectables()
    {
        return $this->morphMany('App\Models\Tour\TourObjectAttributes', 'objectable');
    }

    /**
     * Creates, Updates and Syncronize objects in related models
     */
    public function saveObjectAttributes($attributes)
    {
        $items = collect(array_values($attributes));

        // $tmp = $this->objectables->makeHidden(['model_alias', 'team_id', 'objectable_id', 'objectable_type', 'created_at', 'updated_at'])->toArray();
        // $items = collect(array_values($tmp));

        $current = $this->objectables()->pluck('id');
        $current->each(function ($id) use ($items) {
            if (!$items->contains('id', $id)) {
                $this->objectables()->find($id)->delete();
            }
        });

        $items->each(function ($item) {
            $this->objectables()->updateOrCreate((array) $item);
        });
    }

    protected static function bootHasObjectAttributes()
    {
        static::deleted(function (Model $model) {
            DB::transaction(function () use ($model) {
                // Force Delete objectables
                if ($model->isForceDeleting()) {
                    $model->objectables()->forceDelete();
                } else {
                    // Delete objectables
                    if (!$model->trashed()) {
                        $model->objectables()->delete();
                    }
                }
            });
        });
    }
}
