<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('telephone')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->default('-')->nullable();
            $table->unsignedBigInteger("supplier_id")->nullable();

            $table->foreign("supplier_id")->references("id")->on("suppliers")->onDelete('cascade');
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
        Schema::dropIfExists('detail_suppliers');
    }
}
