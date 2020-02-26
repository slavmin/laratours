<?php

namespace App\Http\Controllers\Api\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourTransport;
use Illuminate\Http\Request;


class DetailedTourController extends Controller
{
  public function getDetailedTourObjects(Request $request)
  {
    $tour_id = $request->tour_id;
    $tour = Tour::find($tour_id);

    switch ($request->model_alias) {
      case 'transport':
        $transport_options = TourTransport::with('objectables')->get();
        $tour_date = $tour->dates[0]->date;
        $days = $tour->duration;
        $result = [
          'transport_options' => $transport_options,
          'tour_date'         => $tour_date,
          'days'              => $days,
        ];
        break;
    }
    return $result;
  }

  public static function formatOptions($arr)
  {
    $arr = $arr->map(function ($item) {
      return [
        'id' => $item->id,
        'city_id' => $item->city_id,
        'city_name' => TourCity::find($item->city_id)->name,
        'name' => $item->name,
        'description' => $item->description,
        'extra' => $item->extra,
        'qnt' => $item->qnt,
        'model_alias' => $item->model_alias,
        'objectables' => $item->objectables->map(function ($objectable) {
          return [
            'id' => $objectable->id,
            'name' => $objectable->name,
            'description' => $objectable->description,
            'qnt' => $objectable->qnt,
            'prices' => $objectable->priceable,
            'extra' => $objectable->extra,
          ];
        }),
      ];
    });

    return $arr;
  }
}
