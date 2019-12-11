<?php

namespace App\Http\Controllers\Api\Document;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    
    public function getInfo(Request $request) {
        
        $labels = $this->labelsRepository->getLabels();
        
        return response()->json([
            compact('labels')
        ]);
    }
}
