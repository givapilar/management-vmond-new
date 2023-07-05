<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNoteAndLinkToPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->text('note')->nullable();
            $table->string('id_stock')->nullable();
            $table->unsignedBigInteger("link_id")->nullable();

            $table->foreign("link_id")->references("id")->on("link_permits")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropColumn('id_stock');
            $table->dropColumn('link_id');
        });
    }
}
