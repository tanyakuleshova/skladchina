<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1)->index('status');
            $table->string('code')->nullable()->index('code');
            $table->string('def_name')->nullable();
            $table->string('def_description')->nullable();
        });
        
        Schema::create('gift_deliveries_language',function (Blueprint $table){
            $table->increments('id');
            $table->integer('gift_deliveries_id')->unsigned()->index('gift_deliveries');
            $table->char('language',10)->default('ru')->index('language');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            
            $table->index(['gift_deliveries_id','language']);
            
            $table->foreign('gift_deliveries_id')
                ->references('id')
                ->on('gift_deliveries')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();            
        });
        
        Schema::table('project_gifts',function (Blueprint $table){
            $table->integer('delivery_id')->nullable()->unsigned()->index('delivery');
            $table->foreign('delivery_id')
                ->references('id')
                ->on('gift_deliveries')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');
        });
        
        Schema::table('user_gifts',function (Blueprint $table){
            $table->timestamp('deleted_at')->nullable()->index('deleted');
            $table->text('delivery')->nullable();
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
        Schema::dropIfExists('gift_deliveries_language');
        Schema::dropIfExists('gift_deliveries');
        
        Schema::table('project_gifts',function (Blueprint $table){
            $table->dropForeign(['delivery_id']);
            $table->dropColumn('delivery_id');
        });
        
        Schema::table('user_gifts',function (Blueprint $table){
            $table->dropColumn('delivery');
            $table->dropColumn('deleted_at');
        });
    }
}
