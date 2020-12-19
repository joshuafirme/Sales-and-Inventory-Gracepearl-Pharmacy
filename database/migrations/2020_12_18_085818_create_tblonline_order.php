<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblonlineOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblonline_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('_prefix');
            $table->string('email');
            $table->string('product_code');
            $table->integer('qty');
            $table->double('amount');
            $table->string('payment_method');
            $table->string('status');
            $table->string('shippingID');
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
        Schema::dropIfExists('tblonline_order');
    }
}
