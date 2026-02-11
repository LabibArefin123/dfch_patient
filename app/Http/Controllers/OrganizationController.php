<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the organizations.
     */
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('backend.organization_management.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new organization.
     */
    public function create()
    {
        return view('backend.organization_management.create');
    }

    /**
     * Store a newly created organization in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name',
            'organization_logo_name' => 'required|string',
            'organization_location' => 'required|string',
            'organization_slogan' => 'required|string',
            'organization_picture' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_1' => 'nullable|string|max:30',
            'phone_2' => 'nullable|string|max:30',
            'land_phone_1' => 'nullable|string|max:30',
            'land_phone_2' => 'nullable|string|max:30',
        ]);

        $imageNameWithoutExt = null;

        if ($request->hasFile('organization_picture')) {

            $image      = $request->file('organization_picture');
            $extension  = $image->getClientOriginalExtension();

            // org_ddmmyyHHMMSS
            $imageNameWithoutExt = 'org_' . now()->format('dmyHis');

            $imageName = $imageNameWithoutExt . '.' . $extension;

            $image->move(
                public_path('uploads/images/backend/organization'),
                $imageName
            );
        }

        Organization::create([
            'name'                   => $request->name,
            'organization_logo_name' => $request->organization_logo_name,
            'organization_location'  => $request->organization_location,
            'organization_slogan'    => $request->organization_slogan,
            'organization_picture'   => $imageNameWithoutExt,
        ]);

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    /**
     * Display the specified organization.
     */
    public function show(Organization $organization)
    {
        return view('backend.organization_management.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified organization.
     */
    public function edit(Organization $organization)
    {
        return view('backend.organization_management.edit', compact('organization'));
    }

    /**
     * Update the specified organization in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name,' . $organization->id,
            'organization_logo_name' => 'required|string',
            'organization_location' => 'required|string',
            'organization_slogan' => 'required|string',
            'organization_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_1' => 'nullable|string|max:30',
            'phone_2' => 'nullable|string|max:30',
            'land_phone_1' => 'nullable|string|max:30',
            'land_phone_2' => 'nullable|string|max:30',
        ]);

        $imageNameWithoutExt = $organization->organization_picture;

        if ($request->hasFile('organization_picture')) {

            // 🔥 Delete old image if exists
            if ($organization->organization_picture) {
                foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                    $oldPath = public_path(
                        'uploads/images/backend/organization/' .
                            $organization->organization_picture . '.' . $ext
                    );

                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                        break;
                    }
                }
            }

            // 🔥 Upload new image
            $image     = $request->file('organization_picture');
            $extension = $image->getClientOriginalExtension();

            $imageNameWithoutExt = 'org_' . now()->format('dmyHis');
            $imageName = $imageNameWithoutExt . '.' . $extension;

            $image->move(
                public_path('uploads/images/backend/organization'),
                $imageName
            );
        }

        $organization->update([
            'name'                   => $request->name,
            'organization_logo_name' => $request->organization_logo_name,
            'organization_location'  => $request->organization_location,
            'organization_slogan'    => $request->organization_slogan,
            'phone_1'                => $request->phone_1,
            'phone_2'                => $request->phone_2,
            'land_phone_1'           => $request->land_phone_1,
            'land_phone_2'           => $request->land_phone_2,
            'organization_picture'   => $imageNameWithoutExt,
        ]);

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Organization updated successfully.');
    }


    /**
     * Remove the specified organization from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organization.index')
            ->with('success', 'Organization deleted successfully.');
    }
}
