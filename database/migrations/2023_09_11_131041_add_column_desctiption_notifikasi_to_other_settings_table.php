<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDesctiptionNotifikasiToOtherSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_settings', function (Blueprint $table) {
            $table->text('description_notifikasi')->nullable();
            $table->string('status_notifikasi')->nullable();
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
            $table->dropColumn('description_notifikasi');
            $table->dropColumn('status_notifikasi');
        });
    }
}
