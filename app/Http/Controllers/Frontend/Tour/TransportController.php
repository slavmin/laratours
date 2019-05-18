<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Models\Tour\TourCustomerType;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourTransport;

class TransportController extends Controller
{
    protected $transport;

    protected $city_id;


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $city_id = $this->getCityId($request);

        $city_name = TourTransport::getCityName($city_id, __('labels.frontend.tours.all_cities'));

        $city_param = !is_null($city_id) ? 'city_id=' . $city_id : '';

        $orderBy = 'name';
        $sort = 'asc';

        $model_alias = TourTransport::getModelAliasAttribute();

        if (!is_null($city_id)) {

            $items = TourTransport::where('city_id', $city_id)->orderBy($orderBy, $sort)->paginate();

        } else {

            $items = TourTransport::orderBy($orderBy, $sort)->paginate();

        }

        $deleted = TourTransport::onlyTrashed()->get();

        $cities_names = TourTransport::getCitiesAttribute();

        $cities_select = TourTransport::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.object.index', compact('items', 'cities_names', 'cities_select','deleted'))
            ->with('city_id', (int)$city_id)
            ->with('city_name', $city_name)
            ->with('city_param', $city_param)
            ->with('object', $model_alias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $model_alias = TourTransport::getModelAliasAttribute();

        $city_id = $this->getCityId($request);

        $cities_options = TourTransport::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.object.create', compact('cities_options'))
            ->with('city_id', (int)$city_id)
            ->with('object', $model_alias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'exists:tour_cities,id',
        ]);

        $transport = new TourTransport($request->all());

        $transport->save();

        return redirect()->route('frontend.tour.transport.index')->withFlashSuccess(__('alerts.general.created'));
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
        $model_alias = TourTransport::getModelAliasAttribute();

        $item = TourTransport::findOrFail($id);

        $attributes = $item->objectables->toArray();

        $attributes = !empty($attributes) ? $attributes : [0 => ['id' => 0]];

        $cities_options = TourTransport::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.object.edit', compact('item', 'cities_options', 'customer_type_options', 'attributes'))
            ->with('object', $model_alias);
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
        if($request->get('attribute')){
            $request->validate([
                'attribute.*.name' => 'required|min:3',
                'attribute.*.price'=> 'required',
                'attribute.*.customer_type_id' => 'nullable|exists:tour_customer_types,id',
            ]);
        } else {
            $request->validate([
                'name' => 'required',
                'city_id' => 'exists:tour_cities,id',
            ]);
        }

        $transport = TourTransport::findOrFail($id);

        $transport->update($request->all());

        $transport->saveObjectAttributes($request->get('attribute'));

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
        $transport = TourTransport::findOrFail($id);
        $transport->delete();

        return redirect()->route('frontend.tour.transport.index')->withFlashWarning(__('alerts.general.deleted'));
    }


    public function restore($id)
    {
        $transport = TourTransport::withTrashed()->find($id);

        if ($transport->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($transport->restore()) {
            return redirect()->route('frontend.tour.transport.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $transport = TourTransport::withTrashed()->find($id);

        if ($transport->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $transport->forceDelete();

        return redirect()->route('frontend.tour.transport.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }

    public static function getCityId(Request $request)
    {
        $city_ids = TourTransport::getCityIds();
        return $request->has('city_id') && $request->query('city_id') != 0
        && in_array($request->query('city_id'), $city_ids) ? $request->query('city_id') : null;
    }
}
