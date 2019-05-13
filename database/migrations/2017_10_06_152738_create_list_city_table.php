<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_city',function (Blueprint $table){
            $table->increments('id');
            $table->string('seo')->index('seo');
            $table->string('thumb')->nullable();//
            $table->timestamps();
            });
            
        Schema::create('list_city_description',function (Blueprint $table){
            $table->increments('id');
            $table->integer('list_city_id')->unsigned()->index('list_city_id');
            $table->char('language',10)->default('ru')->index('language');
            $table->string('name')->nullable();
            $table->foreign('list_city_id')
                ->references('id')
                ->on('list_city')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
       Schema::dropIfExists('list_city_description'); 
       Schema::dropIfExists('list_city');
       
    }
}
