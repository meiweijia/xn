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
            $table->date('start_time ')->nullable()->comment('起租日期');
            $table->date('end_time ')->nullable()->comment('截止日期');
            $table->date('leave_time ')->nullable()->comment('搬離日期');
            $table->unsignedTinyInteger('bathroom')->nullable()->comment('卫浴区 1正常 2有损 3有污渍 4严重损坏');
            $table->unsignedTinyInteger('parlour')->nullable()->comment('客厅区 1正常 2有损 3有污渍 4严重损坏');
            $table->unsignedTinyInteger('kitchen')->nullable()->comment('厨房区 1正常 2有损 3有污渍 4严重损坏');
            $table->json('bedroom')->nullable()->comment('卧室区 1正常 2有损 3有污渍 4严重损坏 数组格式');
            $table->json('images')->nullable()->comment('照片');
            $table->boolean('approve')->default(false)->comment('审批');
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
