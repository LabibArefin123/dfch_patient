<?php

namespace App\Imports;

use App\Models\Patient;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;


class PatientsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure
{
    use SkipsFailures;

    /**
     * Convert each row into Patient model
     */
    public function model(array $row)
    {
        return new Patient([

            'patient_code' => 'DFCH-' . now()->format('Y') . '-' . str_pad(
                Patient::max('id') + 1,
                9,
                '0',
                STR_PAD_LEFT
            ),

            'patient_name' => $row['patient_name'],
            'patient_f_name' => $row['patient_f_name'] ?? null,
            'patient_m_name' => $row['patient_m_name'] ?? null,
            'age' => $row['age'],
            'gender' => strtolower($row['gender']),
            'phone_1' => $row['phone_1'] ?? null,
            'phone_2' => $row['phone_2'] ?? null,
            'phone_f_1' => $row['phone_f_1'] ?? null,
            'phone_m_1' => $row['phone_m_1'] ?? null,
            'location_type' => $row['location_type'] ?? 1,
            'location_simple' => $row['location_simple'] ?? null,
            'city' => $row['city'] ?? null,
            'district' => $row['district'] ?? null,
            'country' => $row['country'] ?? null,
            'is_recommend' => isset($row['is_recommend']) ? (int)$row['is_recommend'] : 0,

            'date_of_patient_added' => isset($row['date_of_patient_added'])
                ? Carbon::parse($row['date_of_patient_added'])
                : now(),
        ]);
    }


    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [
            '*.patient_name' => 'required|string|max:255',
            '*.age' => 'required|integer|min:0',
            '*.gender' => 'required|in:male,female,other',
            '*.phone_1' => 'nullable|string|max:20',
            '*.date_of_patient_added' => 'nullable|date',
        ];
    }
}
