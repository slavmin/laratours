<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use App\Filters\ToursFilter;
use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Tour\TourConstructorType;
use App\Models\Tour\TourCustomer;
use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourType;
use App\Repositories\Frontend\Tour\TourRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    protected $tour;

    protected $city_id;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $city_id = $this->getCityId($request);

        $type_id = $this->getTourTypeId($request);

        $orderBy = 'id';
        $sort = 'desc';

        $model_alias = Tour::getModelAliasAttribute();

        $items = Tour::with('dates')->with(['orderprofiles' => function ($query) {
            $query->select(['profiles.profileable_id as order_id', 'profiles.type', 'profiles.content']);
        }]);

        $items = (new ToursFilter($items, $request))->apply()->orderBy($orderBy, $sort)->paginate();

        $deleted = Tour::onlyTrashed()->get();

        $cities_names = Tour::getCitiesAttribute();

        $cities_select = Tour::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        $tour_types = TourType::getTourTypesAttribute(__('validation.attributes.frontend.general.select'));

        $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));

        $req_params = $request->all();

        return view('frontend.tour.tour.index', compact('items', 'cities_names', 'cities_select', 'tour_types', 'deleted', 'req_params'))
            ->with('city_id', (int) $city_id)
            ->with('type_id', (int) $type_id)
            ->with('route', route('frontend.tour.' . $model_alias . '.store'))
            ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
            ->with('customer_type_options', $customer_type_options)
            ->with('model_alias', $model_alias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $model_alias = Tour::getModelAliasAttribute();

        $city_id = $this->getCityId($request);

        $countries_cities_options = Tour::getCountriesWithCities();

        // TO DO to be removed
        //$cities_options = Tour::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));
        $cities_options = Tour::getAllCities();

        $tour_type_options = TourType::getTourTypesAttribute(__('validation.attributes.frontend.general.select'));

        $constructor_type_options = TourConstructorType::select('id', 'name')->get()->toArray();


        return view('frontend.tour.tour.create', compact('cities_options', 'countries_cities_options', 'tour_type_options', 'constructor_type_options'))
            ->with('method', 'POST')
            ->with('action', 'create')
            ->with('route', route('frontend.tour.' . $model_alias . '.store'))
            ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
            ->with('item', [])
            ->with('city_id', (int) $city_id)
            ->with('model_alias', $model_alias);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'exists:tour_cities,id',
            'country_id' => 'exists:tour_countries,id',
            'tour_type_id' => 'required|exists:tour_types,id',
            'cities_list' => 'array|required|min:1',
            'countries_list' => 'array|required|min:1',
        ]);

        $tour_id = DB::transaction(function () use ($request) {
            $tour = new Tour($request->all());
            $tour->save();

            // Add tour dates
            if (is_array($request->get('dates'))) {
                $tour_dates = [];
                foreach ($request->get('dates') as $date) {
                    !empty($date) ? $tour_dates[] = ['date' => $date] : null;
                }
                $tour->dates()->createMany($tour_dates);
            }

            return $tour->id;
        });

        return redirect()->route('frontend.tour.tour.show', $tour_id)->withFlashSuccess(__('alerts.general.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $model_alias = Tour::getModelAliasAttribute();

        $tour = Tour::find($id);

        switch ($tour->tour_constructor_type_id) {
            case (1):
                $view = 'frontend.tour.tour.detailed.index';
                break;
            case (2):
                $view = 'frontend.tour.tour.partner.index';
                break;
            default:
                return redirect()
                    ->route('frontend.tour.tour.index')
                    ->withErrors(['msg' => 'Ошибка при переходе в конструктор тура']);
        }

        $compact = (new TourRepository)->getTourOptions($tour->id);

        return view($view, $compact)
            ->with('tour_id', $tour->id)
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('route', route('frontend.tour.' . $model_alias . '.update', [$tour->id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $model_alias = Tour::getModelAliasAttribute();

        //$item = Tour::whereId($id)->withAll()->first();

        $item = Tour::findOrFail($id);

        $attributes = $item->getAllAttributes();

        $tour_dates = $item->tour_dates;

        $countries_cities_options = Tour::getCountriesWithCities();

        // TO DO to be removed
        $cities_options = Tour::getAllCities();

        $tour_type_options = TourType::getTourTypesAttribute(__('validation.attributes.frontend.general.select'));

        $hotel_options = Tour::getHotelsOption();

        $museum_options = Tour::getMuseumsOption();

        $transport_options = Tour::getTransportsOption();

        $meal_options = Tour::getMealsOption();

        $guide_options = Tour::getGuidesOption();

        $attendant_options = Tour::getAttendantsOption();

        $constructor_type_options = TourConstructorType::select('id', 'name')->get()->toArray();

        return view('frontend.tour.tour.edit', compact('item', 'tour_dates', 'attributes', 'countries_cities_options', 'cities_options', 'tour_type_options', 'hotel_options', 'museum_options', 'meal_options', 'transport_options', 'attendant_options', 'guide_options', 'constructor_type_options'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('route', route('frontend.tour.' . $model_alias . '.update', [$item->id]))
            ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
            ->with('model_alias', $model_alias);
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        if ($request->toggle_published) {
            $tour->published = !$tour->published;
            $tour->save();
            return redirect()->route('frontend.tour.tour.index')->withFlashSuccess(__('alerts.general.updated'));
        }

        $request->validate([
            'name' => 'required',
            'city_id' => 'exists:tour_cities,id',
            'country_id' => 'exists:tour_countries,id',
            'tour_type_id' => 'required|exists:tour_types,id',
            'cities_list' => 'array|required|min:1',
            'countries_list' => 'array|required|min:1',
        ]);


        // MySql empty Json fix
        if (!$request->get('cities_list')) {
            $tour->update(array_merge($request->all(), ['cities_list' => null]));
        } else {
            $tour->update($request->all());
        }

        $tour_id = DB::transaction(function () use ($tour, $request) {

            if (is_array($request->get('dates'))) {
                $tour_dates = [];
                foreach ($request->get('dates') as $date) {
                    !empty($date) ? $tour_dates[] = ['date' => $date] : null;
                }
                $tour->dates()->delete();
                $tour->dates()->createMany($tour_dates);
            }

            // foreach ($tour->getAllAttributes() as $k => $v) {
            //   $input = !empty($request->get(substr($k, 0, -1) . '_id')) ? $request->get(substr($k, 0, -1) . '_id') : [];
            //   $output = [];
            //   foreach ($input as $item) {
            //     $output[$item] = ['team_id' => $tour->team_id];
            //   }
            //   $tour->$k()->sync($output);
            // }

            return $tour->id;
        });

        return redirect()->route('frontend.tour.tour.show', $tour_id)->withFlashSuccess(__('alerts.general.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();

        return redirect()->route('frontend.tour.tour.index')->withFlashWarning(__('alerts.general.deleted'));
    }

    public function restore($id)
    {
        $tour = Tour::withTrashed()->find($id);

        if ($tour->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($tour->restore()) {
            return redirect()->route('frontend.tour.tour.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $tour = Tour::withTrashed()->find($id);

        if ($tour->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $tour->forceDelete();

        return redirect()->route('frontend.tour.tour.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }

    public static function getCityId(Request $request)
    {
        $city_ids = Tour::getCityIds();
        return $request->has('city_id') && $request->query('city_id') != 0
            && in_array($request->query('city_id'), $city_ids) ? $request->query('city_id') : null;
    }

    public static function getTourTypeId(Request $request)
    {
        $type_ids = Tour::getTourTypeIds();
        return $request->has('type_id') && $request->query('type_id') != 0
            && in_array($request->query('type_id'), $type_ids) ? $request->query('type_id') : null;
    }
}
