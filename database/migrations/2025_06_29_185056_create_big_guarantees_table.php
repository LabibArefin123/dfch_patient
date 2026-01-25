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
        Schema::create('big_guarantees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_participate_id')->index();
            $table->string('bg_no');
            $table->string('issue_in_bank');
            $table->string('issue_in_branch');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->decimal('amount', 15, 2);
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('big_guarantees');
    }
};
