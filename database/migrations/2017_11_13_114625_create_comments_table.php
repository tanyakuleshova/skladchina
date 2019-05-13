<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('status')->default(1)->index(); 
            
            $table->integer('project_id')->nullable()->unsigned()->index();		
            $table->integer('user_id')->nullable()->unsigned()->index();
            $table->integer('parent_id')->nullable()->unsigned()->index();

            $table->timestamps();
            $table->softDeletes();
            
            $table->text('text')->nullable();
            
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
            
            $table->foreign('project_id')
                    ->references('id')
                    ->on('project')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('comments');
    }
}
