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
            ->paginate(10);

        $cards->getCollection()->transform(function ($card) {
            $card->background_image_url = $card->background_image
                ? asset('uploads/images/welcome_page/doctors/' . $card->background_image)
                : null;

            return $card;
        });

        return view(
            'backend.specialist_management.card_management.index',
            compact('cards')
        );
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
