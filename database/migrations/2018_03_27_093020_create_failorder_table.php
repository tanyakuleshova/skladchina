<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordersfail', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('user_id')->nullable()->index('user');

            $table->unsignedInteger('project_id')->index('project');
            $table->unsignedInteger('project_gift_id')->nullable()->index('gift');
            
            $table->unsignedInteger('quantity')->nullable()->index('quantity');
            
            $table->float('summa')->default(0.0)->index('summa');
            
            $table->unsignedInteger('balance_id')->nullable()->index('balance');
            
            $table->text('userfields')->nullable();
            $table->text('history')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
            
            $table->index(['user_id','quantity','summa','balance_id'],'fast_s_1');
            
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('set null');

            $table->foreign('project_id')
                    ->references('id')
                    ->on('project')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->foreign('project_gift_id')
                    ->references('id')
                    ->on('project_gifts')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            
            $table->foreign('balance_id')
                    ->references('id')
                    ->on('balance')
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
        Schema::dropIfExists('ordersfail');
    }
}
