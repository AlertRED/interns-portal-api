<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInternHomeworksTableAddScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intern_homeworks', function (Blueprint $table) {
            $table->tinyInteger('score')
                ->nullable(false)
                ->default(0)
                ->after("status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intern_homeworks', function (Blueprint $table) {
            $table->dropColumn("score");
        });
    }
}
