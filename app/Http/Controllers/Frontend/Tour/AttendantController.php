<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourAttendant;

class AttendantController extends Controller
{
    protected $attendant;


    public function index()
    {
        $orderBy = 'name';
        $sort = 'asc';

        $items = TourAttendant::orderBy($orderBy, $sort)->paginate();
        $deleted = TourAttendant::onlyTrashed()->get();

        return view('frontend.tour.attendant.index', compact('items', 'deleted'));
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.attendant.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'description'=> '',
        ]);

        $attendant = new TourAttendant($request->only('name', 'description', 'price'));

        $attendant->save();

        return redirect()->route('frontend.tour.attendant.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourAttendant::findOrFail($id);

        return view('frontend.tour.attendant.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            //'description'=> '',
        ]);

        $attendant = TourAttendant::findOrFail($id);

        $attendant->update($request->only('name', 'description', 'price'));

        return redirect()->route('frontend.tour.attendant.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $attendant = TourAttendant::findOrFail($id);
        $attendant->delete();

        return redirect()->route('frontend.tour.attendant.index')->withFlashWarning(__('alerts.general.deleted'));
    }

    public function restore($id)
    {
        $attendant = TourAttendant::withTrashed()->find($id);

        if ($attendant->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($attendant->restore()) {
            return redirect()->route('frontend.tour.attendant.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $attendant = TourAttendant::withTrashed()->find($id);

        if ($attendant->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $attendant->forceDelete();

        return redirect()->route('frontend.tour.attendant.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
