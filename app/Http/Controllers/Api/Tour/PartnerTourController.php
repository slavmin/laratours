<?php

namespace App\Http\Controllers\Api\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Tour\TourPrice;
use Illuminate\Http\Request;


class PartnerTourController extends Controller
{
  public function updatePartnerTourData(Request $request)
  {
    $tour_id = $request->tour_id;

    $tour = Tour::find($tour_id);

    $tour->commission = $request->commission;
    $tour->extra = $request->extra;

    $tour->save();

    return 'ok';
  }

  public function createPartnerTourPrice(Request $request)
  {
    $tour = Tour::find($request->tour_id);

    $item_id = 0;

    $result = $tour->priceable()->updateOrCreate(
      ['id' => $item_id],
      [
        'name'  => $request->price_name,
        'price' => $request->price_value,
        'is_extra' => $request->is_extra,
      ]
    );

    return $result;
  }

  public function editPartnerTourPrice(Request $request)
  {
    $price_id = $request->price_id;
    $price = TourPrice::find($price_id);

    $price->name = $request->price_name;
    $price->price = $request->price_value;

    $price->save();

    return $price;
  }

  public function deletePartnerTourPrice(Request $request)
  {
    $price_id = $request->price_id;
    $price = TourPrice::find($price_id);
    $price->delete();
    return $price;
  }

  public function getPartnerTourPrices(Request $request)
  {
    $tour_id = $request->tour_id;

    $tour = Tour::find($tour_id);
    if ($request->is_extra) {
      $result = $tour->priceable()->where('is_extra', 1)->select('id', 'name', 'price', 'is_extra')->get();
    } else {
      $result = $tour->priceable()->where('is_extra', 0)->select('id', 'name', 'price', 'is_extra')->get();
    }

    return $result;
  }
}
