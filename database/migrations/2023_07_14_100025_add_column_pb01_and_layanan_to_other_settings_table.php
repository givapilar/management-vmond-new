<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPb01AndLayananToOtherSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_settings', function (Blueprint $table) {
            $table->integer('pb01')->default(10);
            $table->float('layanan')->default(5000);
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
            $table->dropColumn('pb01');
            $table->dropColumn('layanan');
        });
    }
}
