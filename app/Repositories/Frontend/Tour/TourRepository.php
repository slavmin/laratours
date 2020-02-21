<?php

namespace App\Repositories\Frontend\Tour;

use App\Models\Tour\Tour;
use App\Models\Tour\TourMuseum;

/**
 *  Class TourRepository
 * 
 *  @package App\Repositories
 */
class TourRepository
{

  /**
   * @return string
   */
  public function model()
  {
    return Tour::class;
  }

  /**
   * Return compacted tour options.
   * 
   * @param $tour_id
   */
  public function getTourOptions($tour_id)
  {
    $tour = Tour::find($tour_id);

    switch ($tour->tour_constructor_type_id) {
      case (1):
        $museum_options = TourMuseum::whereIn('city_id', $tour->cities_list)->get();
        $compact = compact('museum_options');
        break;
      case (2):
        $test = 'test';
        $compact = compact('test');
        break;
    }
    return $compact;
  }
}
