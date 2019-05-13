<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProjectRequisites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_requisites',function (Blueprint $table){
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->enum('tepy_proj',['FOP','individual','entity'])->default('FOP');
            $table->string('FIO')->nullable();
            $table->string('	date_birth')->nullable();
            $table->string('	country_register')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('	inn_or_rdpo')->nullable();
            $table->string('	series_and_number_pasport')->nullable();
            $table->string('	issued_by_passport')->nullable();
            $table->string('	date_issued')->nullable();
            $table->string('	code_bank')->nullable();
            $table->string('	сhecking_account')->nullable();
            $table->string('	position')->nullable();
            $table->string('name_organ')->nullable();
            $table->string('	legal_address')->nullable();
            $table->string('	physical_address')->nullable();
            $table->text('other')->nullable();
            $table->foreign('project_id')
                ->references('id')
                ->on('project')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('project_requisities_gallary',function (Blueprint $table){
            $table->increments('id');
            $table->integer('requisites_id')->unsigned()->index();
            $table->string('	link_scan');
            $table->foreign('requisites_id')
                ->references('id')
                ->on('project_requisites')
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
       Schema::dropIfExists('project_requisites');
       Schema::dropIfExists('project_requisities_gallary');
    }
}
