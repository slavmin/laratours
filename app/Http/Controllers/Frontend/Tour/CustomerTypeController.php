<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourCustomerType;

class CustomerTypeController extends Controller
{
    protected $tour_customer_type;

    protected $deleted;


    public function index()
    {
        $orderBy = 'name';
        $sort = 'asc';

        $model_alias = TourCustomerType::getModelAliasAttribute();

        $items = TourCustomerType::orderBy($orderBy, $sort)->paginate();
        $deleted = TourCustomerType::onlyTrashed()->get();

        return view('frontend.tour.customer.type.index', compact('items','deleted'))
            ->with('object', $model_alias);
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.customer.type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $tour_customer_type = new TourCustomerType($request->only('name', 'description'));

        $tour_customer_type->save();

        return redirect()->route('frontend.tour.customer-type.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourCustomerType::findOrFail($id);

        return view('frontend.tour.customer.type.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $tour_customer_type = TourCustomerType::findOrFail($id);

        $tour_customer_type->update($request->only('name', 'description'));

        return redirect()->route('frontend.tour.customer-type.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $tour_customer_type = TourCustomerType::findOrFail($id);
        $tour_customer_type->delete();

        return redirect()->route('frontend.tour.customer-type.index')->withFlashWarning(__('alerts.general.deleted'));
    }

    public function restore($id)
    {
        $tour_customer_type = TourCustomerType::withTrashed()->find($id);

        if ($tour_customer_type->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($tour_customer_type->restore()) {
            return redirect()->route('frontend.tour.customer-type.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $tour_customer_type = TourCustomerType::withTrashed()->find($id);

        if ($tour_customer_type->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $tour_customer_type->forceDelete();

        return redirect()->route('frontend.tour.customer-type.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
