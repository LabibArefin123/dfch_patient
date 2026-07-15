<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_emergencies', function (Blueprint $table) {

            $table->id();
            $table->foreignId('patient_id')->nullable()->index();
            $table->boolean('is_emergency')->default(true);
            $table->text('reason')->nullable();
            $table->timestamp('emergency_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_emergencies');
    }
};