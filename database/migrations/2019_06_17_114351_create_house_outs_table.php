<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_outs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('house_id');
            $table->foreign('house_id')->references('id')->on('houses');
            $table->unsignedTinyInteger('bathroom')->default(1)->comment('卫浴区 1正常 2有损 3有污渍 4严重损坏');
            $table->unsignedTinyInteger('parlour')->default(1)->comment('客厅区 1正常 2有损 3有污渍 4严重损坏');
            $table->unsignedTinyInteger('kitchen')->default(1)->comment('厨房区 1正常 2有损 3有污渍 4严重损坏');
            $table->json('bedroom')->default(1)->comment('卧室区 1正常 2有损 3有污渍 4严重损坏 数组格式');
            $table->json('images')->comment('照片');
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
        Schema::dropIfExists('house_outs');
    }
}
