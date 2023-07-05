<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddOnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_on_details', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger("add_on_id")->nullable();
             $table->string("nama")->nullable();
             $table->bigInteger("harga")->nullable();

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
        Schema::dropIfExists('add_on_details');
    }
}
