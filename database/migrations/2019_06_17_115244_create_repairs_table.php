<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('house_id');
            $table->foreign('house_id')->references('id')->on('houses');
            $table->date('repair_date')->nullable()->comment('维修日期');
            $table->string('matters')->nullable()->comment('维修事项');
            $table->string('duty')->nullable()->comment('事故责任 自然损坏 人为损坏 无法判定');
            $table->string('detail')->nullable()->comment('详细说明');
            $table->json('images')->comment('图片');
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
        Schema::dropIfExists('repairs');
    }
}
