<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\PatientCancerPhoto;
use Illuminate\Database\Seeder;

class PatientHashSeeder extends Seeder
{
    /**
     * Generate missing hashes for existing patient files.
     */
    public function run(): void
    {
        $this->command->info('Generating patient image hashes...');

        Patient::chunk(100, function ($patients) {

            foreach ($patients as $patient) {

                $updated = false;

                /*
                |--------------------------------------------------------------------------
                | Treatment Images
                |--------------------------------------------------------------------------
                */

                if (
                    $patient->is_treatment &&
                    !empty($patient->treatment_images)
                ) {

                    $hashes = [];

                    foreach ((array) $patient->treatment_images as $image) {

                        $file = public_path($image);

                        if (file_exists($file)) {

                            $hashes[] = hash_file('sha256', $file);
                        }
                    }

                    $patient->treatment_hashes = $hashes;

                    $updated = true;
                }

                /*
                |--------------------------------------------------------------------------
                | Investigation Images
                |--------------------------------------------------------------------------
                */

                if (
                    $patient->is_investigated &&
                    !empty($patient->investigation_images)
                ) {

                    $hashes = [];

                    foreach ((array) $patient->investigation_images as $image) {

                        $file = public_path($image);

                        if (file_exists($file)) {

                            $hashes[] = hash_file('sha256', $file);
                        }
                    }

                    $patient->investigation_hashes = $hashes;

                    $updated = true;
                }

                if ($updated) {
                    $patient->save();
                }

                /*
                |--------------------------------------------------------------------------
                | Cancer Images
                |--------------------------------------------------------------------------
                */

                if ($patient->is_old_cancer) {

                    $patient->cancerPhotos()->each(function (PatientCancerPhoto $report) {

                        $hashes = [];

                        foreach ((array) $report->xray_photo as $image) {

                            $file = public_path($image);

                            if (file_exists($file)) {

                                $hashes[] = hash_file('sha256', $file);
                            }
                        }

                        $report->update([
                            'cancer_hashes' => $hashes,
                        ]);
                    });
                }
            }
        });

        $this->command->info('Patient hashes generated successfully.');
    }
}
