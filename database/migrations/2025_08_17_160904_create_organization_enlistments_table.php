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
        Schema::create('organization_enlistments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_id');
            $table->string('customer_name')->nullable();
            $table->date('validity')->nullable();
            $table->decimal('security_deposit', 15, 2)->nullable();
            $table->string('financial_year')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_enlistments');
    }
};
