<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsergiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_gifts',function (Blueprint $table){
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('order_id')->nullable()->index('order');
            
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
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
            $table->dropColumn('quantity');
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });
    }
}
