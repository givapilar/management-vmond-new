<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeDataHargaToBiliardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biliards', function (Blueprint $table) {
        //    $table->double('harga')->change();
           DB::statement('ALTER TABLE biliards ALTER COLUMN harga TYPE integer USING (harga::integer)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biliards', function (Blueprint $table) {
            //
        });
    }
}
