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
        
        if (!$request->team_id) 
        {
            $labels = [
                'компания покупателя',
                'инн покупателя',
                'кпп покупателя',
                'адрес юридический покупателя',
                'адрес покупателя',
                'телефон покупателя',
                'рассчетный счет покупателя',
                'банк покупателя',
                'корреспондентский счет покупателя',
                'бик покупателя',
                'огрн покупателя',
                'оквэд покупателя',
                'полное название компании',
                'инн компании',
                'кпп компании',
                'адрес юридический компании',
                'адрес фактический компании',
                'телефоны компании',
                'рассчетный счет компании',
                'банк компании',
                'корреспондентский счет компании',
                'бик компании',
                'огрн компании',
                'оквэд компании',
            ];

            return response()->json([compact('labels')]);
        }

        if ($request->team_id) 
        {
            $labels = $this->labelsRepository->getLabels($request->team_id);
        }

        return response()->json([$labels]);
    }
}
