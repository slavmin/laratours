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
        $attributes = $tour->getAllAttributes();

        $tour_dates = $tour->tour_dates;

        $hotel_options = Tour::getHotelsOption();

        $museum_options = Tour::getMuseumsOption();

        $transport_options = Tour::getTransportsOption();

        $meal_options = Tour::getMealsOption();

        $guide_options = Tour::getGuidesOption();

        $attendant_options = Tour::getAttendantsOption();
        $compact = compact('tour', 'attributes', 'hotel_options', 'museum_options', 'meal_options', 'transport_options', 'attendant_options', 'guide_options');
        break;
      case (2):
        $tour_commission = $tour->commission;
        $tour_extra = $tour->extra;
        $compact = compact('tour_commission', 'tour_extra');
        break;
    }
    return $compact;
  }
}
