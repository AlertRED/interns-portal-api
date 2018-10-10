<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableChangeCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn("course");
            $table->integer("course_id")
                ->nullable(true)
                ->unsigned()
                ->after("last_name");
            $table->foreign('course_id')
                ->references('id')->on('internship_courses')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->dropForeign(['course_id']);
            $table->dropColumn("course_id");
            $table->string("course")->nullable(true);
        });
    }
}
