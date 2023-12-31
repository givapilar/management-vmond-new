<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnHargaToAssetManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_managements', function (Blueprint $table) {
            $table->bigInteger("harga")->nullable();
            $table->string("image")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_managements', function (Blueprint $table) {
            $table->dropColumn('harga');
            $table->dropColumn('image');
        });
    }
}
