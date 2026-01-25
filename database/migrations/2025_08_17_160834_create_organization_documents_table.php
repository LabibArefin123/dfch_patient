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
        Schema::create('organization_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_id');
            $table->string('type')->nullable();
            $table->string('number')->nullable();
            $table->date('validity')->nullable();
            $table->string('financial_year')->nullable();
            $table->string('document')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_documents');
    }
};
