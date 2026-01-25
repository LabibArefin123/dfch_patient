<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rejected_bidders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participated_bidder_id');
            $table->foreignId('tender_id');
            $table->string('company_name');
            $table->integer('company_members');
            $table->text('reason');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rejected_bidders');
    }
};
