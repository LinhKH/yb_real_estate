<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Property extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->id('ads_id');
            $table->string('property_name');
            $table->string('slug');
            $table->text('description');
            $table->text('user_id');
            $table->string('ads_image');
            $table->string('gallery')->nullable();
            $table->integer('category');
            $table->integer('purpose');
            $table->string('price');
            $table->string('area');
            $table->string('facilities')->nullable();
            $table->string('distances')->nullable();
            $table->integer('country');
            $table->integer('states');
            $table->integer('city');
            $table->integer('bathrooms')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('floors')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->integer('parking')->nullable();
            $table->integer('property_face')->nullable();
            $table->integer('featured')->default('0');
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
        Schema::dropIfExists('property');
    }
}
