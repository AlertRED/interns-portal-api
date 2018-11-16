<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intern_homeworks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id")->unsigned()->nullable(false);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer("homework_id")->unsigned()->nullable(false);
            $table->foreign('homework_id')
                ->references('id')->on('homeworks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string("github_uri")->nullable(false)->default("");
            $table->string("status")->nullable(false)->default("");
            $table->timestamp("started_at")->useCurrent();
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
        Schema::table('intern_homeworks', function (Blueprint $table)
        {
            $table->dropForeign(['homework_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('intern_homeworks');
    }
}
