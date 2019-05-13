<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_page', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1)->index('status');
            $table->string('slug')->nullable()->index('slug');
            $table->string('def_name')->nullable();
            $table->string('def_description')->nullable();
            $table->timestamps();
        });
        
        
        Schema::create('static_page_language',function (Blueprint $table){
            $table->increments('id');
            $table->integer('static_page_id')->unsigned()->index('static_page');
            $table->char('language',10)->default('ru')->index('language');
            
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
            
            $table->index(['static_page_id','language']);
            
            $table->foreign('static_page_id')
                ->references('id')
                ->on('static_page')
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('static_page_language');
        Schema::dropIfExists('static_page');
    }
}
