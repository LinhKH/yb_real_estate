<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id("user_id");
            $table->string('username');
            $table->string('user_email');
            $table->text('user_password');
            $table->string('user_phone');
            $table->text('description')->nullable();
            $table->string('user_image')->nullable();
            $table->integer('user_country')->nullable();
            $table->integer('user_state')->nullable();
            $table->integer('user_city')->nullable();
            $table->string('favourites')->nullable();
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('users');
    }
}
