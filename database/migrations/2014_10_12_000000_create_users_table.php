<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('tel')->nullable()->unique()->default(null);
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->string('open_id')->nullable()->unique()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->unsignedTinyInteger('type')->default(1)->comment('用户类型 1住户 2员工');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
