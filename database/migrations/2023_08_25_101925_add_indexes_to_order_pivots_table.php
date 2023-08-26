<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToOrderPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_pivots', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('created_at');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_pivots', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['category']);
        });
    }
}
