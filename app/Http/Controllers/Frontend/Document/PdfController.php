<?php

namespace App\Http\Controllers\Frontend\Document;

use App\Models\Document\Document;
use App\Repositories\Frontend\Api\Document\LabelsRepository;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class PdfController extends BaseController
{
    public function getPdf(Request $request) 
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

        $start_html = "<html><head><title>$document->name</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><style>@page { margin: 24px;}* { font-family: Arial, \"DejaVu Sans\", monospace;}</style><body>";
        $end_html = "</body></html>";
        $html_string = $start_html.$document->template.$end_html;
        foreach ($labels as $key => $value) {
            $replace_string = "{".$key."}";
            $html_string = str_replace($replace_string, $value, $html_string);
        }
        // dd($html_string);
        $dompdf = new Dompdf();
        $dompdf->set_paper('A4');
        $dompdf->loadHtml($html_string);
        $dompdf->render();
        $dompdf->stream($document->name);
    }
}
