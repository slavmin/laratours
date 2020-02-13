<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\TourHotel;
use App\Models\Tour\TourMeal;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourObjectAttributes;
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
    $attribute_id = $request->get('attribute_id');
    $attribute = TourObjectAttributes::findOrFail($attribute_id);

    $item_id = 0;

    $attribute->priceable()->updateOrCreate(
      ['id' => $item_id],
      [
        'period_start' => '2020-01-01',
        'period_end' => '2020-01-31',
        'price' => 1500,
      ]
    );

    return redirect()->back()->withFlashSuccess(__('alerts.general.updated'));
    // dd(__METHOD__, $request->all(), $attribute_id, $attribute);

    // if ($request->get('attribute')) {
    //   $request->validate([
    //     'parent_model_id' => 'required|exists:tour_' . $parent_model_alias . 's,id',
    //     'parent_model_alias' => 'required',
    //     'name' => 'required|min:3',
    //     'price' => 'required',
    //     'customer_type_id' => 'nullable|exists:tour_customer_types,id',
    //   ]);
    // }
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
    dd(__METHOD__);
    // $item = TourObjectAttributes::findOrFail($id);
    // $item->delete();

    // return redirect()->back()->withFlashWarning(__('alerts.general.deleted'));
  }
}
