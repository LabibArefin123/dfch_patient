<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PatientReportExport implements FromView
{
    protected $patients;
    protected $request;
    protected $title;

    public function __construct($patients, $request, $title)
    {
        $this->patients = $patients;
        $this->request = $request;
        $this->title = $title;
    }

    public function view(): View
    {
        return view('backend.report_management.patient.excel.patient_report_excel', [
            'patients' => $this->patients,
            'request'  => $this->request,
            'title'    => $this->title,
        ]);
    }
}
