<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->smallInteger("number");
            $table->string("url")->default('');
            $table->integer("course_id")->unsigned();
            $table->foreign('course_id')
                ->references('id')->on('internship_courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamp("deadline");
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
        Schema::table('homeworks', function (Blueprint $table)
        {
            $table->dropForeign(['course_id']);
        });
        Schema::dropIfExists('homeworks');
    }
}
