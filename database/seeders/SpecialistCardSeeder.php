<?php

namespace Database\Seeders;

use App\Models\Specialist;
use App\Models\SpecialistCard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpecialistCardSeeder extends Seeder
{
    public function run(): void
    {
        $specialists = Specialist::orderBy('position')->get();

        foreach ($specialists as $specialist) {

            SpecialistCard::create([
                'specialist_id'      => $specialist->id,
                'name'               => $specialist->name,
                'slug'               => Str::slug($specialist->name),
                'card_type'          => 'wide',
                'card_theme'         => 'theme_1',
                // Use the doctor's existing image
                'background_image'   => $specialist->photo,
                'logo_position'      => 'top-left',
                'photo_position'     => 'left',
                'show_logo'          => true,
                'show_degree'        => true,
                'show_designation'   => true,
                'show_details'       => true,
                'show_qr'            => true,
                'primary_color'      => '#8b0000',
                'secondary_color'    => '#ffffff',
                'accent_color'       => '#00a0d6',
                'position'           => $specialist->position,
                'is_active'          => true,
            ]);
        }
    }
}
