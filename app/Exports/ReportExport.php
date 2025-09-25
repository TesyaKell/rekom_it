<?php

namespace App\Exports;

use App\Models\rekomendasi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function view(): View
    {
        return view('report_excel', [
            'results' => $this->results
        ]);
    }
}
