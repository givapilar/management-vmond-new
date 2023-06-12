<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnImageToMenuPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_packages', function (Blueprint $table) {
            $table->text('image')->nullable();
            $table->integer('harga')->nullable();
            $table->integer('harga_diskon')->nullable();
            $table->bigInteger("persentase")->nullable();
            $table->string("slug")->nullable();
            $table->enum('status', ['Tersedia', 'Tidak Tersedia']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_packages', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
