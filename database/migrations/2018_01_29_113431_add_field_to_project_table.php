<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project',function (Blueprint $table){
            $table->unsignedInteger('duration')->nullable()->index('duration');
        });
        
        Schema::table('project_gifts',function (Blueprint $table){
            $table->unsignedInteger('duration')->nullable()->index('duration');
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
            $table->dropColumn('duration');
        });
        
        Schema::table('project_gifts',function (Blueprint $table){
            $table->dropColumn('duration');
        });
    }
}
