<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenderItemsSeeder extends Seeder
{
    public function run(): void
    {
        $denominations = [
            'Item',
            'Piece',
            'Kg',
            'Gram',
            'Pound',
            'Ton',
            'Liter',
            'Milliliter',
            'Gallon',
            'Quart',
            'Meter',
            'Centimeter',
            'Millimeter',
            'Square Meter',
            'Square Foot',
            'Cubic Meter',
            'Cubic Foot',
            'Box',
            'Pack',
            'Set',
            'Pair',
            'Dozen',
            'Roll',
            'Sheet',
            'Bundle',
            'Unit',
            'Each',
            'No',
            'Line',
            'Lot',
            'Job',
            'Service',
            'Hour',
            'Day',
            'Week',
            'Month',
            'Year',
        ];

        foreach ($denominations as $deno) {
            DB::table('tender_items')->insert([
                'item' => null,
                'deno' => $deno,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
