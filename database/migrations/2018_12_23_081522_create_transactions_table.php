<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clientAccount');
            $table->string('source');
            $table->string('provider');
            $table->string('description');
            $table->string('providerChannel');
            $table->string('transactionFee');
            $table->string('providerRefId');
            $table->string('providerFee');
            $table->string('status');
            $table->string('firstName');
            $table->string('middleName');
            $table->string('lastName');
            $table->string('amount');
            $table->string('transactionDate');
            $table->string('transactionId');
            $table->string('creationTime');
            $table->string('category');             
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
        Schema::dropIfExists('transactions');
    }
}
