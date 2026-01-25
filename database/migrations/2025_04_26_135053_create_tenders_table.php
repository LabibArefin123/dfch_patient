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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('tender_no')->unique();
            $table->string('title');
            $table->string('procuring_authority')->nullable();
            $table->string('end_user')->nullable();
            $table->json('items')->nullable();
            $table->string('tender_type')->nullable();
            $table->string('financial_year', 9)->nullable();
            $table->date('publication_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->time('submission_time')->nullable();
            $table->string('spec_file')->nullable();
            $table->string('notice_file')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('0=>Pending,1=>NP,2=>Par,3=>A,4=>Pro,5=>C');
            $table->boolean('is_participate')->default(0); // 1 yes
            $table->boolean('is_awarded')->default(0); // 1 yes
            $table->boolean('is_completed')->default(0); // 1 yes
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
