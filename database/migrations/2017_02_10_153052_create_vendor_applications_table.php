<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueid');
            $table->integer('user_id')->unsigned();
            $table->integer('status')->default(0);
            $table->longtext('offer');
            $table->longtext('void');
            $table->longtext('other_markets');

            $table->foreign('user_id')->references('id')->on('users');


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
        Schema::dropIfExists('vendor_applications');
    }
}
