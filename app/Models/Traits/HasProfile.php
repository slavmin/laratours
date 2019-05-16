<?php


namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class HasExtendedFields
 */
trait HasProfile
{
    /**
     * @return mixed
     */
    public function profiles()
    {
        return $this->morphMany('App\Models\Profile', 'profileable');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Model $model) {
            DB::transaction(function () use ($model) {
                // Force Delete profiles
                if ($model->isForceDeleting()) {
                    $model->profiles()->forceDelete();
                } else {
                    // Delete profiles
                    if(!$model->trashed()){
                        $model->profiles()->delete();
                    }
                }
            });
        });
    }
}