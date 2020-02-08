<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('address_id')->unsigned()->index();
            $table->integer('payment_method_id')->unsigned()->index();
            $table->integer('shipping_method_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('order_id')->unsigned()->index();
            $table->double('amount');
            $table->string('mpesareceiptnumber', 100);
            $table->dateTime('transactiondate');
            $table->string('phonenumber');
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpesas');
    }
}
