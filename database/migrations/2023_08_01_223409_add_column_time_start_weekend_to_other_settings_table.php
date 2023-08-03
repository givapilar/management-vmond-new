<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTimeStartWeekendToOtherSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_settings', function (Blueprint $table) {
            $table->time('time_start_weekend')->nullable();
            $table->time('time_close_weekend')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('other_settings', function (Blueprint $table) {
            $table->dropColumn('time_start_weekend');
            $table->dropColumn('time_close_weekend');
        });
    }
}
