<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedTinyInteger('type')->default(1)->comment('工作日志人 1日班 2夜班');
            $table->text('patrol')->comment('巡查发现');
            $table->json('images')->comment('图片');
            $table->unsignedInteger('vacant')->nullable()->comment('空房数量');
            $table->string('vacant_number')->nullable()->comment('空房房号');
            $table->string('daily_summary')->nullable()->comment('总结');
            $table->text('detail')->comment('详细描述');
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
        Schema::dropIfExists('job_logs');
    }
}
