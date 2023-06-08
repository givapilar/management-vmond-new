<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->text('description')->nullable();
            $table->enum('category', ['billiard', 'meeting_room']);
            $table->unsignedBigInteger("billiard_id")->nullable();
            $table->unsignedBigInteger("room_meeting_id")->nullable();

            $table->foreign("billiard_id")->references("id")->on("biliards")->onDelete('cascade');
            $table->foreign("room_meeting_id")->references("id")->on("meeting_rooms")->onDelete('cascade');
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
        Schema::dropIfExists('menu_packages');
    }
}
