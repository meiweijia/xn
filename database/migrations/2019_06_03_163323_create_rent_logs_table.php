<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('property_id')->default(0)->comment('物业ID');
            //$table->foreign('property_id')->references('id')->on('properties');
            $table->string('property')->default('')->comment('物业名');
            $table->unsignedInteger('house_id')->comment('房间');
            $table->unsignedInteger('house_number')->default(0)->comment('房间编号');
            $table->decimal('house_rent')->default(0.00)->comment('租金');
            $table->decimal('last_electric_number', 8, 1)->default(0.0)->comment('上月电表度数');
            $table->decimal('electric_number', 8, 1)->default(0.0)->comment('本月电表度数');
            $table->decimal('electric_cost')->default(0)->comment('电费');
            $table->decimal('last_cold_water_number', 8, 0)->default(0)->comment('上月冷水表度数');
            $table->decimal('cold_water_number', 8, 0)->default(0)->comment('本月冷水表度数');
            $table->decimal('last_hot_water_number', 8, 0)->default(0)->comment('上月热水表度数');
            $table->decimal('hot_water_number', 8, 0)->default(0)->comment('本月热水表度数');
            $table->decimal('water_cost')->default(0)->comment('水费');
            $table->decimal('other_cost')->default(0)->comment('其他费用');
            $table->decimal('total_cost')->default(0)->comment('费用合计');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 0未发送 1已发送 2已支付');
            $table->string('payment_method')->nullable()->comment('支付方式');
            $table->string('payment_no')->nullable()->comment('支付方订单号');
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
        Schema::dropIfExists('rent_logs');
    }
}
