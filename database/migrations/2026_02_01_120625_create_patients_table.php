<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            /*Patient Identity */
            $table->string('patient_code')->unique()->nullable();
            $table->string('patient_name');
            $table->string('patient_f_name')->nullable();
            $table->string('patient_m_name')->nullable();

            $table->longText('patient_problem_description')->nullable();
            $table->longText('patient_drug_description')->nullable();

            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            /* Location   */
            // 1 = Simple
            // 2 = Bangladesh Address
            // 3 = Outside Bangladesh

            $table->tinyInteger('location_type')
                ->comment('1=Simple, 2=Bangladesh, 3=Outside Bangladesh');
            // Simple
            $table->text('location_simple')->nullable();

            // Bangladesh
            $table->string('house_address')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('post_code')->nullable();

            // Outside Bangladesh
            $table->string('country')->nullable();
            $table->string('passport_no')->nullable();

            /*Contact */
            $table->string('phone_1');
            $table->string('phone_2')->nullable();

            $table->string('phone_f_1')->nullable();
            $table->string('phone_m_1')->nullable();

            /* Recommendation  */
            $table->boolean('is_recommend')->default(false);
            $table->boolean('is_emergency')->default(false);
            $table->string('recommend_doctor_name')->nullable();
            $table->longText('recommend_note')->nullable();

            /* Treatment*/
            $table->boolean('is_treatment')
                ->default(false)
                ->comment('0=No, 1=Yes');

            // Smart editor HTML
            $table->longText('treatment_information')->nullable();
            // ["OPD","OT"]
            $table->json('treatment_type')->nullable();
            // ["img1.jpg","img2.jpg"]
            $table->json('treatment_images')->nullable();

            /* Investigation */
            $table->boolean('is_investigated')
                ->default(false)
                ->comment('0=No, 1=Yes');
            // Smart editor HTML
            $table->longText('investigation_information')->nullable();
            // ["scan1.jpg","scan2.jpg"]
            $table->json('investigation_images')->nullable();

            /* Hospital  */
            $table->date('date_of_patient_added')->nullable();
            $table->enum('registration_source', [
                'reception',
                'online',
                'referral'
            ])->nullable();
            $table->string('patient_photo')->nullable();
            $table->string('photo_hash')->nullable();
            $table->longText('face_embedding')->nullable();
            $table->text('remarks')->nullable();

            /*
        |--------------------------------------------------------------------------
        | Cancer History
        |--------------------------------------------------------------------------
        */

            $table->boolean('is_old_cancer')
                ->default(false)
                ->comment('0=No, 1=Yes');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
