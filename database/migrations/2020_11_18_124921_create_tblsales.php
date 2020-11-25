<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblsales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblsales', function (Blueprint $table) {
            $table->bigIncrements('transactionID');
            $table->string('_prefix');
            $table->string('product_code');
            $table->integer('qty');
            $table->string('date');
            $table->double('amount');
            $table->integer('employeeID');
            $table->string('order_from');
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
        Schema::dropIfExists('tblsales');
    }
}
