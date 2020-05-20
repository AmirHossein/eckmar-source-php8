<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueid');
            $table->boolean('active');
            $table->boolean('positive');
            $table->integer('seller_id')->unsigned();
            $table->integer('buyer_id')->unsigned();
            $table->integer('for')->unsigned();
            $table->integer('from')->unsigned();
            $table->integer('purchase_id')->unsigned();
            $table->text('comment');
            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('for')->references('id')->on('users');
            $table->foreign('from')->references('id')->on('users');
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
        Schema::dropIfExists('feedback');
    }
}
