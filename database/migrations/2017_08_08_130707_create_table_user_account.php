<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_account',function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('balance')->default(0);
            $table->string('avatar_link')->nullable();
            $table->text('about_self')->nullable();
            $table->string('city_birth')->nullable();
            $table->string('day_birth')->nullable();
            $table->string('lang_local')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('user_site')->nullable();
            $table->string('social_href_facebook')->nullable();
            $table->string('social_href_google')->nullable();
            $table->string('social_href_twitter')->nullable();
            $table->string('social_href_youtube')->nullable();
            $table->string('social_href_instagram')->nullable();
            $table->string('contact_phone')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('user_account');
    }
}
