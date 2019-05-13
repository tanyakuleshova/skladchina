<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_account',function (Blueprint $table){
            $table->increments('id');
            $table->integer('admin_id')->unsigned()->index();
            
            $table->integer('status_id')->unsigned()->default(1)->index();
            
            $table->string('last_name')->nullable();
            
            $table->string('avatar_link')->nullable();
            $table->string('about_self')->nullable();
            $table->string('city_birth')->nullable();
            $table->string('day_birth')->nullable();
            $table->string('contact_phone')->nullable();
            
            $table->string('social_href_facebook')->nullable();
            $table->string('social_href_google')->nullable();
            $table->string('social_href_twitter')->nullable();
            $table->string('social_href_youtube')->nullable();
            $table->string('social_href_instagram')->nullable();
            
            $table->timestamps();

            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
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
        Schema::dropIfExists('admin_account');
    }
}
