<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Patient Identity
            $table->string('patient_code')->unique()->nullable();
            $table->string('patient_name');
            $table->string('patient_f_name')->nullable();
            $table->string('patient_m_name')->nullable();
            $table->string('patient_problem_description')->nullable();
            $table->string('patient_drug_description')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            // Location Handling
            $table->tinyInteger('location_type')->comment('1=Simple, 2=Full BD Address, 3=Outside Bangladesh');

            // Type 1 (village)
            $table->text('location_simple')->nullable();

            // Type 2 (Bangladesh)
            $table->string('house_address')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('post_code')->nullable();

            // Type 3 (Outsider)
            $table->string('country')->nullable();
            $table->string('passport_no')->nullable();

            // Contact
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('phone_f_1')->nullable();
            $table->string('phone_m_1')->nullable();

            // Recommendation
            $table->boolean('is_recommend')->default(false);
            $table->string('recommend_doctor_name')->nullable();
            $table->text('recommend_note')->nullable();

            // Hospital Info
            $table->date('date_of_patient_added')->nullable();
            $table->enum('registration_source', ['reception', 'online', 'referral'])->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
