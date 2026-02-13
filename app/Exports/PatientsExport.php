<?php

namespace App\Exports;

use App\Models\Patient;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PatientsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply same filters as index()
     */
    public function query()
    {
        return Patient::query()
            ->when($this->request->gender, function ($q) {
                $q->where('gender', $this->request->gender);
            })

            ->when($this->request->filled('is_recommend'), function ($q) {
                $q->where('is_recommend', (int) $this->request->is_recommend);
            })

            ->when($this->request->location_type, function ($q) {

                $q->where('location_type', $this->request->location_type);

                if ($this->request->filled('location_value')) {

                    if ($this->request->location_type == 1) {
                        $q->where('location_simple', 'like', "%{$this->request->location_value}%");
                    }

                    if ($this->request->location_type == 2) {
                        $q->where(function ($sub) {
                            $sub->where('city', 'like', "%{$this->request->location_value}%")
                                ->orWhere('district', 'like', "%{$this->request->location_value}%");
                        });
                    }

                    if ($this->request->location_type == 3) {
                        $q->where('country', 'like', "%{$this->request->location_value}%");
                    }
                }
            })

            ->when($this->request->date_filter === 'today', function ($q) {
                $q->whereDate('date_of_patient_added', now());
            })

            ->when($this->request->date_filter === 'yesterday', function ($q) {
                $q->whereDate('date_of_patient_added', now()->subDay());
            })

            ->when($this->request->date_filter === 'last_7_days', function ($q) {
                $q->whereDate('date_of_patient_added', '>=', now()->subDays(7));
            })

            ->when($this->request->date_filter === 'last_30_days', function ($q) {
                $q->whereDate('date_of_patient_added', '>=', now()->subDays(30));
            })

            ->when($this->request->date_filter === 'this_month', function ($q) {
                $q->whereBetween('date_of_patient_added', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ]);
            })

            ->when($this->request->date_filter === 'last_month', function ($q) {
                $q->whereBetween('date_of_patient_added', [
                    now()->subMonth()->startOfMonth(),
                    now()->subMonth()->endOfMonth()
                ]);
            })

            ->when($this->request->date_filter === 'this_year', function ($q) {
                $q->whereYear('date_of_patient_added', now()->year);
            })

            ->when(
                $this->request->date_filter === 'custom' &&
                    $this->request->filled(['from_date', 'to_date']),
                function ($q) {
                    $q->whereBetween('date_of_patient_added', [
                        $this->request->from_date,
                        $this->request->to_date
                    ]);
                }
            );
    }

    /**
     * Excel Headings
     */
    public function headings(): array
    {
        return [
            'Patient Code',
            'Name',
            'Father Name',
            'Mother Name',
            'Age',
            'Gender',
            'Phone',
            'City',
            'District',
            'Country',
            'Recommended',
            'Date Added',
        ];
    }

    /**
     * Map database fields to Excel columns
     */
    public function map($patient): array
    {
        return [
            $patient->patient_code,
            $patient->patient_name,
            $patient->patient_f_name,
            $patient->patient_m_name,
            $patient->age,
            ucfirst($patient->gender),
            $patient->phone_1,
            $patient->city,
            $patient->district,
            $patient->country,
            $patient->is_recommend ? 'Yes' : 'No',
            optional($patient->date_of_patient_added)->format('d M Y'),
        ];
    }
}
