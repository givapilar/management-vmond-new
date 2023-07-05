<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("material_id")->nullable();
            $table->bigInteger("material_masuk");
            $table->bigInteger("current_stock")->nullable();
            $table->text('description')->nullable();

            $table->foreign("material_id")->references("id")->on("material");
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
        Schema::dropIfExists('stok_masuk');
    }
}
