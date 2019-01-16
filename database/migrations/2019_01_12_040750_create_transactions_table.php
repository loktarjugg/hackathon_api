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
            $table->bigInteger('blockNumber');
            $table->timestamp('timeStamp');
            $table->string('hash', 191);
            $table->integer('nonce');
            $table->string('blockHash', 191);
            $table->integer('transactionIndex');
            $table->string('from', 64);
            $table->string('to', 64)->nullable();
            $table->string('value', 191);
            $table->string('gas', 100);
            $table->string('gasPrice', 100);
            $table->boolean('isError');
            $table->boolean('txreceipt_status');
            $table->text('input');
            $table->string('contractAddress', 64);
            $table->string('cumulativeGasUsed', 100);
            $table->string('gasUsed', 100);
            $table->integer('confirmations');
            $table->timestamps();
            $table->unique('hash');
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
