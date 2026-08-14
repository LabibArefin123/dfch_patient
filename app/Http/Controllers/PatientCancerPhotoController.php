<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientCancerPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\Image\Enums\Fit;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class PatientCancerPhotoController extends Controller
{
    /** Display a listing. */
    public function index(Request $request)
    {
        $search = $request->search;

        $patientCancerPhotos = PatientCancerPhoto::with('patient')
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->whereHas('patient', function ($patientQuery) use ($search) {

                        $patientQuery
                            ->where('patient_name', 'like', "%{$search}%")
                            ->orWhere('patient_code', 'like', "%{$search}%");
                    })
                        ->orWhere('cancer_remarks', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /* Prepare Preview Text  */
        $patientCancerPhotos->getCollection()->transform(function ($report) {

            /* X-Ray Description Preview */
            $report->description_preview = collect(
                $report->xray_description ?? []
            )
                ->map(function ($description) {

                    if (empty($description)) {
                        return null;
                    }

                    $text = html_entity_decode(
                        $description,
                        ENT_QUOTES | ENT_HTML5,
                        'UTF-8'
                    );


                    /* Remove empty list items first */
                    $text = preg_replace('/<li>\s*(?:<br\s*\/?>)?\s*<\/li>/i', '', $text);
                    /* Convert list items to bullets */
                    $text = preg_replace('/<li[^>]*>\s*/i', '• ', $text);
                    $text = preg_replace('/<\/li>/i', "\n", $text);


                    /* Convert common HTML line breaks  */
                    $text = preg_replace('/<br\s*\/?>/i', "\n", $text);
                    $text = preg_replace('/<\/p>/i', "\n", $text);

                    /* Remove remaining HTML  */
                    $text = strip_tags($text);

                    /* Normalize whitespace  */
                    $text = str_replace(["\r\n", "\r"], "\n", $text);
                    $text = preg_replace("/[ \t]+/", " ", $text);
                    $text = preg_replace("/\n{2,}/", "\n", $text);

                    /*Remove empty bullet lines */
                    $text = preg_replace('/^[ \t]*•[ \t]*(?=\n|$)/m', '', $text);

                    /* Remove trailing whitespace/newlines */
                    return trim($text);
                })
                ->filter(function ($description) {
                    return !empty(trim($description));
                })
                ->values()
                ->toArray();


            /*| Cancer Remarks Preview */
            $remarks = $report->cancer_remarks;

            if (is_array($remarks)) {
                $remarks = implode("\n", $remarks);
            }

            $remarks = html_entity_decode($remarks ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
            /* Remove Empty List Items*/
            $remarks = preg_replace('/<li>\s*(?:<br\s*\/?>)?\s*<\/li>/i', '', $remarks);

            /*| Convert Lists */
            $remarks = preg_replace('/<li[^>]*>\s*/i', '• ', $remarks);
            $remarks = preg_replace('/<\/li>/i', "\n", $remarks);

            /*Convert Line Breaks */
            $remarks = preg_replace('/<br\s*\/?>/i', "\n", $remarks);
            $remarks = preg_replace('/<\/p>/i', "\n", $remarks);

            /*Remove HTML*/
            $remarks = strip_tags($remarks);

            /* Normalize Whitespace */
            $remarks = str_replace(["\r\n", "\r"], "\n", $remarks);
            $remarks = preg_replace("/[ \t]+/", " ", $remarks);
            $remarks = preg_replace("/\n{2,}/", "\n", $remarks);

            /* Remove Empty Bullet Lines */
            $remarks = preg_replace('/^[ \t]*•[ \t]*(?=\n|$)/m', '', $remarks);
            $report->remarks_preview = trim($remarks);
            return $report;
        });

        return view(
            'backend.patient_management.patient_cancer.index',
            compact(
                'patientCancerPhotos',
                'search'
            )
        );
    }

    public function patientsSync()
    {
        /*Find Patients Who Have Cancer Photos*/
        $patientsWithCancerPhotos = Patient::whereHas('cancerPhotos')
            ->select('id', 'patient_name', 'patient_code', 'is_old_cancer')
            ->get();

        /* Find Patients That Need Synchronization*/
        $patientsToSync = $patientsWithCancerPhotos->where('is_old_cancer', false);

        /* Already Synced Patients */
        $alreadySynced = $patientsWithCancerPhotos->where('is_old_cancer', true)->count();

        /*If Everything Is Already Synced*/
        if ($patientsToSync->isEmpty()) {
            return response()->json([
                'success' => true,
                'status' => 'already_synced',
                'message' => 'All cancer photo patients are already synchronized.',
                'total_patients' => $patientsWithCancerPhotos->count(),
                'already_synced' => $alreadySynced,
                'synced_now' => 0,
                'remaining' => 0,
            ]);
        }

        /*Synchronize Patients*/
        $syncedNow = 0;
        DB::transaction(function () use (
            $patientsToSync,
            &$syncedNow
        ) {
            foreach ($patientsToSync as $patient) {
                $patient->update([
                    'is_old_cancer' => true,
                ]);

                $syncedNow++;
            }
        });

        /* Return Result */
        return response()->json([
            'success' => true,
            'status' => 'synced',
            'message' => 'Cancer photo patients synchronized successfully.',
            'total_patients' => $patientsWithCancerPhotos->count(),
            'already_synced' => $alreadySynced,
            'synced_now' => $syncedNow,
            'remaining' => 0,
        ]);
    }

    public function patientCancerPhotos(Patient $patient)
    {
        $patientCancerPhotos = $patient->cancerPhotos()
            ->latest()
            ->paginate(20);

        return view(
            'backend.patient_management.patient_cancer.index',
            compact('patient', 'patientCancerPhotos')
        );
    }

    /**
     * Show create page.
     */
    public function create()
    {
        $patients = Patient::query()
            ->where(function ($query) {
                $query->where('is_old_cancer', '!=', 1)
                    ->orWhereNull('is_old_cancer');
            })
            ->select(
                'id',
                'patient_name',
                'patient_code',
                'is_old_cancer'
            )
            ->orderBy('patient_name')
            ->get();

        return view(
            'backend.patient_management.patient_cancer.create',
            compact('patients')
        );
    }

    /**
     * Store new cancer report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'total_cancer' => 'required|integer|min:0',
            'cancer_remarks' => 'nullable|string',
            'xray_photo' => 'required|array',
            'xray_photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:12288',
            'xray_description' => 'nullable|array',
            'xray_description.*' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        $uploadedPhotos = [];

        try {
            $patient = Patient::findOrFail($request->patient_id);

            /* Build patient folder*/
            $patientFolder = Str::slug($patient->patient_name) . '-' . $patient->id;

            $relativeFolder = "uploads/patients/{$patientFolder}/cancer_photos";
            $uploadPath = public_path($relativeFolder);

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }

            /* Find Next Cancer Image Number*/
            $nextNumber = 1;
            $existingFiles = File::files($uploadPath);
            foreach ($existingFiles as $file) {
                if (preg_match('/^cancer_(\d+)\.webp$/', $file->getFilename(), $matches)) {
                    $nextNumber = max($nextNumber, ((int) $matches[1]) + 1);
                }
            }

            /*Upload images and convert to WEBP */
            $photos = [];

            foreach ($request->file('xray_photo') as $imageFile) {
                $filename = 'cancer_' . $nextNumber . '.webp';
                $savePath = $uploadPath . DIRECTORY_SEPARATOR . $filename;

                Image::load($imageFile->getRealPath())
                    ->width(1800)
                    ->format('webp')
                    ->quality(75)
                    ->save($savePath);

                $relativePath = $relativeFolder . '/' . $filename;

                $photos[] = $relativePath;
                $uploadedPhotos[] = $relativePath;
                $nextNumber++;
            }

            /* Create DB record*/
            PatientCancerPhoto::create([
                'patient_id' => $request->patient_id,
                'total_cancer' => $request->total_cancer,
                'cancer_remarks' => $request->cancer_remarks,
                'xray_photo' => $photos,
                'xray_description' => $request->xray_description,
            ]);

            DB::commit();

            return redirect()
                ->route('patient-cancer-photos.index')
                ->with('success', 'Cancer report created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            /* Delete uploaded files if store fails */
            if (!empty($uploadedPhotos)) {
                foreach ($uploadedPhotos as $photo) {
                    $fullPath = public_path($photo);

                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                }
            }

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(PatientCancerPhoto $patientCancerPhoto)
    {
        $patientCancerPhoto->load([
            'patient.documents',
        ]);

        $patient = $patientCancerPhoto->patient;

        if ($patient) {

            /*
        |--------------------------------------------------------------------------
        | Normalize Treatment Type
        |--------------------------------------------------------------------------
        */

            $treatmentType = $patient->treatment_type;

            if (is_string($treatmentType)) {
                $decoded = json_decode($treatmentType, true);

                $patient->treatment_type = is_array($decoded)
                    ? $decoded
                    : [$treatmentType];
            } elseif (!is_array($treatmentType)) {
                $patient->treatment_type = [];
            }

            /*
        |--------------------------------------------------------------------------
        | Normalize Treatment Images
        |--------------------------------------------------------------------------
        */

            $treatmentImages = $patient->treatment_images;

            if (is_string($treatmentImages)) {
                $decoded = json_decode($treatmentImages, true);

                $patient->treatment_images = is_array($decoded)
                    ? $decoded
                    : [];
            } elseif (!is_array($treatmentImages)) {
                $patient->treatment_images = [];
            }

            /*
        |--------------------------------------------------------------------------
        | Normalize Investigation Images
        |--------------------------------------------------------------------------
        */

            $investigationImages = $patient->investigation_images;

            if (is_string($investigationImages)) {
                $decoded = json_decode($investigationImages, true);

                $patient->investigation_images = is_array($decoded)
                    ? $decoded
                    : [];
            } elseif (!is_array($investigationImages)) {
                $patient->investigation_images = [];
            }

            /*
        |--------------------------------------------------------------------------
        | Normalize Patient Location
        |--------------------------------------------------------------------------
        */

            switch ((int) $patient->location_type) {

                case 1:
                    $patient->display_location = [
                        'type' => 'Simple Location',
                        'fields' => [
                            [
                                'label' => 'Location',
                                'value' => $patient->location_simple,
                                'icon' => 'fas fa-map-marker-alt',
                                'col' => 'col-md-6',
                            ],
                        ],
                    ];
                    break;

                case 2:
                    $patient->display_location = [
                        'type' => 'Bangladesh Address',
                        'fields' => [
                            [
                                'label' => 'House / Address',
                                'value' => $patient->house_address,
                                'icon' => 'fas fa-home',
                                'col' => 'col-md-6',
                            ],
                            [
                                'label' => 'City',
                                'value' => $patient->city,
                                'icon' => 'fas fa-city',
                                'col' => 'col-md-3',
                            ],
                            [
                                'label' => 'District',
                                'value' => $patient->district,
                                'icon' => 'fas fa-map',
                                'col' => 'col-md-3',
                            ],
                            [
                                'label' => 'Post Code',
                                'value' => $patient->post_code,
                                'icon' => 'fas fa-mail-bulk',
                                'col' => 'col-md-3',
                            ],
                        ],
                    ];
                    break;

                case 3:
                    $patient->display_location = [
                        'type' => 'Outside Bangladesh',
                        'fields' => [
                            [
                                'label' => 'Country',
                                'value' => $patient->country,
                                'icon' => 'fas fa-globe',
                                'col' => 'col-md-6',
                            ],
                            [
                                'label' => 'Passport Number',
                                'value' => $patient->passport_no,
                                'icon' => 'fas fa-passport',
                                'col' => 'col-md-6',
                            ],
                        ],
                    ];
                    break;

                default:
                    $patient->display_location = [
                        'type' => 'Location',
                        'fields' => [],
                    ];
                    break;
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Normalize Cancer / X-Ray Images
    |--------------------------------------------------------------------------
    */

        $xrayPhotos = $patientCancerPhoto->xray_photo;

        if (is_string($xrayPhotos)) {

            $decoded = json_decode($xrayPhotos, true);

            $patientCancerPhoto->xray_photo = is_array($decoded)
                ? $decoded
                : [];
        } elseif (is_array($xrayPhotos)) {

            $patientCancerPhoto->xray_photo = $xrayPhotos;
        } else {

            $patientCancerPhoto->xray_photo = [];
        }

        return view(
            'backend.patient_management.patient_cancer.show',
            compact('patientCancerPhoto')
        );
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientCancerPhoto $patientCancerPhoto)
    {
        $patients = Patient::orderBy('patient_name')->get();

        $oldPhotos = is_array($patientCancerPhoto->xray_photo)
            ? $patientCancerPhoto->xray_photo
            : [];

        $photoLastUpdated = [];

        foreach ($oldPhotos as $photo) {
            $filePath = public_path($photo);
            $photoLastUpdated[$photo] = File::exists($filePath)
                ? Carbon::createFromTimestamp(File::lastModified($filePath))
                : null;
        }

        return view(
            'backend.patient_management.patient_cancer.edit',
            compact(
                'patientCancerPhoto',
                'patients',
                'oldPhotos',
                'photoLastUpdated'
            )
        );
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, PatientCancerPhoto $patientCancerPhoto)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'total_cancer' => 'required|integer|min:0',
            'cancer_remarks' => 'nullable|string',
            'xray_photo.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:12288',
            'xray_description' => 'nullable|string',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        $newUploadedPhotos = [];
        $deletedOldPhotos = [];

        try {
            $patient = Patient::findOrFail($request->patient_id);
            /* Build patient folder */
            $patientName = $patient->patient_name ?? ('patient-' . $patient->id);
            $patientFolderName = Str::slug($patientName);

            $relativeFolder = 'uploads/images/patient_photos/' . $patientFolderName . '/cancer';
            $uploadPath = public_path($relativeFolder);

            $patientFolder = Str::slug($patient->patient_name) . '-' . $patient->id;
            $relativeFolder = "uploads/patients/{$patientFolder}/cancer_photos";
            $uploadPath = public_path($relativeFolder);

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }

            /* Current photos from DB */
            $photos = is_array($patientCancerPhoto->xray_photo)
                ? $patientCancerPhoto->xray_photo
                : [];

            /*Delete selected old images  */
            if ($request->filled('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    $deleteImage = trim($deleteImage);

                    if ($deleteImage === '') {
                        continue;
                    }

                    // Keep backup in case rollback is needed
                    if (in_array($deleteImage, $photos)) {
                        $deletedOldPhotos[] = $deleteImage;
                    }

                    // Delete physical file from public folder
                    $fullPath = public_path($deleteImage);

                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }

                    // Remove from array
                    $photos = array_values(array_filter($photos, function ($img) use ($deleteImage) {
                        return $img !== $deleteImage;
                    }));
                }
            }

            /*Upload new images and convert to WEBP */
            if ($request->hasFile('xray_photo')) {
                // Find the next available cancer number
                $nextNumber = 1;

                $existingFiles = File::files($uploadPath);

                foreach ($existingFiles as $file) {
                    if (preg_match('/^cancer_(\d+)\.webp$/', $file->getFilename(), $matches)) {
                        $nextNumber = max($nextNumber, ((int) $matches[1]) + 1);
                    }
                }

                foreach ($request->file('xray_photo') as $imageFile) {
                    $filename = 'cancer_' . $nextNumber . '.webp';
                    $savePath = $uploadPath . DIRECTORY_SEPARATOR . $filename;

                    Image::load($imageFile->getRealPath())
                        ->width(1800)
                        ->format('webp')
                        ->quality(75)
                        ->save($savePath);

                    $relativePath = $relativeFolder . '/' . $filename;
                    $photos[] = $relativePath;
                    $newUploadedPhotos[] = $relativePath;
                    $nextNumber++;
                }
            }

            /*Update DB record */
            $patientCancerPhoto->update([
                'patient_id' => $request->patient_id,
                'total_cancer' => $request->total_cancer,
                'cancer_remarks' => $request->cancer_remarks,
                'xray_photo' => $photos,
                'xray_description' => $request->xray_description,
            ]);

            DB::commit();

            return redirect()
                ->route('patient-cancer-photos.index')
                ->with('success', 'Cancer report updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            /* Delete newly uploaded files if update fails */
            if (!empty($newUploadedPhotos)) {
                foreach ($newUploadedPhotos as $photo) {
                    $fullPath = public_path($photo);

                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                }
            }

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientCancerPhoto $patientCancerPhoto)
    {
        DB::beginTransaction();

        try {

            // Delete all stored X-ray images
            if (!empty($patientCancerPhoto->xray_photo)) {

                foreach ($patientCancerPhoto->xray_photo as $photo) {

                    Storage::disk('public')
                        ->delete('patient_cancer_photos/' . $photo);
                }
            }

            // Delete database record
            $patientCancerPhoto->delete();

            DB::commit();

            return redirect()
                ->route('patient-cancer-photos.index')
                ->with('success', 'Cancer report deleted successfully.');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('patient-cancer-photos.index')
                ->with('error', $e->getMessage());
        }
    }
}
