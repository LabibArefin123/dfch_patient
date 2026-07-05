<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientCancerPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatientCancerPhotoController extends Controller
{
    /**
     * Display a listing.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $patientCancerPhotos = PatientCancerPhoto::with('patient')
            ->when($search, function ($query) use ($search) {

                $query->whereHas('patient', function ($q) use ($search) {

                    $q->where('patient_name', 'like', "%{$search}%")
                        ->orWhere('patient_code', 'like', "%{$search}%");
                })->orWhere('remarks', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'backend.patient_management.patient_cancer.index',
            compact('patientCancerPhotos', 'search')
        );
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
            ->select('id', 'patient_name', 'patient_code')
            ->whereNotNull('patient_name')
            ->whereRaw("TRIM(patient_name) != ''")
            ->orderByRaw('LOWER(patient_name) ASC')
            ->orderByRaw('LOWER(COALESCE(patient_code, "")) ASC')
            ->get();

        return view('backend.patient_management.patient_cancer.create', compact('patients'));
    }

    /**
     * Store new cancer report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'total_cancer' => 'required|integer|min:0',
            'remarks' => 'nullable|string',
            'xray_photo' => 'required|array',
            'xray_photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'xray_description' => 'nullable|array',
            'xray_description.*' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        $photos = [];

        try {
            $patient = \App\Models\Patient::findOrFail($request->patient_id);

            // Make patient folder name safe
            $patientFolderName = \Illuminate\Support\Str::slug($patient->name);

            // Final upload path:
            // public/uploads/images/patient_photos/patient_name/cancer
            $uploadPath = public_path('uploads/images/patient_photos/' . $patientFolderName . '/cancer');

            // Create folder if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('xray_photo')) {
                foreach ($request->file('xray_photo') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    // Move image to public folder
                    $image->move($uploadPath, $filename);

                    // Save relative path in DB
                    $photos[] = 'uploads/images/patient_photos/' . $patientFolderName . '/cancer/' . $filename;
                }
            }

            PatientCancerPhoto::create([
                'patient_id' => $request->patient_id,
                'total_cancer' => $request->total_cancer,
                'remarks' => $request->remarks,
                'xray_photo' => $photos,
                'xray_description' => $request->xray_description,
            ]);

            DB::commit();

            return redirect()
                ->route('patient-cancer-photos.index')
                ->with('success', 'Cancer report created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded files if DB insert fails
            if (!empty($photos)) {
                foreach ($photos as $photo) {
                    $fullPath = public_path($photo);

                    if (file_exists($fullPath)) {
                        unlink($fullPath);
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
        $patientCancerPhoto->load('patient');

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

        return view(
            'backend.patient_management.patient_cancer.edit',
            compact('patientCancerPhoto', 'patients')
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
            'remarks' => 'nullable|string',
            'xray_photo.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'xray_description' => 'nullable|array',
            'xray_description.*' => 'nullable|string|max:1000',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|string',
        ]);

        DB::beginTransaction();

        $newUploadedPhotos = [];

        try {
            $patient = Patient::findOrFail($request->patient_id);

            // Safe patient folder name
            $patientFolderName = Str::slug($patient->name);

            // Final upload folder
            $uploadPath = public_path('uploads/images/patient_photos/' . $patientFolderName . '/cancer');

            // Create folder if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Current photos from DB
            $photos = is_array($patientCancerPhoto->xray_photo)
                ? $patientCancerPhoto->xray_photo
                : [];

            /*
        |--------------------------------------------------------------------------
        | Delete selected old images
        |--------------------------------------------------------------------------
        */
            if ($request->filled('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    $deleteImage = trim($deleteImage);

                    // Delete physical file from public folder
                    $fullPath = public_path($deleteImage);

                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }

                    // Remove from photos array
                    $photos = array_values(array_filter($photos, function ($img) use ($deleteImage) {
                        return $img !== $deleteImage;
                    }));
                }
            }

            /*
        |--------------------------------------------------------------------------
        | Upload new images
        |--------------------------------------------------------------------------
        */
            if ($request->hasFile('xray_photo')) {
                foreach ($request->file('xray_photo') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    // Move file to public folder
                    $image->move($uploadPath, $filename);

                    // Relative DB path
                    $relativePath = 'uploads/images/patient_photos/' . $patientFolderName . '/cancer/' . $filename;

                    $photos[] = $relativePath;
                    $newUploadedPhotos[] = $relativePath; // for rollback cleanup
                }
            }

            /*
        |--------------------------------------------------------------------------
        | Update DB record
        |--------------------------------------------------------------------------
        */
            $patientCancerPhoto->update([
                'patient_id' => $request->patient_id,
                'total_cancer' => $request->total_cancer,
                'remarks' => $request->remarks,
                'xray_photo' => $photos,
                'xray_description' => $request->xray_description,
            ]);

            DB::commit();

            return redirect()
                ->route('patient-cancer-photos.index')
                ->with('success', 'Cancer report updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete newly uploaded files if update fails
            if (!empty($newUploadedPhotos)) {
                foreach ($newUploadedPhotos as $photo) {
                    $fullPath = public_path($photo);

                    if (file_exists($fullPath)) {
                        unlink($fullPath);
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
