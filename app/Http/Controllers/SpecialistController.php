<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialists = Specialist::orderBy('position')->paginate(10);

        return view('backend.specialist_management.index', compact('specialists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.specialist_management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255|unique:specialists,name',
            'designation'  => 'nullable|string|max:255',
            'degree'       => 'nullable|string|max:255',
            'details'      => 'nullable|string',
            'position'     => 'required|integer|min:1',
            'is_active'    => 'required|boolean',
            'photo'        => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $photoNameWithoutExt = null;

        if ($request->hasFile('photo')) {

            $image = $request->file('photo');

            $extension = $image->getClientOriginalExtension();

            $photoNameWithoutExt = 'doctor_' . now()->format('dmyHis');

            $imageName = $photoNameWithoutExt . '.' . $extension;

            $image->move(
                public_path('uploads/images/welcome_page/doctors'),
                $imageName
            );
        }

        Specialist::create([
            'name'         => $request->name,
            'designation'  => $request->designation,
            'degree'       => $request->degree,
            'details'      => $request->details,
            'photo'        => $photoNameWithoutExt,
            'slug'         => Str::slug($request->name),
            'position'     => $request->position,
            'is_active'    => $request->is_active,
        ]);

        return redirect()
            ->route('specialists.index')
            ->with('success', 'Specialist created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialist $specialist)
    {
        return view('backend.specialist_management.show', compact('specialist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialist $specialist)
    {
        return view('backend.specialist_management.edit', compact('specialist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialist $specialist)
    {
        $request->validate([
            'name'         => 'required|string|max:255|unique:specialists,name,' . $specialist->id,
            'designation'  => 'nullable|string|max:255',
            'degree'       => 'nullable|string|max:255',
            'details'      => 'nullable|string',
            'position'     => 'required|integer|min:1',
            'is_active'    => 'required|boolean',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $photoNameWithoutExt = $specialist->photo;

        if ($request->hasFile('photo')) {

            if ($specialist->photo) {

                foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {

                    $oldImage = public_path(
                        'uploads/images/welcome_page/doctors/' .
                            $specialist->photo . '.' . $ext
                    );

                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                        break;
                    }
                }
            }

            $image = $request->file('photo');

            $extension = $image->getClientOriginalExtension();

            $photoNameWithoutExt = 'doctor_' . now()->format('dmyHis');

            $imageName = $photoNameWithoutExt . '.' . $extension;

            $image->move(
                public_path('uploads/images/welcome_page/doctors'),
                $imageName
            );
        }

        $specialist->update([
            'name'         => $request->name,
            'designation'  => $request->designation,
            'degree'       => $request->degree,
            'details'      => $request->details,
            'photo'        => $photoNameWithoutExt,
            'slug'         => Str::slug($request->name),
            'position'     => $request->position,
            'is_active'    => $request->is_active,
        ]);

        return redirect()
            ->route('specialists.index')
            ->with('success', 'Specialist updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialist $specialist)
    {
        if ($specialist->photo) {

            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {

                $image = public_path(
                    'uploads/images/welcome_page/doctors/' .
                        $specialist->photo . '.' . $ext
                );

                if (file_exists($image)) {
                    unlink($image);
                    break;
                }
            }
        }

        $specialist->delete();

        return redirect()
            ->route('specialists.index')
            ->with('success', 'Specialist deleted successfully.');
    }
}
