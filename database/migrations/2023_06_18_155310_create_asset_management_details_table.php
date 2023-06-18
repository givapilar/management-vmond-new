<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetManagementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_management_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("asset_management_id")->nullable();

            $table->string('location')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->string('image')->nullable();

            $table->foreign("asset_management_id")->references("id")->on("asset_managements")->onDelete('cascade');
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
        Schema::dropIfExists('asset_management_details');
    }
}
