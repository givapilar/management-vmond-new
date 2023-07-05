<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMejaControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meja_controls', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->unsignedBigInteger("billiard_id")->nullable();

            $table->foreign("billiard_id")->references("id")->on("biliards")->onDelete('cascade');
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
        Schema::dropIfExists('meja_controls');
    }
}
