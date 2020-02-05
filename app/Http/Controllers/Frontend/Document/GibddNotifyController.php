<?php

namespace App\Http\Controllers\Frontend\Document;

use App\Repositories\Frontend\Api\Document\GibddNotifyRepository;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;

class GibddNotifyController extends BaseController
{
    public function getWord(Request $request)
    {
        $tour_id = $request->tour_id;

        $filename = "Уведомление в ГИБДД.docx";
        $notify_text = (new GibddNotifyRepository)->getTextForTour($tour_id);
        $phpWord = new PhpWord();

        $section = $phpWord->addSection();

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $notify_text);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }


        return response()->download(storage_path($filename));
    }

    public function getMap(Request $request)
    {
        $tour_id = $request->tour_id;

        $tour_transport_days = (new GibddNotifyRepository)->getTourTransportDays($tour_id);
        $request->tour_day
            ? $req_tour_day = $request->tour_day
            : $req_tour_day = $tour_transport_days[0];

        $streets_by_days = (new GibddNotifyRepository)->getTourAddresses($tour_id);

        $notify_data = (new GibddNotifyRepository)->getDataForGibddNotify($tour_id, $req_tour_day);

        return view(
            'frontend.tour.tour.gibdd.map',
            compact(
                'streets_by_days',
                'tour_transport_days',
                'req_tour_day',
                'tour_id',
                'notify_data'
            )
        );
    }
}
