<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueid');
            $table->integer('to')->unsigned();
            $table->integer('from')->unsigned();
            $table->string('title');
            $table->longtext('text');
            $table->boolean('viewed')->default(false);
            $table->boolean('deleted')->default(false);
            $table->timestamps();

            $table->foreign('to')->references('id')->on('users');
            $table->foreign('from')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
