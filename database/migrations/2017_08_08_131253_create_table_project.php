<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_categories',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('lang_local');
            $table->timestamps();
        });

        Schema::create('project_status',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('project',function (Blueprint $table){
            $table->increments('id');
            $table->tinyInteger('mod_status')->default(0); //tinyint 3
            $table->integer('level_project')->default(0);
            $table->integer('user_id')->unsigned()->index();
            $table->integer('category_id')->nullable()->unsigned()->index();
            $table->integer('project_status_id')->unsigned()->index();
            $table->string('name')->nullable();
            $table->text('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->string('poster_link')->nullable();
            $table->string('location')->nullable();
            $table->integer('need_sum')->nullable();
            $table->date('date_finish')->nullable();
            $table->integer('current_sum')->nullable();
            $table->boolean('project_giftt_type')->default(0);
            $table->string('lang_local');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('project_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('project_status_id')
                ->references('id')
                ->on('project_status')
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
        Schema::dropIfExists('project_categories');
        Schema::dropIfExists('project_status');
        Schema::dropIfExists('project');
    }
}
