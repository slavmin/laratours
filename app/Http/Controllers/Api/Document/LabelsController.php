<?php

namespace App\Http\Controllers\Api\Document;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\Team;
use App\Repositories\Frontend\Api\Document\LabelsRepository;

class LabelsController extends Controller
{
    /**
     * @var LabelsRepository
     */
    private $labelsRepository;

    /**
     * LabelsController constructor.
     */
    public function __construct()
    {
        $this->labelsRepository = app(LabelsRepository::class);
    }
    
    public function getInfo(Request $request) 
    {
        if ($request->for_editor) 
        {
            $labels = $this->labelsRepository->labelsList();

            return response()->json([compact('labels')]);
        }

        if ($request->team_mode) 
        {
            $labels = $this->labelsRepository->getTeamLabelsWithValues($request->team_id);
        }

        if ($request->tourist_mode)
        {
            $order_id = $request->order_id;
            $tour_id = $request->tour_id;

            $labels = $this->labelsRepository->getTouristLabelsWithValues($order_id, $tour_id);
        }

        return response()->json([$labels]);
    }
}
