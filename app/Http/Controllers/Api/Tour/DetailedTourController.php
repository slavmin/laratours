<?php

namespace App\Http\Controllers\Api\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Tour\TourAttendant;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourExtra;
use App\Models\Tour\TourGuide;
use App\Models\Tour\TourHotel;
use App\Models\Tour\TourMeal;
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

      case 'hotel':
        $hotel_options = TourHotel::with('objectables')->get();
        $tour_date = $tour->dates[0]->date;
        $nights = $tour->nights;

        foreach ($hotel_options as $hotel) {
          foreach ($hotel->objectables as $object) {
            $object['prices'] = $this->getObjectPrices($object->id);
          }
        }

        $tour_object_attributes = [];
        foreach ($tour->object_attributes as $attr) {
          $tour_object_attributes[] = $attr->id;
        }

        $customers = TourCustomerType::all()->pluck('name', 'id');

        $result = [
          'hotel_options'     => $hotel_options,
          'tour_date'         => $tour_date,
          'nights'            => $nights,
          'object_attributes' => $tour_object_attributes,
          'customers'         => $customers,
        ];
        break;

      case 'meal':
        $meal_options = TourMeal::with('objectables')->get();
        $tour_date = $tour->dates[0]->date;
        $days = $tour->duration;

        foreach ($meal_options as $meal) {
          foreach ($meal->objectables as $object) {
            $object['prices'] = $this->getObjectPrices($object->id);
          }
        }

        $tour_object_attributes = [];
        foreach ($tour->object_attributes as $attr) {
          $tour_object_attributes[] = $attr->id;
        }

        $customers = TourCustomerType::all()->pluck('name', 'id');

        $result = [
          'meal_options'      => $meal_options,
          'tour_date'         => $tour_date,
          'days'              => $days,
          'object_attributes' => $tour_object_attributes,
          'customers'         => $customers,
        ];
        break;

      case 'guide':
        $guide_options = TourGuide::all();
        $tour_date = $tour->dates[0]->date;
        $days = $tour->duration;

        foreach ($guide_options as $guide) {
          $guide['prices'] = $this->getObjectPrices($guide->id);
        }

        $choosen_guides = [];
        foreach ($tour->guides as $guide) {
          $choosen_guides[] = $guide->id;
        }

        $customers = TourCustomerType::all()->pluck('name', 'id');

        $result = [
          'guide_options'     => $guide_options,
          'tour_date'         => $tour_date,
          'days'              => $days,
          'choosen_guides'    => $choosen_guides,
          'customers'         => $customers,
        ];
        break;

      case 'attendant':
        $attendant_options = TourAttendant::all();
        $tour_date = $tour->dates[0]->date;
        $days = $tour->duration;

        foreach ($attendant_options as $attendant) {
          $attendant['prices'] = $this->getObjectPrices($attendant->id);
        }

        $choosen_attendants = [];
        foreach ($tour->attendants as $attendant) {
          $choosen_attendants[] = $attendant->id;
        }

        $customers = TourCustomerType::all()->pluck('name', 'id');

        $result = [
          'attendant_options'     => $attendant_options,
          'tour_date'             => $tour_date,
          'days'                  => $days,
          'choosen_attendants'    => $choosen_attendants,
          'customers'             => $customers,
        ];
        break;

      case 'freeadl':
        $freeadls = TourObjectAttributeProperties::where('tour_id', $tour->id)->where('object_type', 'freeadl')->get();
        $tour_date = $tour->dates[0]->date;
        $days = $tour->duration;

        $result = [
          'freeadls'      => $freeadls,
          'tour_date'     => $tour_date,
          'days'          => $days,
        ];
        break;

      case 'tour':
        $tour = Tour::find($tour_id);

        $object_attributes = $tour->object_attributes;
        $transport = [];
        $museum = [];
        $meal = [];
        $hotel = [];

        foreach ($object_attributes as $attr) {


          switch ($attr->objectable_type) {
            case ("App\Models\Tour\TourTransport"):
              $attr['properties'] = TourObjectAttributeProperties::where('tour_id', $tour_id)
                ->where('object_type', 'transport')
                ->where('object_attribute_id', $attr->id)
                ->first();
              $transport[] = $attr;
              break;
            case ("App\Models\Tour\TourMuseum"):
              $attr['properties'] = TourObjectAttributeProperties::where('tour_id', $tour_id)
                ->where('object_type', 'museum')
                ->where('object_attribute_id', $attr->id)
                ->first();
              $attr['prices'] = $this->getObjectPrices($attr->id);
              $museum[] = $attr;
              break;
            case ("App\Models\Tour\TourHotel"):
              $attr['properties'] = TourObjectAttributeProperties::where('tour_id', $tour_id)
                ->where('object_type', 'hotel')
                ->where('object_attribute_id', $attr->id)
                ->first();
              $attr['prices'] = $this->getObjectPrices($attr->id);
              $hotel[] = $attr;
              break;
            case ("App\Models\Tour\TourMeal"):
              $attr['properties'] = TourObjectAttributeProperties::where('tour_id', $tour_id)
                ->where('object_type', 'meal')
                ->where('object_attribute_id', $attr->id)
                ->first();
              $attr['prices'] = $this->getObjectPrices($attr->id);
              $meal[] = $attr;
              break;
          }
        }
        $guide = $tour->guides;
        foreach ($guide as $g) {
          $g['prices'] = $this->getObjectPrices($g->id);
          $g['properties'] = TourObjectAttributeProperties::where('tour_id', $tour_id)
            ->where('object_type', 'guide')
            ->where('object_attribute_id', $g->id)
            ->first();
        }

        $attendant = $tour->attendants;
        foreach ($attendant as $at) {
          $at['prices'] = $this->getObjectPrices($at->id);
          $at['properties'] = TourObjectAttributeProperties::where('tour_id', $tour_id)
            ->where('object_type', 'attendant')
            ->where('object_attribute_id', $at->id)
            ->first();
        }

        $customers = TourCustomerType::select('id', 'name')
          ->get()
          ->toArray();

        $extras = TourExtra::where('tour_id', $tour->id)
          ->select('id', 'name', 'value', 'commission', 'margin')
          ->get()
          ->toArray();

        $result = [
          'transport'         => $transport,
          'museum'            => $museum,
          'hotel'             => $hotel,
          'meal'              => $meal,
          'guide'             => $guide,
          'attendant'         => $attendant,
          'customers'         => $customers,
          'extras'            => $extras,
          'tour_qnt'          => $tour->qnt,
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
      $properties = TourObjectAttributeProperties::where('tour_id', $request->tour_id)
        ->where('object_type', $request->object_type)
        ->where('object_attribute_id', $request->object_attribute_id)
        ->first();
    }

    $properties->object_attribute_id = $request->object_attribute_id;
    $properties->object_type = $request->object_type;
    $properties->tour_id = $request->tour_id;
    $properties->tour_price_type_id = $request->tour_price_type_id ?? null;
    $properties->value = $request->value ?? null;
    $properties->duration = $request->duration ?? null;
    $properties->days_array = json_encode($request->get('days_array[]')) ?? null;
    $properties->days = $request->days ?? null;
    $properties->hotel = $request->hotel ?? null;
    $properties->meal = $request->meal ?? null;
    $properties->events = json_encode($request->get('events[]')) ?? null;
    $properties->name = $request->name ?? null;

    $properties->save();

    $tour = Tour::find($request->tour_id);

    switch ($request->object_type) {
      case 'guide':
        $guide = TourGuide::find($request->object_attribute_id);
        $tour->guides()->attach($guide);
        break;
      case 'attendant':
        $attendant = TourAttendant::find($request->object_attribute_id);
        $tour->attendants()->attach($attendant);
        break;
      default:
        $object_attribute = TourObjectAttributes::find($request->object_attribute_id);
        $tour->object_attributes()->attach($object_attribute);
    }

    return 'ok';
  }

  public function addOrUpdateDetailedTourExtra(Request $request)
  {
    $extra_id = $request->extra_id;
    TourExtra::updateOrCreate(['id' => $extra_id], $request->all());
  }

  public function getDetailedTourExtras(Request $request)
  {
    $tour_id = $request->tour_id;
    $tour_extras = TourExtra::where('tour_id', $tour_id)
      ->select('id', 'name', 'value', 'margin', 'commission')
      ->get();
    return $tour_extras;
  }

  public function deleteDetailedTourExtra(Request $request)
  {
    $tour_extra = TourExtra::find($request->extra_id);
    $tour_extra->delete();
    return $tour_extra;
  }

  public function getDetailedTourObjectAttributeProperties(Request $request)
  {
    $result = TourObjectAttributeProperties::where('tour_id', $request->tour_id)
      ->where('object_type', $request->object_type)
      ->where('object_attribute_id', $request->object_attribute_id)
      ->first();
    return $result;
  }

  public function updateDetailedTourObjectAttributeProperty(Request $request)
  {
    $is_extra = $request->is_extra;
    if (!$is_extra) {
      $property = TourObjectAttributeProperties::where('object_attribute_id', $request->object_attribute_id)
        ->where('tour_id', $request->tour_id)->first();
      $property['margin'] = $request->margin ?? 0;
      $property['commission'] = $request->commission ?? 0;
      $property->save();
    } else {
      $tour_extra = TourExtra::find($request->object_attribute_id);
      $tour_extra['margin'] = $request->margin ?? 0;
      $tour_extra['commission'] = $request->commission ?? 0;
      $tour_extra->save();
    }
  }

  public function removeDetailedTourObjectAttribute(Request $request)
  {
    $tour = Tour::find($request->tour_id);

    switch ($request->object_type) {
      case 'guide':
        $tour->guides()->detach($request->object_attribute_id);
        break;
      case 'attendant':
        $tour->attendants()->detach($request->object_attribute_id);
        break;
      case 'freeadl':
        $tour->object_attributes()->detach($request->object_attribute_id);
        $properties = TourObjectAttributeProperties::find($request->object_attribute_id);
        $properties->forceDelete();
        break;
      default:
        $tour->object_attributes()->detach($request->object_attribute_id);
    }

    $properties = TourObjectAttributeProperties::where('tour_id', $request->tour_id)
      ->where('object_attribute_id', $request->object_attribute_id)
      ->where('object_type', $request->object_type)
      ->first();
    if ($properties) {
      $properties->forceDelete();
    }
  }

  public static function saveDetailedTourPrices(Request $request)
  {
    $prices_array = $request->prices_array;
    $tour = Tour::find($request->tour_id);

    $saved_prices = $tour->priceable;

    foreach ($saved_prices as $price) {
      $tour->priceable()->delete($price->id);
    }

    foreach ($prices_array as $price) {
      $tour->priceable()->updateOrCreate(
        ['id' => 0],
        [
          'tour_id' => $tour->id,
          'price' => $price['price'],
          'tour_customer_type_id' => $price['id'],
        ]
      );
    }
    return 'ok';
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
