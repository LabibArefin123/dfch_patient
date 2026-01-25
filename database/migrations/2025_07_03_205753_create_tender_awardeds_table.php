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
        Schema::create('tender_awardeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_participate_id')->index();
            $table->string('workorder_no')->nullable();
            $table->date('workorder_date')->nullable();
            $table->date('workorder_doc')->nullable();
            $table->date('awarded_date');
            $table->enum('delivery_type', ['1', 'partial']); // 1 = single, partial = partial delivery
            $table->boolean('is_pg')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {

        Schema::dropIfExists('tender_awardeds');
    }
};
