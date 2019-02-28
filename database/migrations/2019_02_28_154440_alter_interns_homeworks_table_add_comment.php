<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInternsHomeworksTableAddComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intern_homeworks', function (Blueprint $table) {
            $table->mediumText("reviewer_comment")->after("score");
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
            $table->dropColumn("reviewer_comment");
        });
    }
}
