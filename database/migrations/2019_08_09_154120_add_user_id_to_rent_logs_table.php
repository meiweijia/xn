<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToRentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rent_logs', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->comment('用户id');
            $table->string('gzh_open_id')->nullable()->comment('公众号openid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rent_logs', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('gzh_open_id');
        });
    }
}
