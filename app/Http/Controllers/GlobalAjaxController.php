<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class GlobalAjaxController extends Controller
{
    public function patientAjax(Request $request)
    {
        $search = $request->search;

        $patients = Patient::with('documents')
            ->when($search, function ($q) use ($search) {

                $q->where(function ($query) use ($search) {

                    $query->where('patient_name', 'LIKE', "%{$search}%")
                        ->orWhere('patient_code', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->take(15)
            ->get();

        return response()->json(
            $patients->map(function ($patient) {

                return [

                    'id' => $patient->id,
                    'patient_name' => $patient->patient_name,
                    'patient_code' => $patient->patient_code,

                    'father_name' => $patient->patient_f_name,
                    'mother_name' => $patient->patient_m_name,

                    'father_phone' => $patient->phone_f_1,
                    'mother_phone' => $patient->phone_m_1,

                    'age' => $patient->age,

                    'location' => $patient->full_location,

                    'date_added' => optional($patient->date_of_patient_added)
                        ->format('d M Y'),

                    'is_referred' => $patient->is_referred,

                    'is_treatment' => $patient->is_treatment,

                    'is_investigated' => $patient->is_investigated,

                    'documents' => $patient->documents->map(function ($doc) {

                        return [

                            'name' => $doc->document_name,
                            'url' => asset($doc->document_file),

                        ];
                    })

                ];
            })
        );
    }

    public function patientDetails(Patient $patient)
    {
        $patient->load('documents');

        return response()->json([

            'id' => $patient->id,

            'patient_name' => $patient->patient_name,

            'patient_code' => $patient->patient_code,

            'father_name' => $patient->patient_f_name,

            'mother_name' => $patient->patient_m_name,

            'father_phone' => $patient->phone_f_1,

            'mother_phone' => $patient->phone_m_1,

            'age' => $patient->age,

            'location' => $patient->full_location,

            'date_added' => optional($patient->date_of_patient_added)
                ->format('d M Y'),

            'is_referred' => $patient->is_referred,

            'is_treatment' => $patient->is_treatment,

            'is_investigated' => $patient->is_investigated,

            'documents' => $patient->documents->map(function ($doc) {

                return [

                    'name' => $doc->document_name,

                    'url' => asset($doc->document_file),

                ];
            }),

        ]);
    }
}
