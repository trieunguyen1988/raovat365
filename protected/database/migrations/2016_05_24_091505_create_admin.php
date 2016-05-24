<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function($table){
            $table->increments('admin_id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('fullname');
            $table->string('role_id')->default('0');
            $table->dateTime('last_login_time')->default('0000-00-00 00:00:00');
            $table->dateTime('create_date')->default('0000-00-00 00:00:00');
            $table->dateTime('update_date')->default('0000-00-00 00:00:00');
            $table->tinyInteger('status')->default('0');
            $table->tinyInteger('delete_flg')->default('0');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin');
    }
}
