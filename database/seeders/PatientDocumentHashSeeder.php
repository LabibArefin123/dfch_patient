<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PatientDocument;

class PatientDocumentHashSeeder extends Seeder
{
    public function run(): void
    {
        $updated = 0;

        PatientDocument::chunk(100, function ($documents) use (&$updated) {

            foreach ($documents as $document) {

                $fullPath = public_path($document->file_path);

                if (!file_exists($fullPath)) {

                    $this->command->warn("Missing: {$document->file_path}");

                    continue;
                }

                $document->update([
                    'file_hash' => hash_file('sha256', $fullPath),
                ]);

                $updated++;

                $this->command->info("Updated: {$document->document_name}");
            }
        });

        $this->command->info("=================================");
        $this->command->info("Total Updated: {$updated}");
        $this->command->info("=================================");
    }
}
