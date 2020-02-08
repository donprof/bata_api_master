<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVouchepriceidToPromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->integer('voucheprice_id')->after('promocode')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->dropColumn('voucheprice_id')->references('id')->on('voucherprice');
        });
    }
}
