<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientPhotoHashSeeder extends Seeder
{
    public function run(): void
    {
        $updated = 0;

        Patient::whereNotNull('patient_photo')
            ->whereNull('photo_hash')
            ->chunk(100, function ($patients) use (&$updated) {

                foreach ($patients as $patient) {

                    $path = public_path($patient->patient_photo);

                    if (!file_exists($path)) {
                        $this->command->warn("Missing: {$patient->patient_photo}");
                        continue;
                    }

                    $patient->update([
                        'photo_hash' => hash_file('sha256', $path),
                    ]);

                    $updated++;

                    $this->command->info("Updated: {$patient->patient_name}");
                }
            });

        $this->command->info("================================");
        $this->command->info("Total Updated: {$updated}");
        $this->command->info("================================");
    }
}
