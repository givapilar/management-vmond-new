<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTimeStartToOtherSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_settings', function (Blueprint $table) {
            $table->time('time_start')->nullable();
            $table->time('time_close')->nullable();
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
            $table->dropColumn('time_start');
            $table->dropColumn('time_close');
        });
    }
}
