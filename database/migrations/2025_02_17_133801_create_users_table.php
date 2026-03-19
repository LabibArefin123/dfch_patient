<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');

            $table->rememberToken();

            // 📱 Contact
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();

            // 🖼 Profile
            $table->string('profile_picture')->nullable();

            // 🔐 Two Factor
            $table->boolean('two_factor_enabled')->default(0);
            $table->string('two_factor_code', 10)->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();

            // ⏱ Session
            $table->float('session_timeout')->default(5);

            // 🛠 Maintenance Mode
            $table->boolean('is_maintenance')->default(0);
            $table->string('maintenance_message')->nullable();

            // 🚫 Ban System
            $table->boolean('is_banned')->default(0);

            // 🟢 Online Status
            $table->timestamp('last_seen')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
