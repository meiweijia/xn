<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id')->default(0)->comment('房间编号');
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');
            $table->string('name')->default('')->comment('姓名');
            $table->string('id_card')->default('')->comment('身份证号');
            $table->json('id_card_images')->comment('身份证图片');
            $table->string('tel')->default('')->comment('手机号');
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
        Schema::dropIfExists('tenants');
    }
}
