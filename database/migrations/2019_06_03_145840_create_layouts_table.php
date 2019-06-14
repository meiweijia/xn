<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->comment('楼栋ID');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('property')->default('')->comment('物业');
            //$table->unsignedBigInteger('property_id')->comment('物业');
            //$table->foreign('property_id')->references('id')->on('properties');
            $table->string('name')->default('')->comment('户型');
            $table->unsignedInteger('rent')->default(0)->comment('租金');
            $table->string('image')->nullable()->default(null)->comment('封面图');
            $table->json('carousel')->nullable()->default(null)->comment('图片');
            $table->text('description')->comment('描述');
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
        Schema::dropIfExists('layouts');
    }
}
