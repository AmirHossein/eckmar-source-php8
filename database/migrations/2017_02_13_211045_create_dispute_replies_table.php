<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisputeRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispute_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueid');
            $table->integer('user_id')->unsigned();
            $table->integer('dispute_id')->unsigned();
            $table->longtext('message');
            $table->boolean('adminreply')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('dispute_id')->references('id')->on('disputes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispute_replies');
    }
}
