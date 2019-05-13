<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_operations',function (Blueprint $table){
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('code')->nullable()->index('code');
            $table->string('temp_name')->nullable()->index('temp_name');
            $table->timestamps();
        });
        
        Schema::create('balance_status',function (Blueprint $table){
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('code')->nullable()->index('code');
            $table->string('temp_name')->nullable()->index('temp_name');
            $table->timestamps();
        });
        
        Schema::create('balance',function (Blueprint $table){
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->float('summa')->default(0.0)->index('summa');
            
            $table->unsignedInteger('user_id')->nullable()->index('user');
            $table->unsignedInteger('admin_id')->nullable()->index('admin');
            $table->unsignedInteger('currency_id')->nullable()->index('currency');
            $table->unsignedInteger('operation_type_id')->default(1)->nullable()->index('operation_type');
            $table->unsignedInteger('status_id')->nullable()->index('status');
            
            $table->nullableMorphs('purpose','purpose');

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->onUpdate('cascade')
                ->onDelete('set null');
            
            $table->foreign('currency_id')
                ->references('id')
                ->on('currency')
                ->onUpdate('cascade')
                ->onDelete('set null');
            
            $table->foreign('operation_type_id')
                ->references('id')
                ->on('balance_operations')
                ->onUpdate('cascade')
                ->onDelete('set null');
            
            $table->foreign('status_id')
                ->references('id')
                ->on('balance_status')
                ->onUpdate('cascade')
                ->onDelete('set null');
            
        });
        
        
        Schema::create('balance_projects',function (Blueprint $table){
            $table->engine = 'InnoDB';
            
            $table->unsignedInteger('balance_id')->index('balance');
            $table->unsignedInteger('project_id')->index('project');

            $table->timestamps();
            
            $table->primary(['project_id', 'balance_id']);
            
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
        
        Schema::create('balance_transactions',function (Blueprint $table){
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->unsignedInteger('balance_id')->index('balance');
            $table->string('api')->default('Interkassa')->index('api');
            $table->string('code')->nullable()->index('code');
            $table->text('history')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('balance_transactions');
        Schema::dropIfExists('balance_status');
        Schema::dropIfExists('balance_operations');
        Schema::dropIfExists('balance_projects');
        Schema::dropIfExists('balance');
    }
}
