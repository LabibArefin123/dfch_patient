<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('system_problems', function (Blueprint $table) {
            $table->id();
            $table->string('problem_uid')->unique(); // DFCH-PROB-XXXX
            $table->string('problem_title');
            $table->text('problem_description');
            $table->enum('status', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->string('problem_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_problems');
    }
};
