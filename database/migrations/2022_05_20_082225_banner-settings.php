<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class BannerSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title'); 
            $table->string('image'); 
        });

        DB::table('banner_settings')->insert([
            'title' => 'Discover best properties in one place',
            'sub_title' => 'Welcome to YB Real Estate',
            'image' => '1605008917nicholas-vassios-tRWrdGZrnuU-unsplash.jpg',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_settings');
    }
}
