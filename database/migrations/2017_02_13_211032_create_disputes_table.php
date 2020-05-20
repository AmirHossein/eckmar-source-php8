<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueid');
            $table->integer('purchase_id')->unsigned();
            $table->integer('seller_id')->unsigned();
            $table->integer('buyer_id')->unsigned();
            $table->boolean('resolved')->default(false);
            $table->integer('winner')->nullable();
            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreign('seller_id')->references('id')->on('users');        
            $table->foreign('purchase_id')->references('id')->on('purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disputes');
    }
}
