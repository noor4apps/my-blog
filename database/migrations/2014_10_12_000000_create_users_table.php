<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique(); // new
            $table->string('email')->unique();
            $table->string('mobile')->unique(); // new
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('user_image')->nullable(); // new
            $table->unsignedTinyInteger('status')->default(1); // new
            $table->text('bio')->nullable(); // new
            $table->unsignedTinyInteger('receive_email')->default(0); // new
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
