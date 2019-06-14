<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecommendToHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layouts', function (Blueprint $table) {
            $table->boolean('recommend')
                ->default(0)
                ->after('description')
                ->comment('首页推荐 1是 0否');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layouts', function (Blueprint $table) {
            $table->dropColumn('recommend');
        });
    }
}
