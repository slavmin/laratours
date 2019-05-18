<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
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

    protected $deleted;


    public function index($country_id)
    {
        $orderBy = 'name';
        $sort = 'asc';

        $model_alias = TourCity::getModelAliasAttribute();

        $country = TourCountry::findOrFail($country_id);
        $items = TourCity::where('country_id', $country_id)->orderBy($orderBy, $sort)->paginate();
        $deleted = TourCity::where('country_id', $country_id)->onlyTrashed()->get();

        return view('frontend.tour.city.index', compact('items', 'deleted'))
            ->with('country', $country)
            ->with('object', $model_alias);
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
            'name' => 'required',
            //'description'=> '',
        ]);

        $country = TourCountry::findOrFail($country_id);

        $city = new TourCity($request->only('name', 'description'));

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
            'name' => 'required',
            //'description'=> '',
        ]);

        $city = TourCity::findOrFail($city_id);

        $city->update($request->only('name', 'description'));

        return redirect()->route('frontend.tour.city.index', $country_id)->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($country_id, $city_id)
    {
        $city = TourCity::findOrFail($city_id);
        $city->delete();

        return redirect()->route('frontend.tour.city.index', $country_id)->withFlashWarning(__('alerts.general.deleted'));
    }


    public function restore($country_id, $city_id)
    {
        $city = TourCity::withTrashed()->find($city_id);

        if ($city->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($city->restore()) {
            return redirect()->route('frontend.tour.city.index', $country_id)->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($country_id, $city_id)
    {
        $city = TourCity::withTrashed()->find($city_id);

        if ($city->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $city->forceDelete();

        return redirect()->route('frontend.tour.city.index', $country_id)->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
