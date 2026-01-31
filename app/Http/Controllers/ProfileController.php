<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;
use App\Models\Organization;
use App\Models\OrganizationEnlistment;
use App\Models\OrganizationDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function user_profile_show()
    {
        $user = Auth::user();
        return view('backend.setting_management.user_management.profile.show', compact('user'));
    }

    public function user_profile_edit()
    {
        $user = Auth::user();
        $roles = Role::all();
        return view('backend.setting_management.user_management.profile.edit', compact('user', 'roles'));
    }

    public function user_profile_update(Request $request)
    {
        $user = Auth::user();

        // 1️⃣ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'phone_2' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Password fields 
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6',
            'confirm_password' => 'nullable|string|same:new_password',

            // Company Documents 
            'documents.*.*.id'             => 'nullable|integer|exists:organization_documents,id',
            'documents.*.*.number'         => 'nullable|string|max:255',
            'documents.*.*.validity'       => 'nullable|date',
            'documents.*.*.financial_year' => 'nullable|string|max:255',
            'documents.*.*.document.*'     => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',

            // Company Enlistments
            'enlistments.*.id' => 'nullable|integer|exists:organization_enlistments,id',
            'enlistments.*.customer_name' => 'nullable|string|max:255',
            'enlistments.*.validity' => 'nullable|date',
            'enlistments.*.security_deposit' => 'nullable|numeric',
            'enlistments.*.financial_year' => 'nullable|string|max:255',
            'enlistments.*.*.document.*'     => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',
        ]);

        // Update User Info
        $user->fill($request->only(['name', 'username', 'email', 'phone', 'phone_2', 'role_id']))->save();

        // Handle password change if provided
        if ($request->filled('current_password') || $request->filled('new_password') || $request->filled('confirm_password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            // Update new password
            if ($request->new_password && $request->confirm_password) {
                $user->password = bcrypt($request->new_password);
                $user->save();
            }
        }

        // Profile Picture
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('images/profile_pictures');

            if (!file_exists($destination)) mkdir($destination, 0755, true);

            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }

            $image->move($destination, $filename);
            $user->update(['profile_picture' => 'images/profile_pictures/' . $filename]);
        }

        // 3️⃣ Update Organization (fixed org_id)
        $organization = Organization::first();
        if (!$organization) {
            return back()->with('error', 'Organization not found.');
        }

        // --- Documents ---
        if ($request->has('documents')) {
            foreach ($request->documents as $type => $docs) {   // trade, nid, bin, etc.
                foreach ($docs as $index => $data) {
                    // skip if nothing filled
                    if (empty($data['number']) && empty($request->file("documents.$type.$index.document"))) {
                        continue;
                    }

                    $doc = isset($data['id'])
                        ? OrganizationDocument::find($data['id'])
                        : new OrganizationDocument(['org_id' => $organization->id]);

                    $doc->org_id         = $organization->id;
                    $doc->type           = $type; // 🔑 type auto set
                    $doc->number         = $data['number'] ?? null;
                    $doc->validity       = $data['validity'] ?? null;
                    $doc->financial_year = $data['financial_year'] ?? null;
                    $doc->save();

                    // ✅ File Upload (multiple support)
                    if ($request->hasFile("documents.$type.$index.document")) {
                        $files = $request->file("documents.$type.$index.document");
                        if (!is_array($files)) $files = [$files];

                        foreach ($files as $file) {
                            if ($file instanceof \Illuminate\Http\UploadedFile) {
                                $folder = strtolower($type);
                                $docPath = public_path("uploads/documents/company_documents/{$folder}");
                                if (!file_exists($docPath)) mkdir($docPath, 0755, true);

                                // নতুন নাম: DDMMYY-time-type.extension
                                $date = date('dmy'); // DDMMYY
                                $time = time(); // Unix timestamp
                                $extension = $file->getClientOriginalExtension();
                                $docName = "{$date}-{$time}-{$folder}.{$extension}";

                                // পুরানো ফাইল থাকলে delete
                                if (!empty($data['id']) && $doc->document && file_exists($docPath . '/' . $doc->document)) {
                                    unlink($docPath . '/' . $doc->document);
                                }

                                $file->move($docPath, $docName);
                                $doc->update(['document' => $docName]);
                            }
                        }
                    }
                }
            }
        }

        // --- Enlistments ---
        if ($request->has('enlistments')) {
            foreach ($request->enlistments as $key => $enlist) {
                // Empty row skip
                if (empty($enlist['customer_name']) && empty($request->file("enlistments.$key.document"))) {
                    continue;
                }

                $entry = $organization->enlistments()->updateOrCreate(
                    ['id' => $enlist['id'] ?? null],
                    [
                        'customer_name'    => $enlist['customer_name'] ?? null,
                        'validity'         => $enlist['validity'] ?? null,
                        'security_deposit' => $enlist['security_deposit'] ?? null,
                        'financial_year'   => $enlist['financial_year'] ?? null,
                    ]
                );

                // ✅ Multiple document upload handle
                if ($request->hasFile("enlistments.$key.document")) {
                    $files = $request->file("enlistments.$key.document");
                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    $docPath = public_path('uploads/documents/organization/enlistments');
                    if (!file_exists($docPath)) {
                        mkdir($docPath, 0777, true);
                    }

                    foreach ($files as $file) {
                        if ($file instanceof \Illuminate\Http\UploadedFile) {
                            $date      = date('dmy');
                            $time      = time();
                            $extension = $file->getClientOriginalExtension();
                            $docName   = "{$date}-{$time}-enlistment-{$key}-" . uniqid() . ".{$extension}";

                            // move new file
                            $file->move($docPath, $docName);

                            // 🔑 Suggestion: If you want to save multiple documents,
                            // use a separate table `enlistment_documents` with enlistment_id + filename
                            // but if you only have one `document` column, then last uploaded file will overwrite old one
                            // Here I show JSON array approach 👇

                            $existingDocs = $entry->document ? json_decode($entry->document, true) : [];
                            if (!is_array($existingDocs)) $existingDocs = [];

                            $existingDocs[] = $docName;

                            $entry->update(['document' => json_encode($existingDocs)]);
                        }
                    }
                }
            }
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile')->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }
}
