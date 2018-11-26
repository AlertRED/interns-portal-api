<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_leads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                ->nullable()
                ->unsigned()
                ->default(null);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer("course_id")
                ->nullable(true)
                ->unsigned();
            $table->foreign('course_id')
                ->references('id')->on('internship_courses')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
        Schema::dropIfExists('course_leads');
    }
}
