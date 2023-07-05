<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuPackagePivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_package_pivots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("menu_packages_id")->nullable();
            $table->unsignedBigInteger("restaurant_id")->nullable();

            $table->foreign("menu_packages_id")->references("id")->on("menu_packages")->onDelete('cascade');
            $table->foreign("restaurant_id")->references("id")->on("restaurants")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_package_pivots');
    }
}
