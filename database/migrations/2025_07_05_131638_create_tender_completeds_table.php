<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tender_completeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_progress_id')->index();
            $table->date('publication_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->string('workorder_no')->nullable();
            $table->date('workorder_date')->nullable();
            $table->date('awarded_date')->nullable();
            $table->enum('delivery_type', ['1', 'partial'])->default('1');
            $table->boolean('is_warranty_complete')->default(0);
            $table->date('warranty_complete_date')->nullable();
            $table->boolean('is_service_warranty')->default(0);
            $table->date('service_warranty_duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_completeds');
    }
};
