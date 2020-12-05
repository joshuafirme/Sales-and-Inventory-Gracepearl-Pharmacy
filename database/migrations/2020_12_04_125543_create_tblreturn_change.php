<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblreturnChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblreturn_change', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sales_inv_no');
            $table->integer('qty');
            $table->string('action');
            $table->string('product_code_changed');
            $table->string('reason');
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
        Schema::dropIfExists('tblreturn_change');
    }
}
