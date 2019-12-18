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
        } catch (Exception $e) {}


        return response()->download(storage_path($filename));
    }
}
