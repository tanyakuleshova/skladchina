<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyTables extends Migration
{
    /**
     * Создаём две таблифы для валют в системе
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency',function (Blueprint $table){
            $table->increments('id');
            $table->string('code')->default('UAH')->nullable()->index('code');
            $table->string('iso')->nullable()->index('iso');
            $table->string('html')->nullable();
            $table->string('unicode')->nullable();
            $table->string('thumb')->nullable();
            $table->string('image')->nullable();
        });
        
        
        Schema::create('currency_language',function (Blueprint $table){
            $table->increments('id');
            $table->integer('currency_id')->nullable()->unsigned()->index('currency');
            $table->string('language')->default('ru')->nullable()->index('language');
            $table->string('name')->nullable();
            $table->string('short')->nullable();
            $table->index(['currency_id','language'], 'currency_language');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currency')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_language');
        Schema::dropIfExists('currency');
    }
}
