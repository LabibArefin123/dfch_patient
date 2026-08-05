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
                'card_theme'         => 'theme_1',
                // Use the doctor's existing image
                'background_image'   => $specialist->photo,
                'show_logo'          => true,
                'show_degree'        => true,
                'show_designation'   => true,
                'show_details'       => true,
                'is_active'          => true,
            ]);
        }
    }
}
