<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\OrderButtonsAttribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class TourOrder extends Model
{
    use UsedByTeams, HasPagination, SoftDeletes, OrderButtonsAttribute;

    protected $fillable = ['status'];

    protected $casts = [
        'status' => 'integer'
    ];

    protected $appends = ['model_alias', 'statuses', 'by_agent', 'by_user'];

    /**
     * @return string
     */
    public static function getModelAliasAttribute()
    {
        return 'order';
    }

    /**
     * @return array
     */
    public static function getStatusesAttribute()
    {
        return [0 => 'pending', 1 => 'confirmed', 2 => 'paid', 3 => 'cancelled', 4 => 'declined', 5 => 'completed'];
    }

    /**
     * @return bool
     */
    public function getByAgentAttribute()
    {
        return $this->attributes['by_agent'] = !is_null($this->attributes['agent_id']) ? true : false;
    }

    /**
     * @return bool
     */
    public function getByUserAttribute()
    {
        return $this->attributes['by_user'] = !is_null($this->attributes['customer_id']) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tour()
    {
        return $this->hasOne('App\Models\Tour\Tour')->withDefault();
    }


    /**
     * @return mixed
     */
    public static function getTourNames()
    {
        return Tour::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function (Model $model) {
            DB::transaction(function () use ($model) {
                if ($model->isForceDeleting()) {
                    $model->customer()->delete();
                }
            });
        });
    }
}
