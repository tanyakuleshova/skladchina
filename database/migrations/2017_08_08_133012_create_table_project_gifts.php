<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProjectGifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_gifts',function (Blueprint $table){
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->integer('need_sum');
            $table->integer('limit');
            $table->string('delivery_date');
            $table->string('delivery_method');
            $table->string('image_link');
            $table->text('description');
            $table->string('question_user');
            $table->foreign('project_id')
                ->references('id')
                ->on('project')
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
        Schema::dropIfExists('project_gifts');
    }
}
