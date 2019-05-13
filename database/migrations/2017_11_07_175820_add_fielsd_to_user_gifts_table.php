<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFielsdToUserGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_status',function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->nullable()->index('code');
            $table->string('temp_name')->nullable()->index('temp_name');
            $table->timestamps();
        });
        
        Schema::table('user_gifts',function (Blueprint $table){
            $table->integer('status_id')->nullable()->unsigned()->index();
            $table->integer('balance_id')->nullable()->unsigned()->index();
            $table->integer('project_id')->nullable()->unsigned()->index();
            
            $table->foreign('status_id')
                ->references('id')
                ->on('gift_status')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->foreign('balance_id')
                ->references('id')
                ->on('balance')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->foreign('project_id')
                ->references('id')
                ->on('project')
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
        Schema::table('user_gifts',function (Blueprint $table){
            $table->dropForeign(['status_id']);
            $table->dropForeign(['balance_id']);
            $table->dropForeign(['project_id']);
            $table->dropColumn('status_id');
            $table->dropColumn('balance_id');
            $table->dropColumn('project_id');
        });
        Schema::dropIfExists('gift_status');
        
    }
}
