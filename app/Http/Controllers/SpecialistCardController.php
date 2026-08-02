<?php

namespace App\Http\Controllers;

use App\Models\SpecialistCard;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecialistCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = SpecialistCard::with('specialist')
            ->orderBy('position')
            ->paginate(10);

        return view(
            'backend.specialist_management.card_management.index',
            compact('cards')
        );
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialists = Specialist::orderBy('position')->get();

        return view(
            'backend.specialist_management.card_management.create',
            compact('specialists')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'specialist_id'    => 'required|exists:specialists,id',
            'name'             => 'required|string|max:255|unique:specialist_cards,name',
            'card_type'        => 'required|in:wide,vertical',
            'card_theme'       => 'required|string|max:100',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'logo_position'    => 'required|in:left,right,center',
            'photo_position'   => 'required|in:left,right,center',
            'show_logo'        => 'required|boolean',
            'show_degree'      => 'required|boolean',
            'show_designation' => 'required|boolean',
            'show_details'     => 'required|boolean',
            'show_qr'          => 'required|boolean',
            'primary_color'    => 'required|string|max:20',
            'secondary_color'  => 'required|string|max:20',
            'accent_color'     => 'required|string|max:20',
            'position'         => 'required|integer|min:1',
            'is_active'        => 'required|boolean',
        ]);

        $backgroundImage = null;
        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $extension = $image->getClientOriginalExtension();
            $backgroundImage = 'specialist_card_' . now()->format('dmyHis');
            $imageName = $backgroundImage . '.' . $extension;
            $image->move(
                public_path('uploads/images/welcome_page/specialist_cards'),
                $imageName
            );
        }

        SpecialistCard::create([
            'specialist_id'    => $request->specialist_id,
            'name'             => $request->name,
            'slug'             => Str::slug($request->name),
            'card_type'        => $request->card_type,
            'card_theme'       => $request->card_theme,
            'background_image' => $backgroundImage,
            'logo_position'    => $request->logo_position,
            'photo_position'   => $request->photo_position,
            'show_logo'        => $request->show_logo,
            'show_degree'      => $request->show_degree,
            'show_designation' => $request->show_designation,
            'show_details'     => $request->show_details,
            'show_qr'          => $request->show_qr,
            'primary_color'    => $request->primary_color,
            'secondary_color'  => $request->secondary_color,
            'accent_color'     => $request->accent_color,
            'position'         => $request->position,
            'is_active'        => $request->is_active,
        ]);

        return redirect()
            ->route('specialist-cards.index')
            ->with('success', 'Specialist card created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SpecialistCard $specialistCard)
    {
        $specialistCard->load('specialist');

        return view(
            'backend.specialist_management.card_management.show',
            compact('specialistCard')
        );
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpecialistCard $specialistCard)
    {
        $specialists = Specialist::orderBy('position')->get();

        return view(
            'backend.specialist_management.card_management.edit',
            compact('specialistCard', 'specialists')
        );
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpecialistCard $specialistCard)
    {
        $request->validate([
            'specialist_id'    => 'required|exists:specialists,id',

            'name'             => 'required|string|max:255|unique:specialist_cards,name,' . $specialistCard->id,

            'card_type'        => 'required|in:wide,vertical',

            'card_theme'       => 'required|string|max:100',

            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'logo_position'    => 'required|in:left,right,center',

            'photo_position'   => 'required|in:left,right,center',

            'show_logo'        => 'required|boolean',
            'show_degree'      => 'required|boolean',
            'show_designation' => 'required|boolean',
            'show_details'     => 'required|boolean',
            'show_qr'          => 'required|boolean',

            'primary_color'    => 'required|string|max:20',
            'secondary_color'  => 'required|string|max:20',
            'accent_color'     => 'required|string|max:20',

            'position'         => 'required|integer|min:1',

            'is_active'        => 'required|boolean',
        ]);

        $backgroundImage = $specialistCard->background_image;

        if ($request->hasFile('background_image')) {

            if ($specialistCard->background_image) {

                foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {

                    $oldImage = public_path(
                        'uploads/images/welcome_page/specialist_cards/' .
                            $specialistCard->background_image . '.' . $ext
                    );

                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                        break;
                    }
                }
            }

            $image = $request->file('background_image');

            $extension = $image->getClientOriginalExtension();

            $backgroundImage = 'specialist_card_' . now()->format('dmyHis');

            $imageName = $backgroundImage . '.' . $extension;

            $image->move(
                public_path('uploads/images/welcome_page/specialist_cards'),
                $imageName
            );
        }

        $specialistCard->update([
            'specialist_id'    => $request->specialist_id,
            'name'             => $request->name,
            'slug'             => Str::slug($request->name),
            'card_type'        => $request->card_type,
            'card_theme'       => $request->card_theme,
            'background_image' => $backgroundImage,
            'logo_position'    => $request->logo_position,
            'photo_position'   => $request->photo_position,
            'show_logo'        => $request->show_logo,
            'show_degree'      => $request->show_degree,
            'show_designation' => $request->show_designation,
            'show_details'     => $request->show_details,
            'show_qr'          => $request->show_qr,
            'primary_color'    => $request->primary_color,
            'secondary_color'  => $request->secondary_color,
            'accent_color'     => $request->accent_color,
            'position'         => $request->position,
            'is_active'        => $request->is_active,
        ]);

        return redirect()
            ->route('specialist-cards.index')
            ->with('success', 'Specialist card updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpecialistCard $specialistCard)
    {
        if ($specialistCard->background_image) {

            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {

                $image = public_path(
                    'uploads/images/welcome_page/specialist_cards/' .
                        $specialistCard->background_image . '.' . $ext
                );

                if (file_exists($image)) {
                    unlink($image);
                    break;
                }
            }
        }

        $specialistCard->delete();

        return redirect()
            ->route('specialist-cards.index')
            ->with('success', 'Specialist card deleted successfully.');
    }
}
