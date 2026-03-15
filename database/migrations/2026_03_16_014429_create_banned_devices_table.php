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
        Schema::create('banned_devices', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('device_name')->nullable();
            $table->string('device_type')->nullable();
            $table->string('user_agent')->nullable();
            $table->foreignId('user_id')->nullable()->index();
            $table->boolean('is_active')->default(true);
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banned_devices');
    }
};
