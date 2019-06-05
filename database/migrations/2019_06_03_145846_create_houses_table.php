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
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('property_id')->default(0)->comment('物业');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->string('household')->nullable()->comment('户型');
            $table->unsignedInteger('rent')->default(0)->comment('租金');
            $table->string('image')->nullable()->default(null)->comment('封面图');
            $table->json('carousel')->nullable()->default(null)->comment('图片');
            $table->text('description')->comment('描述');
            $table->unsignedTinyInteger('peoples')->default(0)->comment('入住人数');
            $table->boolean('status')->comment('能否出租 1是 0否');
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
