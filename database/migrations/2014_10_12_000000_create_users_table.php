<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name')->default("");
            $table->string("course")->nullable(true);
            $table->string("role")->nullable(false)->default("User");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token', 30)->unique();
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