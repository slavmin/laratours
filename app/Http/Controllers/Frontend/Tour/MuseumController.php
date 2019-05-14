<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourCity;

class MuseumController extends Controller
{
    protected $museum;

    protected $city_id;


    public function index(Request $request)
    {
        $city_id = $this->getCityId($request);

        $city_name = TourMuseum::getCityName($city_id, __('labels.frontend.tours.all_cities'));

        $city_param = !is_null($city_id) ? 'city_id=' . $city_id : '';

        if (!is_null($city_id)) {

            $city = TourCity::where('id', $city_id)->firstOrfail();
            $items[] = $city->museums->sortBy('name');

        } else {

            $cities = TourCity::with(['museums' => function ($query) {
                $query->orderBy('name', 'asc');
            }])->orderBy('name', 'asc')->get()->flatten();

            foreach ($cities as $city) {
                $items[] = $city->museums;
            }

        }

        $deleted = TourMuseum::onlyTrashed()->get();

        $cities_names = TourMuseum::getCitiesAttribute();

        $cities_select = TourMuseum::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.museum.index', compact('items', 'cities_names', 'cities_select','deleted'))
            ->with('city_id', (int)$city_id)
            ->with('city_name', $city_name)
            ->with('city_param', $city_param);
    }

    public function show($id)
    {
        //
    }

    public function create(Request $request)
    {
        $city_id = $this->getCityId($request);

        $cities_options = TourMuseum::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.museum.create', compact('cities_options'))->with('city_id', (int)$city_id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'exists:tour_cities,id',
        ]);

        $museum = new TourMuseum($request->only('name', 'city_id', 'description', 'qnt'));

        $museum->save();

        return redirect()->route('frontend.tour.museum.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourMuseum::findOrFail($id);

        $attributes = $item->objectables->toArray();

        $attributes = !empty($attributes) ? $attributes : [0 => ['id' => 0]];

        $cities_options = TourMuseum::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.museum.edit', compact('item', 'cities_options', 'attributes'));
    }


    public function update(Request $request, $id)
    {
        if($request->get('attribute')){
            $request->validate([
                'attribute.*.name' => 'required|min:3',
                'attribute.*.price'=> 'required',
            ]);
        } else {
            $request->validate([
                'name' => 'required',
                'city_id' => 'exists:tour_cities,id',
            ]);
        }

        $museum = TourMuseum::findOrFail($id);

        $museum->update($request->only('name', 'city_id', 'description', 'qnt'));

        $museum->saveObjectAttributes($request->get('attribute'));

        return redirect()->route('frontend.tour.museum.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $museum = TourMuseum::findOrFail($id);
        $museum->delete();

        return redirect()->route('frontend.tour.museum.index')->withFlashWarning(__('alerts.general.deleted'));
    }



    public function restore($id)
    {
        $museum = TourMuseum::withTrashed()->find($id);

        if ($museum->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($museum->restore()) {
            return redirect()->route('frontend.tour.museum.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $museum = TourMuseum::withTrashed()->find($id);

        if ($museum->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $museum->forceDelete();

        return redirect()->route('frontend.tour.museum.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }


    public function getCityId(Request $request)
    {
        $city_ids = TourMuseum::getCityIds();
        return $request->has('city_id') && $request->query('city_id') != 0
        && in_array($request->query('city_id'), $city_ids) ? $request->query('city_id') : null;
    }

}
