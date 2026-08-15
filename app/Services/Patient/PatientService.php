<?php

namespace App\Services\Patient;

use App\Models\Patient;
use App\Models\PatientEmergency;
use App\Models\PatientDocument;
use App\Models\PatientCancerPhoto;
use App\Models\Organization;
use App\Exports\PatientsExport;
use App\Imports\PatientsImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PatientService
{

    // START OF ORGANIZATION LOGO
    private function getOrganizationLogo(?Organization $organization): ?string
    {
        if (
            !$organization || !$organization->organization_picture
        ) {
            return null;
        }

        $basePath = 'uploads/images/backend/organization/';
        $extensions = ['jpg', 'jpeg', 'png', 'webp',];

        foreach ($extensions as $extension) {
            $relativePath = $basePath . $organization->organization_picture . '.' . $extension;

            if (
                file_exists(
                    public_path($relativePath)
                )
            ) {
                return asset($relativePath);
            }
        }

        return null;
    }
    // END OF ORGANIZATION LOGO

    // START OF DELETE SELECTED
    public function deleteSelected($ids): array
    {
        if (!$ids || count($ids) === 0) {
            return [
                'status' => false,
                'message' => 'No patients selected.',
            ];
        }

        try {
            DB::beginTransaction();

            /* GET SELECTED PATIENTS  */
            $patients = Patient::whereIn('id', $ids)->get();
            if ($patients->isEmpty()) {
                DB::rollBack();

                return [
                    'status' => false,
                    'message' => 'No valid patients found.',
                ];
            }

            /*  
            * STORE PATIENT FOLDER PATHS
            * ==============================================================
            * We collect these BEFORE deleting the patients.
            */

            $patientFolders = [];
            foreach ($patients as $patient) {
                $patientFolder = Str::slug(
                    $patient->patient_name . '-' . $patient->id
                );

                $patientFolders[] = public_path(
                    "uploads/patients/{$patientFolder}"
                );
            }

            /*DELETE RELATED DATABASE RECORDS */
            $patientIds = $patients->pluck('id');
            PatientEmergency::whereIn('patient_id', $patientIds)->delete();
            PatientDocument::whereIn('patient_id', $patientIds)->delete();
            PatientCancerPhoto::whereIn('patient_id', $patientIds)->delete();

            /* DELETE PATIENTS */
            Patient::whereIn('id', $patientIds)->delete();

            /* COMMIT DATABASE CHANGES  */
            DB::commit();

            /*DELETE PATIENT FILES */
            foreach ($patientFolders as $patientRootPath) {
                if (File::exists($patientRootPath)) {
                    File::deleteDirectory($patientRootPath);
                }
            }

            /*SUCCESS */
            return [
                'status' => true,
                'message' =>
                $patients->count() . ' selected patient' . ($patients->count() > 1 ? 's' : '') . ' deleted successfully.',
            ];
        } catch (\Throwable $e) {

            /* ROLLBACK DATABASE  */
            DB::rollBack();
            return [
                'status' => false,
                'message' =>
                'Unable to delete the selected patients. Please try again.',
            ];
        }
    }
    // END OF DELETE SELECTED

    // START OF EXPORT EXCEL
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
    //END OF EXPORT EXCEL

    // START OF EXPORT PDF
    public function exportPdf($request, $query)
    {
        try {
            if ($request->filled('ids')) {
                $query->whereIn('id', $request->ids);
            }

            $patients = $query->get();
            $organization = Organization::first();

            return Pdf::loadView(
                'backend.patient_management.patient_card_pdf',
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
    // END OF EXPORT PDF

    // START OF IMPORT EXCEL
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
    // END OF IMPORT EXCEL

    // START OF IMPORT WORD
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
                    'is_referred' => $row[14] ?? 0,
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
    // END OF IMPORT WORD

    public function patientCardListSearch(Request $request)
    {
        $search = $request->input('search');
        $organization = Organization::first();
        $organizationLogo = $this->getOrganizationLogo($organization);

        $patients = Patient::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('patient_name', 'like', "%{$search}%")
                        ->orWhere('patient_code', 'like', "%{$search}%")
                        ->orWhere('phone_1', 'like', "%{$search}%")
                        ->orWhere('phone_2', 'like', "%{$search}%")
                        ->orWhere('patient_f_name', 'like', "%{$search}%")
                        ->orWhere('patient_m_name', 'like', "%{$search}%");
                });
            })
            ->orderByRaw('LOWER(patient_name) ASC')
            ->paginate(20);

        return [
            'patients' => $patients,
            'organization' => $organization,
            'organizationLogo' => $organizationLogo,
        ];
    }


    // PRINT CARD
    public function printCard($id)
    {
        $patient = Patient::findOrFail($id);
        $organization = Organization::first();

        return Pdf::loadView(
            'backend.patient_management.print_card',
            compact('patient', 'organization')
        )->stream('patient_card_' . $patient->patient_code . '.pdf');
    }

    public function destroy(Patient $patient): array
    {
        try {
            DB::beginTransaction();
            /* PATIENT FOLDER */
            $patientFolder = Str::slug($patient->patient_name . '-' . $patient->id);
            $patientRootPath = public_path("uploads/patients/{$patientFolder}");

            /* DELETE RELATED DATABASE RECORDS  */
            PatientEmergency::where('patient_id', $patient->id)->delete();
            PatientDocument::where('patient_id', $patient->id)->delete();
            PatientCancerPhoto::where('patient_id', $patient->id)->delete();

            /*DELETE PATIENT  */
            $patient->delete();

            /* COMMIT DATABASE CHANGES   */
            DB::commit();

            /* DELETE PATIENT FILES*/
            if (File::exists($patientRootPath)) {
                File::deleteDirectory(
                    $patientRootPath
                );
            }

            return [
                'status' => 'success',
                'message' =>
                'Patient and all associated files deleted successfully.',
            ];
        } catch (\Throwable $e) {

            /*
         * ==============================================================
         * ROLLBACK DATABASE
         * ==============================================================
         */

            DB::rollBack();

            return [
                'status' => 'error',
                'message' =>
                'Unable to delete the patient. Please try again.',
            ];
        }
    }
}
