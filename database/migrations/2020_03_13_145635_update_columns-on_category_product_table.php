<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsOnCategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->integer('parent_id')->unsigned()->index();
            $table->integer('subcategory_id')->unsigned()->index();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('parent_id')->references('parent_id')->on('categories');
            $table->foreign('subcategory_id')->references('subcategory_id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_product');
    }
}
