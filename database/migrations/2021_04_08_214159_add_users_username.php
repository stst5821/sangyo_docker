<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersUsername extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 32)->unique('users_username_unique')->after('id')->comment('ユーザー名');
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
            $table->dropColumn('username');
        });
    }
}
