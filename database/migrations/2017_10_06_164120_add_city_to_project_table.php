<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityToProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project',function (Blueprint $table){
            $table->integer('city_id')->nullable()->unsigned()->index('city');
            $table->foreign('city_id')
                ->references('id')
                ->on('list_city')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project',function (Blueprint $table){
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
}
