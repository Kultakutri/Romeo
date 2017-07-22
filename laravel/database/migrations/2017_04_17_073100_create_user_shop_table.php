<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_shops', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('shop_id')->unsigned();
            $table->integer('shop_id')->reference('id')->on('shops');
            //$table->integer('user_id')->unsigned();
            $table->integer('user_id')->reference('id')->on('users');
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
        Schema::drop('user_shops');
    }
}
