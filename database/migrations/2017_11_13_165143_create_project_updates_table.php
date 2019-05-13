<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id')->nullable()->index('project');
            $table->unsignedInteger('project_gift_id')->nullable()->index('gift');
            $table->unsignedInteger('user_id')->nullable()->index('user');
            $table->unsignedInteger('admin_id')->nullable()->index('admin');
            $table->unsignedInteger('status_id')->nullable()->index('status');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->string('up_image')->nullable();
            $table->string('up_shot_text',300)->nullable();
            $table->text('up_text')->nullable();
            $table->text('admin_text')->nullable();
            
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
            
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
            
            $table->foreign('status_id')
                    ->references('id')
                    ->on('balance_status')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
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
        Schema::dropIfExists('project_updates');
    }
}
