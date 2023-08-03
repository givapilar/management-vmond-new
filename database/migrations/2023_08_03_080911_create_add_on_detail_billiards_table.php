<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddOnDetailBilliardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_on_detail_billiards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("add_on_billiard_id")->nullable();
            $table->unsignedBigInteger("restaurant_id")->nullable();
             $table->bigInteger("harga")->nullable();

            $table->foreign("add_on_billiard_id")->references("id")->on("add_on_billiards")->onDelete('cascade');
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
        Schema::dropIfExists('add_on_detail_billiards');
    }
}
