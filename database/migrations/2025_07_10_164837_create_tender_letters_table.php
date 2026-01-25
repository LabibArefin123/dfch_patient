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
        Schema::create('tender_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id');
            $table->unsignedTinyInteger('type')->comment('1->Par,2->A,3->Pro,4->C'); // 1=>participate 2=>awarded, 3=>progress, 4=>completed
            $table->string('reference_no')->nullable();
            $table->text('remarks')->nullable();
            $table->date('date')->nullable();
            $table->string('document')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_letters');
    }
};
