<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->string("key", 50)->nullable(false);
            $table->string("role", 20)->nullable(false)->default("User");
            $table->boolean("is_used")->nullable(false)->default(false);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::table('registration_keys', function (Blueprint $table)
        {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('registration_keys');
    }
}
