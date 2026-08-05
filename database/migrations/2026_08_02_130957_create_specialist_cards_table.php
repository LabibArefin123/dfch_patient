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
        Schema::create('specialist_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialist_id')->nullable()->index();
            $table->string('name');                 // Premium Blue, Modern Red
            $table->string('slug')->unique();
            $table->enum('card_type', ['wide','vertical',])->default('wide');
            $table->string('card_theme')->default('theme_1');
            $table->string('background_image')->nullable();
            $table->string('logo_position')->default('left');
            $table->string('photo_position')->default('right');
            $table->boolean('show_logo')->default(true);
            $table->boolean('show_degree')->default(true);
            $table->boolean('show_designation')->default(true);
            $table->boolean('show_details')->default(true);
            $table->integer('position')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialist_cards');
    }
};
