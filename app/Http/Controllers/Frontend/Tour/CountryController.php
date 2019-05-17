<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourCountry;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    protected $country;

    protected $deleted;


    public function index()
    {
        $orderBy = 'name';
        $sort = 'asc';

        $items = TourCountry::withCount(['cities' => function ($query) {
            $query->whereNull('deleted_at');
        }])->orderBy($orderBy, $sort)->paginate();

        $deleted = TourCountry::onlyTrashed()->withCount('cities')->get();

        return view('frontend.tour.country.index', compact('items', 'deleted'));
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
            'name' => 'required',
            //'description'=> '',
        ]);

        $country = new TourCountry($request->only('name', 'description'));

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
            'name' => 'required',
            //'description'=> '',
        ]);

        $country = TourCountry::findOrFail($id);

        $country->update($request->only('name', 'description'));

        return redirect()->route('frontend.tour.country.index')->withFlashSuccess(__('alerts.frontend.tours.countries.updated'));
    }


    public function destroy($id)
    {
        $country = TourCountry::findOrFail($id);
        $country->delete();

        return redirect()->route('frontend.tour.country.index')->withFlashWarning(__('alerts.frontend.tours.countries.deleted'));
    }

    public function restore($id)
    {
        $country = TourCountry::withTrashed()->find($id);

        if ($country->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($country->restore()) {
            return redirect()->route('frontend.tour.country.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $country = TourCountry::withTrashed()->find($id);

        if ($country->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $country->forceDelete();

        return redirect()->route('frontend.tour.country.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
