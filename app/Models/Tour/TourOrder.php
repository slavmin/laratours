<?php

namespace App\Models\Tour;

use App\Events\Frontend\Order\OrderStatusChanged;
use App\Models\Auth\User;
use App\Models\Document\Document;
use App\Models\Tour\Traits\Attribute\OrderButtonsAttribute;
use App\Models\Traits\HasProfile;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;


class TourOrder extends Model implements AuditableInterface
{
  use UsedByTeams, HasPagination, HasProfile, SoftDeletes, OrderButtonsAttribute, Auditable;

  protected $fillable = [
    'status',
    'total_price',
    'total_paid',
    'commission',
    'discount',
    'tax',
    'invoice',
    'email',
    'phone',
    'contact_name'
  ];

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

  /**
   * @return mixed
   */
  public static function getTourInfos()
  {
    $columns = ['id', 'name', 'cities_list', 'extra', 'deleted_at'];

    $tours = Tour::select($columns)->orderBy('name', 'asc')->get()->keyBy('id')->toArray();

    $trashed_tours = Tour::onlyTrashed()->select($columns)->orderBy('name', 'asc')->get()->keyBy('id')->toArray();

    $result = [];

    // Add 'ordered_qnt' field and it's value to all tourinfos
    foreach ($tours as $tour) {
      $tour['ordered_qnt'] = Tour::find($tour['id'])->ordered_qnt;
      $result[$tour['id']] = $tour;
    }
    foreach ($trashed_tours as $tour) {
      $tour['ordered_qnt'] = Tour::onlyTrashed()->find($tour['id'])->ordered_qnt;
      $result[$tour['id']] = $tour;
    }

    return $result;
  }

  protected static function boot()
  {
    parent::boot();

    static::updating(function (TourOrder $model) {
      if ($model->getOriginal('status') != $model->status) {
        event(new OrderStatusChanged($model));
      }
    });

    static::deleting(function (Model $model) {
      if (!$model->isForceDeleting()) {
        $model->status = 4;
        $model->save();
      }
    });
  }

  /**
   * Возвращает документы для туриста и агентства.
   * Принимает id заказа
   * 
   * @param $order_id
   */
  public function getSharedDocuments($order_id)
  {

    $order = TourOrder::where('id', $order_id)->first();

    $documents = new Collection();

    // Если статус "оплачено" и выше
    if ($order->status >= 2) {
      $documents =
        Document::whereIn('team_id', [$order->team_id, $order->operator_id])
        ->where('pdf_for_agent', 1)
        ->orWhere('pdf_for_tourist', 1)
        ->AllTeams()
        ->get();
    }

    return $documents;
  }
}
