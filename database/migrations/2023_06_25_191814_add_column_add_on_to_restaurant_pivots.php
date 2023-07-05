<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAddOnToRestaurantPivots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_pivots', function (Blueprint $table) {
            $table->unsignedBigInteger("add_on_id")->nullable();

            $table->foreign("add_on_id")->references("id")->on("add_ons")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_pivots', function (Blueprint $table) {
            $table->dropColumn('add_on_id');
        });
    }
}
