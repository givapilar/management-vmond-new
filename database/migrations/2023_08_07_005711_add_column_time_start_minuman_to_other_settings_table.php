<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTimeStartMinumanToOtherSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_settings', function (Blueprint $table) {
            $table->time('time_start_weekdays_minuman')->nullable();
            $table->time('time_start_weekend_minuman')->nullable();
            $table->time('time_close_weekdays_minuman')->nullable();
            $table->time('time_close_weekend_minuman')->nullable();
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
            $table->dropColumn('time_start_weekdays_minuman');
            $table->dropColumn('time_start_weekend_minuman');
            $table->dropColumn('time_close_weekdays_minuman');
            $table->dropColumn('time_close_weekend_minuman');
        });
    }
}
