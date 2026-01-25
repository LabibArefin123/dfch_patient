<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tender_participates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id');
            $table->string('offer_no');
            $table->date('offer_date')->nullable();
            $table->date('offer_validity')->nullable();
            $table->string('offer_doc')->nullable();
            $table->boolean('is_bg')->default(0);
            $table->boolean('is_awarded')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_participates');
    }
};
