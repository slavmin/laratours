<?php

namespace App\Http\Controllers\Frontend\Tour\Document;

use App\Models\Document\Document;
use App\Repositories\Frontend\Api\Document\LabelsRepository;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;

class WordController extends BaseController
{
    public function getWord(Request $request)
    {
        $document_id = $request->document_id;
        $order_id = $request->order_id;
        $tour_id = $request->tour_id;
        $team_id = $request->team_id;

        $document = Document::whereId($document_id)->AllTeams()->first();

        if ($request->team_mode) {
            $order_info =
                (new LabelsRepository)
                ->getTeamLabelsWithValues($team_id);
        }

        if ($request->tourist_mode) {
            $order_info =
                (new LabelsRepository)
                ->getTouristLabelsWithValues($order_id, $tour_id);
        }

        $labels = $order_info['labels'];

        $html_string = $document->template;
        foreach ($labels as $key => $value) {
            $replace_string = "{" . $key . "}";
            $html_string = str_replace($replace_string, $value, $html_string);
        }
        $html_string = str_replace('<br>', '<br />', $html_string);

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html_string);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path("$document->name.docx"));
        } catch (Exception $e) {
        }


        return response()->download(storage_path("$document->name.docx"));
    }
}
