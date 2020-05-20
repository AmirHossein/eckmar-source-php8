<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueid');
            $table->string('name');
            $table->longtext('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('buyout')->nullable();
            $table->integer('category_id')->unsigned();
            $table->boolean('auction')->default(0);
            $table->datetime('end_date')->nullable();
            $table->longtext('goods')->nullable();
            $table->longtext('refund_policy')->nullable();
            $table->boolean('sold')->default(0);
            $table->boolean('active')->default(1);
            $table->integer('state')->default(0);
            $table->boolean('autofilled')->default(0);
            $table->longtext('autofill')->nullable();
            $table->integer('seller_id')->unsigned();
            $table->integer('buyer_id')->nullable()->unsigned();
            $table->datetime('purchase_time')->nullable();
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
