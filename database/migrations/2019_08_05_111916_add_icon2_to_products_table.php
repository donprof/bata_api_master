<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIcon2ToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('icon2', 200)->after('icon')->nullable();
            $table->integer('warehouse_id')->after('description')->nullable();
            $table->string('circular_no', 200)->after('description')->nullable();
            $table->integer('shoe_status')->after('description')->nullable();
            $table->integer('source')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('icon2');
            $table->dropColumn('warehouse_id');
            $table->dropColumn('circular_no');
            $table->dropColumn('shoe_status');
            $table->dropColumn('source');
        });
    }
}
