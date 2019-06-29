<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('executor_id');
            $table->foreign('executor_id')->references('id')->on('users');
            $table->string('title')->comment('任务');
            $table->string('detail')->comment('详细说明');
            $table->string('images')->nullable()->comment('图片');
            $table->unsignedTinyInteger('approve')->default(0)->comment('审批 0未审核 1通过 2未通过');
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
        Schema::dropIfExists('tasks');
    }
}
