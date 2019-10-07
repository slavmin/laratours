<?php

namespace App\Models\Tour;

use App\Events\Frontend\Order\OrderStatusChanged;
use App\Models\Auth\User;
use App\Models\Tour\Traits\Attribute\OrderButtonsAttribute;
use App\Models\Traits\HasProfile;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;


class TourOrder extends Model implements AuditableInterface
{
    use UsedByTeams, HasPagination, HasProfile, SoftDeletes, OrderButtonsAttribute, Auditable;

    protected $fillable = ['status', 'total_price', 'total_paid', 'commission', 'discount', 'tax', 'invoice'];

    protected $casts = [
        'status' => 'integer'
    ];

    protected $appends = ['model_alias', 'statuses', 'by_agent', 'by_user'];

    protected $auditInclude  = [
        'status',
    ];

    /**
     * @return string
     */
    public static function getModelAliasAttribute()
    {
        return 'order'; //return get_model_alias(class_basename(self::class));
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
        return $this->attributes['by_agent'] = !is_null($this->attributes['operator_id']) && $this->attributes['operator_id'] != $this->attributes['team_id']
            ? true : false;
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
        return $this->belongsTo('App\Models\Tour\Tour', 'tour_id')->withDefault();
    }

    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    /**
     * @return mixed
     */
    public static function getTourNames()
    {
        return Tour::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function (TourOrder $model) {
            if($model->getOriginal('status') != $model->status){
                event(new OrderStatusChanged($model));
            }
        });
    }

}
