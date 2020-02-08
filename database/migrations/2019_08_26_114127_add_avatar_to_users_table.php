<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar', 100)->after('email')->nullable();
            $table->date('dateofbirth')->after('email')->nullable();
            $table->integer('gendar')->after('email')->nullable();
            $table->double('phone')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('dateofbirth');
            $table->dropColumn('gendar');
            $table->dropColumn('phone');
        });
    }
}
