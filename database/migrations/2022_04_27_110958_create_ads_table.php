<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id('ads_id');
            $table->string('property_name');
            $table->string('slug');
            $table->text('description');
            $table->text('user_id');
            $table->string('ads_image')->nullable();
            $table->integer('category');
            $table->integer('purpose');
            $table->string('price');
            $table->string('area');
            $table->string('facilitiwes');
            $table->string('distances');
            $table->integer('country');
            $table->integer('states');
            $table->integer('city');
            $table->integer('bathrooms');
            $table->integer('bedrooms');
            $table->text('floors');
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('ads');
    }
}
