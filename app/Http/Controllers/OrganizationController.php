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
            
        ]);

        Organization::create([
            'name' => $request->name,
            'organization_logo_name' => $request->organization_logo_name,
            'organization_location' => $request->organization_location,
            'organization_slogan' => $request->organization_slogan,
        ]);

        return redirect()->route('organizations.index')
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
        ]);

        $organization->update([
            'name' => $request->name,
        ]);

        return redirect()->route('organizations.index')
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
