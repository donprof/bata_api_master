<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductVariationTypeIdToProductimages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productimages', function (Blueprint $table) {
            $table->integer('product_variation_type_id')->after('product_id')->unsigned()->default(1)->index();

            $table->foreign('product_variation_type_id')->references('id')->on('product_variation_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productimages', function (Blueprint $table) {
            $table->dropColumn('product_variation_type_id');
        });
    }
}
