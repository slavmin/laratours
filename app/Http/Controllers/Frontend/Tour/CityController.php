<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourCountry;

class CityController extends Controller
{
    protected $city;

    protected $country;

    protected $city_id;

    protected $country_id;


    public function index($country_id)
    {
        $country = TourCountry::findOrFail($country_id);
        $cities = TourCity::where('country_id', $country_id)->get();

        return view('frontend.tour.city.index', compact('cities'))->with('country', $country);
    }

    public function show()
    {
        return false;
    }

    public function create($country_id)
    {
        return view('frontend.tour.city.create')->with('country_id', $country_id);
    }

    public function store(Request $request, $country_id)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $country = TourCountry::findOrFail($country_id);

        $city = new TourCity([
            'name' => $request->get('name'),
            'description'=> '',
        ]);

        $country->cities()->save($city);

        return redirect()->route('frontend.tour.city.index', $country_id)->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($country_id, $city_id)
    {
        $city = TourCity::findOrFail($city_id);

        return view('frontend.tour.city.edit', compact('city'))->with('country_id', $country_id);
    }


    public function update(Request $request, $country_id, $city_id)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $city = TourCity::findOrFail($city_id);

        $city->update([
            'name' => $request->get('name'),
        ]);

        return redirect()->route('frontend.tour.city.index', $country_id)->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($country_id, $city_id)
    {
        $city = TourCity::findOrFail($city_id);
        $city->delete();

        return redirect()->route('frontend.tour.city.index', $country_id)->withFlashWarning(__('alerts.general.deleted'));
    }
}
