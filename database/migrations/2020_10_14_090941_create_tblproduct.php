<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblproduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblproduct', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('_prefix');
            $table->text('description');
            $table->integer('qty');
            $table->integer('re_order');
            $table->integer('unitID');
            $table->string('categoryID');
            $table->string('supplierID');
            $table->double('orig_price');
            $table->double('selling_price');
            $table->string('exp_date');
            $table->string('image')->nullable();
            $table->timestamps();
        });
      //  DB::statement('ALTER TABLE tblproduct CHANGE id id INT(5) UNSIGNED ZEROFILL NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblproduct');
    }
}
