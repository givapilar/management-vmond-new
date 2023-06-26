<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_add_ons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("restaurant_id")->nullable();
            $table->unsignedBigInteger("add_on_id")->nullable();
            
            $table->foreign("restaurant_id")->references("id")->on("restaurants")->onDelete('cascade');
            $table->foreign("add_on_id")->references("id")->on("add_ons")->onDelete('cascade');
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
        Schema::dropIfExists('restaurant_add_ons');
    }
}
