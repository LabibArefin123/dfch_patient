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
        Schema::create('patient_meetings', function (Blueprint $table) {

            $table->id();
            $table->foreignId('patient_id')->nullable()->index();
            $table->foreignId('specialist_id')->nullable()->index();
            /* Meeting Information*/
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            /*Schedule */
            $table->date('meeting_date');
            $table->time('start_time');
            $table->time('end_time')
                ->nullable();

            /* Meeting Status */
            $table->enum('status', [
                'scheduled',
                'confirmed',
                'completed',
                'cancelled',
                'no_show',
            ])->default('scheduled');

            /* Meeting Type*/
            $table->enum('meeting_type', [
                'consultation',
                'follow_up',
                'report_review',
                'emergency',
                'other',
            ])->default('consultation');

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index([
                'meeting_date',
                'status',
            ]);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'patient_meetings'
        );
    }
};
