<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseOutCleansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_out_cleans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id');
            $table->foreign('house_id')->references('id')->on('houses');
            $table->string('name')->nullable()->comment('联系人');
            $table->string('status')->nullable()->comment('卫生状况');
            $table->string('detail')->nullable()->comment('详细说明');
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
        Schema::dropIfExists('house_out_cleans');
    }
}
