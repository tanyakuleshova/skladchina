<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMlCategoryProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_categories',function (Blueprint $table){
            $table->string('name')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('lang_local')->nullable()->change();
            $table->string('thumb')->nullable();
        });
        
        Schema::create('project_categories_description',function (Blueprint $table){
            $table->increments('id');
            $table->integer('project_categories_id')->unsigned()->index('project_categories_id');
            $table->char('language',10)->default('ru')->index('language');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->foreign('project_categories_id')
                ->references('id')
                ->on('project_categories')
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
        Schema::dropIfExists('project_categories_description'); 
        
        
        Schema::table('project_categories',function (Blueprint $table){
            $table->dropColumn('thumb');
        });
    }
}
