<?php

namespace App\Http\Controllers\Api\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourObjectAttributeProperties;
use App\Models\Tour\TourObjectAttributes;
use App\Models\Tour\TourPrice;
use App\Models\Tour\TourPriceType;
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

        $tour_object_attributes = [];
        foreach ($tour->object_attributes as $attr) {
          $tour_object_attributes[] = $attr->id;
        }

        $result = [
          'transport_options' => $transport_options,
          'tour_date'         => $tour_date,
          'days'              => $days,
          'object_attributes' => $tour_object_attributes,
        ];
        break;
      case 'museum':
        $museum_options = TourMuseum::with('objectables')->get();
        $tour_date = $tour->dates[0]->date;
        $days = $tour->duration;

        foreach ($museum_options as $museum) {
          foreach ($museum->objectables as $object) {
            $object['prices'] = $this->getObjectPrices($object->id);
          }
        }

        $tour_object_attributes = [];
        foreach ($tour->object_attributes as $attr) {
          $tour_object_attributes[] = $attr->id;
        }

        $customers = TourCustomerType::all()->pluck('name', 'id');

        $result = [
          'museum_options' => $museum_options,
          'tour_date'         => $tour_date,
          'days'              => $days,
          'object_attributes' => $tour_object_attributes,
          'customers'         => $customers,
        ];
        break;
    }
    return $result;
  }

  public function getDetailedTourObjectAttributePrices(Request $request)
  {

    $object_attribute_id = $request->object_attribute_id;
    switch ($request->model_alias) {
      case 'transport':
        // 1 - price per hour, 4 - price per kilometer
        $result = $this->getObjectPrices($object_attribute_id, [1, 4]);
        break;
    }

    return $result;
  }

  public function getObjectPrices($object_attribute_id, $price_types = null)
  {
    $result = [];

    $price_types_names = TourPriceType::select('name', 'id')->pluck('name', 'id');

    // For transport
    if ($price_types) {
      foreach ($price_types as $price_type_id) {

        $price = TourPrice::where('priceable_id', $object_attribute_id)
          ->where('tour_price_type_id', $price_type_id)
          ->select('price')
          ->first();

        if ($price) {
          array_push($result, [
            'tour_price_type_id' => $price_type_id,
            'tour_price_type_name' => $price_types_names[$price_type_id],
            'price' => $price->price,
          ]);
        }
      }
    } else {
      // For museums
      $result = TourPrice::where('priceable_id', $object_attribute_id)
        ->select('price', 'tour_customer_type_id')
        ->get();
    }

    return $result;
  }

  public function addDetailedTourObjectAttribute(Request $request)
  {
    $properties = (new TourObjectAttributeProperties);

    if (isset($request->object_attribute_properties_id)) {
      $properties = TourObjectAttributeProperties::where('tour_id', $request->tour_id)->where('object_attribute_id', $request->object_attribute_id)->first();
    }

    $properties->object_attribute_id = $request->object_attribute_id;
    $properties->tour_id = $request->tour_id;
    $properties->tour_price_type_id = $request->tour_price_type_id ?? null;
    $properties->value = $request->value ?? null;
    $properties->duration = $request->duration ?? null;
    $properties->days_array = json_encode($request->get('days_array[]'));
    $properties->days = $request->days ?? null;

    $properties->save();

    $tour = Tour::find($request->tour_id);

    $object_attribute = TourObjectAttributes::find($request->object_attribute_id);
    $tour->object_attributes()->attach($object_attribute);

    return $tour->object_attributes;
  }

  public function getDetailedTourObjectAttributeProperties(Request $request)
  {
    $result = TourObjectAttributeProperties::where('tour_id', $request->tour_id)->where('object_attribute_id', $request->object_attribute_id)->first();
    return $result;
  }

  public function removeDetailedTourObjectAttribute(Request $request)
  {
    $tour = Tour::find($request->tour_id);

    $tour->object_attributes()->detach($request->object_attribute_id);

    $properties = TourObjectAttributeProperties::where('tour_id', $request->tour_id)->where('object_attribute_id', $request->object_attribute_id)->first();
    $properties->forceDelete();
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
