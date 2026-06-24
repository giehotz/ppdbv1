<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator
{
    public function generate(string $viewPath, array $data, string $filename, bool $download = true): void
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'sans-serif');
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view($viewPath, $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        if ($download) {
            $dompdf->stream($filename, ['Attachment' => true]);
        } else {
            $dompdf->stream($filename, ['Attachment' => false]);
        }
    }
}
