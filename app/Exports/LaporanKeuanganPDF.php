<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeuanganPDF
{
    protected $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function download($filename)
    {
        $pdf = PDF::loadView('exports.laporan-keuangan-pdf', $this->data);
        return $pdf->download($filename);
    }
}