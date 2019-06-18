<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_ins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('house_id');
            $table->foreign('house_id')->references('id')->on('houses');
            $table->unsignedInteger('rent')->nullable()->default(null)->comment('租金');
            $table->unsignedInteger('deposit')->nullable()->default(null)->comment('押金');
            $table->dateTime('start_time')->nullable()->comment('起租日期');
            $table->dateTime('end_time')->nullable()->comment('截止日期');
            $table->unsignedInteger('peoples')->default(0)->comment('入住人数');
            $table->string('names')->nullable()->comment('全部入住人姓名');
            $table->json('id_card_images')->comment('身份证图片');
            $table->string('phone')->nullable()->comment('签约人电话');
            $table->boolean('status')->default(false)->comment('验收 1已验收 0未验收');
            $table->decimal('electric_number',8,1)->default(0.0)->comment('电表度数');
            $table->decimal('cold_water_number',8,0)->default(0)->comment('冷水表度数');
            $table->decimal('hot_water_number',8,0)->default(0)->comment('热水表度数');
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
        Schema::dropIfExists('house_ins');
    }
}
