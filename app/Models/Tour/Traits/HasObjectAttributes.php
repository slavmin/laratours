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
        $attributes = is_array($attributes) ? array_values($attributes) : [];
        $items = collect($attributes);

        $current = $this->objectables()->pluck('id');
        $current->each(function ($id) use ($items) {
            if (!$items->contains('id', $id)) {
                $this->objectables()->find($id)->delete();
            }
        });

        $items->each(function ($item) {
            return $this->objectables()->updateOrCreate(
                ['id' => $item['id']],
                [
                    'name' => $item['name'],
                    'qnt' => $item['qnt'] ?? null, 'price' => $item['price'] ?? null,
                    'description' => $item['description'] ?? null,
                    'price' => $item['price'] ?? null,
                    'extra' => $item['extra'] ?? null,
                    'customer_type_id' => $item['customer_type_id'] ?? null,
                ]
            );
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
