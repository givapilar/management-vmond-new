<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMinimumOrderToMejaRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meja_restaurants', function (Blueprint $table) {
            $table->float('minimal_order')->nullable();
            $table->string('status_minimal_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meja_restaurants', function (Blueprint $table) {
            $table->dropColumn('minimal_order');
            $table->dropColumn('status_minimal_order');

        });
    }
}
