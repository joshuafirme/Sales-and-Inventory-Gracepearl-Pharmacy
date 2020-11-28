<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblsupplierDelivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblsupplier_delivery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('_prefix');
            $table->int('delivery_num');
            $table->string('product_code');
            $table->integer('qty_delivered');
            $table->string('exp_date');
            $table->string('date_recieved');
            $table->double('amount');
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
        Schema::dropIfExists('tblsupplier_delivery');
    }
}
