<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProjectRequisitesRequisitiesGallaryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_requisites',function (Blueprint $table){
            $table->dateTime('deleted_at')->nullable()->index('deleted');
        });
        
        Schema::table('project_requisities_gallary',function (Blueprint $table){
            $table->dateTime('deleted_at')->nullable()->index('deleted');
        });
        
        Schema::table('project_video',function (Blueprint $table){
            $table->dateTime('deleted_at')->nullable()->index('deleted');
        });
        
        Schema::table('users',function (Blueprint $table){
            $table->dateTime('deleted_at')->nullable()->index('deleted');
        });
        
        Schema::table('user_account',function (Blueprint $table){
            $table->dateTime('deleted_at')->nullable()->index('deleted');
            $table->dateTime('google_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_requisites',function (Blueprint $table){            
            $table->dropColumn('deleted_at');
        });
        
        Schema::table('project_requisities_gallary',function (Blueprint $table){            
            $table->dropColumn('deleted_at');
        });
        
        Schema::table('project_video',function (Blueprint $table){            
            $table->dropColumn('deleted_at');
        });
        
        Schema::table('users',function (Blueprint $table){            
            $table->dropColumn('deleted_at');
        });
        
        Schema::table('user_account',function (Blueprint $table){            
            $table->dropColumn('deleted_at');
            $table->dropColumn('google_id');
        });
    }
}
