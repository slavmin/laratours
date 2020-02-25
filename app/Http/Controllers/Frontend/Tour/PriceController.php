<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Tour\TourAttendant;
use App\Models\Tour\TourGuide;
use App\Models\Tour\TourHotel;
use App\Models\Tour\TourMeal;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourObjectAttributes;
use App\Models\Tour\TourPrice;
use App\Models\Tour\TourTransport;
use Illuminate\Http\Request;

class PriceController extends Controller
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
    $parent_id = $request->get('parent_id');

    switch ($request->get('parent_model')) {
      case 'guide':
        $parent = TourGuide::findOrFail($parent_id);
        break;
      case 'attendant':
        $parent = TourAttendant::findOrFail($parent_id);
        break;
      default:
        $parent = TourObjectAttributes::findOrFail($parent_id);
    };

    $item_id = 0;

    $prices_array = [];
    foreach (json_decode($request->prices_array) as $price) {
      // Skip price for customer, if price == 0 and flag 'is_free' setted to false.
      if ($price->price == 0 && $price->is_free != 1) {
        continue;
      }
      $parent->priceable()->updateOrCreate(
        ['id' => $item_id],
        [
          'period_start' => $request->period_start,
          'period_end' => $request->period_end,
          'price' => $price->price,
          'tour_customer_type_id' => $price->tour_customer_type_id
        ]
      );
    }
    // dd(__METHOD__, $prices_array, $request->all());

    // $parent->priceable()->updateOrCreate(
    //   ['id' => $item_id],
    //   [
    //     'period_start' => $request->period_start,
    //     'period_end' => $request->period_end,
    //     'price' => $request->price,
    //     'tour_customer_type_id' => $request->tour_customer_type_id ?? null
    //   ]
    // );


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
    //
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
    dd(__METHOD__);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    // dd(__METHOD__);
    $item = TourPrice::findOrFail($id);
    $item->delete();

    return redirect()->back()->withFlashWarning(__('alerts.general.deleted'));
  }
}
