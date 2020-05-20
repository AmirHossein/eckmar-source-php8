<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueid');
            $table->string('password');
            $table->string('username');
            $table->longtext('mnemonic');
            $table->longtext('profile')->nullable();
            $table->longtext('pgp')->nullable();
            $table->unsignedBigInteger('balance');
            $table->unsignedBigInteger('last_credited')->default(0);
            $table->integer('pin');
            $table->boolean('vendor');
            $table->boolean('admin');
            $table->boolean('verified');
            $table->datetime('last_seen')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
