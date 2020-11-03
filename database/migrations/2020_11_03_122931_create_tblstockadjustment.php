<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblstockadjustment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblstockadjustment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('_prefix');
            $table->text('product_code');
            $table->integer('qtyToAdjust');
            $table->string('action');
            $table->string('remarks');
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
        Schema::dropIfExists('tblstockadjustment');
    }
}
