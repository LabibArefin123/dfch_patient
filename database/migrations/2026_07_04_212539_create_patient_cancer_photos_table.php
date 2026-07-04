<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_cancer_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->index();
            // Multiple X-ray images
            $table->json('xray_photo')->nullable();
            // Total cancer found in this report
            $table->unsignedInteger('total_cancer')->default(0);
            // Description for each X-ray
            $table->json('xray_description')->nullable();
            // Doctor remarks
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_cancer_photos');
    }
};
