<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watchers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('address', 128);
            $table->bigInteger('block_number')->default(0);
            $table->bigInteger('sync_block_number')->default(0);
            $table->string('score', 100)->default(0);
            $table->unique('address');
            $table->boolean('status')->default(false)->comment('status 0 wait for processing 1 processed');
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
        Schema::dropIfExists('watchers');
    }
}
