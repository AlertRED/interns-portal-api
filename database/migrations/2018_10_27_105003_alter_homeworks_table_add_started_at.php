<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHomeworksTableAddStartedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('homeworks', function (Blueprint $table) {
            $table->timestamp("start_date")
                ->nullable()
                ->after("course_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('homeworks', function (Blueprint $table) {
            $table->dropColumn("start_date");
        });
    }
}
