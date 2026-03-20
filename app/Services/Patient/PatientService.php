<?php

namespace App\Services\Patient;

use App\Models\Patient;
use App\Models\Organization;
use App\Exports\PatientsExport;
use App\Imports\PatientsImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PatientService
{
    
    // ==============================
    // DELETE
    // ==============================
    public function deleteSelected($ids)
    {
        if (!$ids || count($ids) === 0) {
            return [
                'status' => false,
                'message' => 'No patients selected.'
            ];
        }

        Patient::whereIn('id', $ids)->delete();

        return [
            'status' => true,
            'message' => 'Selected patients deleted successfully.'
        ];
    }

    // ==============================
    // EXPORT EXCEL
    // ==============================
    public function exportExcel($request, $query)
    {
        if ($request->filled('ids')) {
            $query->whereIn('id', $request->ids);
        }

        return Excel::download(
            new PatientsExport($query->get()),
            'patients.xlsx'
        );
    }

    // ==============================
    // EXPORT PDF
    // ==============================
    public function exportPdf($request, $query)
    {
        try {
            if ($request->filled('ids')) {
                $query->whereIn('id', $request->ids);
            }

            $patients = $query->get();
            $organization = Organization::first();

            return Pdf::loadView(
                'backend.patient_management.pdf',
                compact('patients', 'organization')
            )->stream('patients.pdf');
        } catch (\Throwable $e) {
            Log::error("PDF export error: " . $e->getMessage());

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    // ==============================
    // IMPORT EXCEL
    // ==============================
    public function importExcel($file)
    {
        try {
            $import = new PatientsImport;
            Excel::import($import, $file);

            if ($import->failures()->isNotEmpty()) {
                $errors = [];

                foreach ($import->failures() as $failure) {
                    $errors[] = "Row {$failure->row()} - " .
                        implode(', ', $failure->errors());
                }

                return [
                    'status' => 'error',
                    'message' => 'Some rows failed validation.',
                    'errors' => $errors
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Patients Imported Successfully'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Import failed. ' . $e->getMessage()
            ];
        }
    }

    // ==============================
    // IMPORT WORD
    // ==============================
    public function importWord($file)
    {
        try {
            $phpWord = IOFactory::load($file->getPathname());
            $rows = [];

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {

                    if (method_exists($element, 'getRows')) {

                        foreach ($element->getRows() as $row) {

                            $rowData = [];

                            foreach ($row->getCells() as $cell) {
                                $text = '';

                                foreach ($cell->getElements() as $cellElement) {
                                    if (method_exists($cellElement, 'getText')) {
                                        $text .= $cellElement->getText();
                                    }
                                }

                                $rowData[] = trim($text);
                            }

                            $rows[] = $rowData;
                        }
                    }
                }
            }

            if (count($rows) <= 1) {
                return [
                    'status' => 'error',
                    'message' => 'No data found in Word file.'
                ];
            }

            array_shift($rows); // remove header

            foreach ($rows as $row) {
                Patient::create([
                    'patient_name' => $row[0] ?? null,
                    'patient_f_name' => $row[1] ?? null,
                    'patient_m_name' => $row[2] ?? null,
                    'age' => $row[3] ?? null,
                    'gender' => $row[4] ?? null,
                    'phone_1' => $row[5] ?? null,
                    'phone_2' => $row[6] ?? null,
                    'phone_f_1' => $row[7] ?? null,
                    'phone_m_1' => $row[8] ?? null,
                    'location_type' => $row[9] ?? null,
                    'location_simple' => $row[10] ?? null,
                    'city' => $row[11] ?? null,
                    'district' => $row[12] ?? null,
                    'country' => $row[13] ?? null,
                    'is_recommend' => $row[14] ?? 0,
                    'date_of_patient_added' => $row[15] ?? Carbon::now()->toDateString(),
                ]);
            }

            return [
                'status' => 'success',
                'message' => 'Patients Imported Successfully from Word'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Word import failed. ' . $e->getMessage()
            ];
        }
    }

    // ==============================
    // PRINT CARD
    // ==============================
    public function printCard($id)
    {
        $patient = Patient::findOrFail($id);
        $organization = Organization::first();

        return Pdf::loadView(
            'backend.patient_management.print_card',
            compact('patient', 'organization')
        )->stream('patient_card_' . $patient->patient_code . '.pdf');
    }
}
