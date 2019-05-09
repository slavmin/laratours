<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourCountry;

class CountryController extends Controller
{
    protected $country;

    public function __construct(TourCountry $country){
        $this->country = $country;
    }

    public function index()
    {
        $countries = TourCountry::all();
        return view('frontend.tour.country.index', compact('countries'));
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.country.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $country = new TourCountry([
            'name' => $request->get('name'),
        ]);

        $country->save();

        return redirect()->route('frontend.tour.country.index')->withFlashSuccess(__('alerts.frontend.tours.countries.created'));
    }


    public function edit($id)
    {
        $country = TourCountry::findOrFail($id);

        return view('frontend.tour.country.edit', compact('country'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $country = TourCountry::findOrFail($id);

        $country->update([
            'name' => $request->get('name'),
        ]);

        return redirect()->route('frontend.tour.country.index')->withFlashSuccess(__('alerts.frontend.tours.countries.updated'));
    }


    public function destroy($id)
    {
        $country = TourCountry::findOrFail($id);
        $country->delete();

        return redirect()->route('frontend.tour.country.index')->withFlashSuccess(__('alerts.frontend.tours.countries.deleted'));
    }
}
