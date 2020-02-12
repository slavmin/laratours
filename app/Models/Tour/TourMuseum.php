<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use App\Models\Traits\HasProfile;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Tour\Traits\UsedByCity;
use App\Models\Tour\Traits\HasObjectAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasPagination;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;

class TourMuseum extends Model implements HasMedia
{
  use
    SoftDeletes,
    UsedByTeams,
    UsedByCity,
    HasPagination,
    HasProfile,
    HasObjectAttributes,
    ActionButtonsAttribute,
    HasMediaTrait;

  protected $fillable = [
    'name',
    'city_id',
    'description',
    'qnt',
    'extra',
    'types_list',
    'address',
    'museum_site',
    'museum_email',
    'museum_phone',
    'staff_name',
    'staff_phone'
  ];

  protected $appends = ['model_alias'];

  protected $casts = [
    'extra' => 'array',
  ];

  public static function getModelAliasAttribute()
  {
    return 'museum';
  }

  public function tours()
  {
    return $this->morphToMany('App\Models\Tour\Tour', 'tourable');
  }

  public function registerMediaCollections()
  {
    $this->addMediaCollection('objects')->singleFile();
  }

  /**
   * @param Media|null $media
   * @throws \Spatie\Image\Exceptions\InvalidManipulation
   */
  public function registerMediaConversions(Media $media = null)
  {
    $this->addMediaConversion('thumb')
      ->crop(Manipulations::CROP_TOP, 80, 80);
    // ->nonQueued();

    $this->addMediaConversion('portrait')
      ->fit(Manipulations::FIT_FILL, 480, 480)
      ->background('ffffff');
    // ->nonQueued();
  }
}
