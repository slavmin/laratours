<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use App\Models\Traits\HasProfile;
use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tour\Traits\UsedByCity;
use App\Models\Tour\Traits\HasObjectAttributes;
use App\Models\Traits\HasPagination;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;

class TourMeal extends Model implements HasMedia
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

  protected $fillable = ['name', 'city_id', 'description', 'qnt', 'extra'];

  protected $appends = ['model_alias'];

  protected $casts = [
    'extra' => 'array',
  ];

  public static function getModelAliasAttribute()
  {
    return 'meal';
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
