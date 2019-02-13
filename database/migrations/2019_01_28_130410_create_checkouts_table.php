<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('phoneNumber');
            $table->string('Amount');
            $table->integer('TransactionId');
            $table->string('transactionRecipient');
            $table->string('FLTPaidFor');
            $table->string('OriginSessionID');
            $table->string('PaymentID');
            $table->string('transactionDate');
            $table->string('transactionSourceNo');
            $table->string('transactionSourceType');
            $table->string('transactionDescription');
            $table->string('date_created');
            $table->string('last_updated');     
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
        Schema::dropIfExists('checkouts');
    }
}
