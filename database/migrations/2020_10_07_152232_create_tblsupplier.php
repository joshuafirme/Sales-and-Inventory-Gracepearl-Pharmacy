<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblsupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblsupplier', function (Blueprint $table) {
            $table->bigIncrements('id', 6);
            $table->string('_prefix');
            $table->string('supplierName');
            $table->string('address');
            $table->string('person');
            $table->string('contact');
            $table->string('email');
            $table->string('companyID');
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
        Schema::dropIfExists('tblsupplier');
    }
}
