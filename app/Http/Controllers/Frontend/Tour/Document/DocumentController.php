<?php

namespace App\Http\Controllers\Frontend\Tour\Document;

use Illuminate\Http\Request;
use App\Http\Requests\Frontend\Document\DocumentUpdateRequest;
use App\Http\Requests\Frontend\Document\DocumentCreateRequest;
use App\Models\Auth\Team;
use App\Models\Document\Document;

class DocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Document::paginate();

        if ($request->expectsJson()) {
            return response()->json($items->toArray());
        }

        return view('frontend.document.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Document();

        return view('frontend.document.add', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentCreateRequest $request)
    {
        $data = $request->all();

        $item = (new Document())->create($data);

        if ($item) {
            return redirect()
                ->route('frontend.tour.document.index')
                ->withFlashSuccess(__('alerts.general.edited'));
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Document::findOrFail($id);

        return view('frontend.document.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentUpdateRequest $request, $id)
    {

        $item = Document::find($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $result = $item
            ->fill($data)
            ->save();

        if ($result) {
            return redirect()
                ->route('frontend.tour.document.index')
                ->withFlashSuccess(__('alerts.general.edited'));
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Document::findOrFail($id);
        $item->delete();

        return redirect()->route('frontend.tour.document.index')->withFlashWarning(__('alerts.general.deleted'));
    }
}
