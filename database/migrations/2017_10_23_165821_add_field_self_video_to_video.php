<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldSelfVideoToVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_video',function (Blueprint $table){
            $table->integer('self_video')->default(0)->unsigned()->index('self_video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_video',function (Blueprint $table){
            $table->dropColumn('self_video');
        });
    }
}
