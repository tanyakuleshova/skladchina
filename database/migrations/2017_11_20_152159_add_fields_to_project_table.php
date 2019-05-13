<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project',function (Blueprint $table){

            $table->unsignedInteger('status_id')->nullable()->index('status');
            
            $table->unsignedInteger('viewed')->default(0)->index('viewed');
            
            $table->string('valid_steps')->nullable();
            
            $table->dateTime('date_start')->nullable()->index('date_start');
            $table->dateTime('deleted_at')->nullable()->index('deleted');
            
            $table->foreign('status_id')
                ->references('id')
                ->on('project_status')
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
        Schema::table('project',function (Blueprint $table){
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
            
            $table->dropColumn(['viewed','date_start','deleted_at','valid_steps']);
        });
    }
}
