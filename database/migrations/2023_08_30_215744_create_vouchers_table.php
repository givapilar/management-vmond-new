<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_promosi')->nullable();
            $table->string('code')->unique()->nullable();
            $table->float('harga')->nullable();
            $table->float('discount')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0)->nullable();
            $table->float('minimum_transaksi')->nullable();
            $table->float('maximum_transaksi')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
