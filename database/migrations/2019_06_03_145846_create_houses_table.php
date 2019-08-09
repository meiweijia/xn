<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('number')->default(0)->comment('编号');
            $table->unsignedBigInteger('category_id')->comment('楼栋ID');
            $table->unsignedBigInteger('layout_id')->comment('户型ID');
            $table->unsignedBigInteger('user_id')->nullable()->default(null)->comment('用户ID');
            $table->unsignedInteger('rent')->nullable()->default(null)->comment('租金 默认继承户型的租金，也可以设置自己的租金');
            $table->unsignedTinyInteger('peoples')->default(0)->comment('入住人数');
            $table->boolean('status')->default(true)->comment('能否出租 1是 0否');
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
        Schema::dropIfExists('houses');
    }
}
