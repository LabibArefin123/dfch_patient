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
        Schema::create('tender_awarded_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_awarded_id');
            $table->string('delivery_item');
            $table->date('delivery_date');
            $table->string('warranty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_awarded_multiples');
    }
};
