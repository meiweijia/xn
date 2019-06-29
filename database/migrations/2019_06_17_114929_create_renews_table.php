<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id');
            $table->foreign('house_id')->references('id')->on('houses');
            $table->string('contract_old')->nullable()->comment('旧合同第一页');
            $table->string('contract_new')->nullable()->comment('新合同第一页');
            $table->string('recovery')->nullable()->comment('收回');
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
        Schema::dropIfExists('renews');
    }
}
