<?php

namespace App\Http\Controllers\Frontend\Document;

use Illuminate\Http\Request;
use Dompdf\Dompdf;

class PdfController extends BaseController
{
    public function getPdf(Request $request) 
    {
        $html_String = $request->string;
        //dd($html_String, $request->all());
        $dompdf = new Dompdf();
        $dompdf->set_paper('A4');
        $dompdf->loadHtml($html_String);
        $dompdf->render();
        $dompdf->stream("dompdf.pdf");
    }
}
