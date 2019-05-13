<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_types', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1)->index('status');
            $table->string('code')->nullable()->index('code');
            $table->timestamps();
        });
        
        Schema::create('project_types_description',function (Blueprint $table){
            $table->increments('id');
            $table->integer('project_types_id')->unsigned()->index('project_types');
            $table->char('language',10)->default('ru')->index('language');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            
            $table->index(['project_types_id','language']);
            
            $table->foreign('project_types_id')
                ->references('id')
                ->on('project_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();            
        });
        
        Schema::table('project',function (Blueprint $table){
            $table->integer('type_id')->nullable()->unsigned()->index('type');
            $table->foreign('type_id')
                ->references('id')
                ->on('project_types')
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
        
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('project_types_description');
        Schema::dropIfExists('project_types');
        
        Schema::table('project',function (Blueprint $table){
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');
        });
    }
}
