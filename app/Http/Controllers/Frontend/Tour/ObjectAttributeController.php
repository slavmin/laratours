<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourHotel;
use App\Models\Tour\TourMeal;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourObjectAttributes;
use App\Models\Tour\TourPrice;
use App\Models\Tour\TourTransport;
use App\Repositories\Frontend\Tour\ObjectAttributeRepository;
use Illuminate\Http\Request;

class ObjectAttributeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $parent_model_id = $request->get('parent_model_id');
    $parent_model_alias = $request->get('parent_model_alias');

    if ($request->get('attribute')) {
      $request->validate([
        'parent_model_id' => 'required|exists:tour_' . $parent_model_alias . 's,id',
        'parent_model_alias' => 'required',
        'name' => 'required|min:3',
      ]);
    }

    switch ($parent_model_alias) {
      case 'hotel':
        $parent = TourHotel::findOrFail($parent_model_id);
        break;

      case 'meal':
        $parent = TourMeal::findOrFail($parent_model_id);
        break;

      case 'museum':
        $parent = TourMuseum::findOrFail($parent_model_id);
        break;

      case 'transport':
        $parent = TourTransport::findOrFail($parent_model_id);
        break;

      default:
        # code...
        break;
    }

    $item = $request->all();
    $item_id = !empty($item['id']) ? intval($item['id']) : 0;

    $object_attribute = $parent->objectables()->updateOrCreate(
      ['id' => $item_id],
      [
        'name' => $item['name'],
        'qnt' => $item['qnt'] ?? null,
        'description' => $item['description'] ?? null,
        'price' => $item['price'] ?? null,
        'extra' => $item['extra'] ?? null,
        'customer_type_id' => $item['customer_type_id'] ?? null,
      ]
    );

    // if (is_array($request->prices)) {
    //   $prices = [];
    //   foreach ($request->prices as $priceObj) {
    //     $price = json_decode($priceObj);
    //     $price = [
    //       'period_start'          => $price->period_start,
    //       'period_end'            => $price->period_end,
    //       'price'                 => $price->price,
    //       'tour_customer_type_id' => $price->tour_customer_type_id ?? '',
    //     ];
    //     !empty($price) ? $prices[] = $price : null;
    //   }
    //   $object_attribute->priceable()->createMany($prices);
    // }

    return redirect()->back()->withFlashSuccess(__('alerts.general.updated'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $tour_object_data = (new ObjectAttributeRepository)->getTourObjectData($id);

    return view('frontend.tour.object.includes.object-attribute', $tour_object_data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    if ($request->get('attribute')) {
      $request->validate([
        'name' => 'required|min:3',
      ]);
    }



    $item = TourObjectAttributes::findOrFail($id);

    $item->update($request->all());

    // if (is_array($request->prices)) {
    //   $prices = [];
    //   foreach ($request->prices as $priceObj) {
    //     $price = json_decode($priceObj);
    //     $price = [
    //       'period_start'          => $price->period_start,
    //       'period_end'            => $price->period_end,
    //       'price'                 => $price->price,
    //       'tour_customer_type_id' => $price->tour_customer_type_id ?? '',
    //     ];
    //     !empty($price) ? $prices[] = $price : null;
    //   }
    //   // dd($prices);
    //   TourPrice::where(['priceable_id' => $item->id])->delete();
    //   $item->priceable()->createMany($prices);
    // }

    return redirect()->back()->withFlashSuccess(__('alerts.general.updated'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $item = TourObjectAttributes::findOrFail($id);
    $item->delete();

    return redirect()->back()->withFlashWarning(__('alerts.general.deleted'));
  }
}
