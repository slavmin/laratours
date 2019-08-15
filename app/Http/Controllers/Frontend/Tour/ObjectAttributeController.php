<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\TourHotel;
use App\Models\Tour\TourMeal;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourObjectAttributes;
use App\Models\Tour\TourTransport;
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
                'price' => 'required',
                'customer_type_id' => 'nullable|exists:tour_customer_types,id',
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

        $parent->objectables()->updateOrCreate(
            ['id' => $item_id],
            [
                'name' => $item['name'],
                'qnt' => $item['qnt'] ?? null, 'price' => $item['price'] ?? null,
                'description' => $item['description'] ?? null,
                'price' => $item['price'] ?? null,
                'extra' => $item['extra'] ?? null,
                'customer_type_id' => $item['customer_type_id'] ?? null,
            ]
        );

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
        if ($request->get('attribute')) {
            $request->validate([
                'name' => 'required|min:3',
                'price' => 'required',
                'customer_type_id' => 'nullable|exists:tour_customer_types,id',
            ]);
        }

        $item = TourObjectAttributes::findOrFail($id);
        $item->update($request->all());

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