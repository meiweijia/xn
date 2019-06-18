<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('type')->nullable()->comment('报修事宜');
            $table->string('name')->nullable()->comment('报修人');
            $table->string('phone')->nullable()->comment('报修联系电话');
            $table->string('repair_date')->nullable()->comment('维修日期');
            $table->string('duty')->nullable()->comment('事故责任');
            $table->string('detail')->nullable()->comment('详细说明');
            $table->json('images')->comment('图片');
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
        Schema::dropIfExists('public_areas');
    }
}
