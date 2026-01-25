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
        Schema::create('tender_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_awarded_id')->index();
            $table->boolean('is_delivered')->default(0); // 1 yes
            $table->string('challan_no')->nullable();
            $table->date('challan_date')->nullable();
            $table->string('challan_doc')->nullable();
            $table->boolean('is_inspection_completed')->default(0); // 1 yes
            $table->date('inspection_complete_date')->nullable();
            $table->boolean('is_inspection_accepted')->default(0); // 1 yes
            $table->date('inspection_submit_date')->nullable();
            $table->date('warranty_expiry_date')->nullable();
            $table->boolean('is_bill_submitted')->default(0); // 1 yes
            $table->string('bill_no')->nullable();
            $table->date('bill_submit_date')->nullable();
            $table->string('bill_doc')->nullable();
            $table->boolean('is_bill_received')->default(0); // 1 yes
            $table->string('bill_cheque_no')->nullable();
            $table->date('bill_receive_date')->nullable();
            $table->decimal('bill_amount', 15, 2)->nullable();
            $table->string('bill_bank_name')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_progress');
    }
};
