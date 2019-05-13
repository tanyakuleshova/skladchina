<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDeclarationRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_declaration_refund', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->index('user');
            $table->unsignedInteger('admin_id')->nullable()->index('admin');
            
            $table->unsignedInteger('currency_id')->nullable()->default(1)->index('currency');
            $table->float('summa')->default(0.0)->index('summa');
            
            $table->unsignedInteger('balance_id')->nullable()->index('balance');

            $table->unsignedInteger('status_id')->nullable()->index('status');
            $table->unsignedInteger('user_pay_methods_id')->nullable()->index('user_pay_methods');
            
            $table->string('user_declaration_image')->nullable();

            $table->timestamps();

            $table->text('declaration_text')->nullable();
            $table->text('admin_text')->nullable();
            
            $table->index('created_at');
            $table->index('updated_at');
            
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
            
            $table->foreign('balance_id')
                ->references('id')
                ->on('balance')
                ->onUpdate('cascade')
                ->onDelete('set null');
            
            $table->foreign('status_id')
                ->references('id')
                ->on('balance_status')
                ->onUpdate('cascade')
                ->onDelete('set null');
            
            $table->foreign('user_pay_methods_id')
                ->references('id')
                ->on('user_pay_methods')
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
        Schema::dropIfExists('user_declaration_refund');
    }
}
