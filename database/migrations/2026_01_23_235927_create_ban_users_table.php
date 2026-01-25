<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ban_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->boolean('is_banned')->default(false);
            $table->timestamp('banned_at')->nullable();
            $table->text('ban_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ban_users');
    }
};
