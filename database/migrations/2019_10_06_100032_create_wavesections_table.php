<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWavesectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wavesections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 30);
            $table->integer('categoryid')->unsigned()->index();
            $table->string('offer', 20);
            $table->text('description');
            $table->string('image', 50);
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('categoryid')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wavesections');
    }
}
