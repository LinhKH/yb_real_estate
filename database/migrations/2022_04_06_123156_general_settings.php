<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class GeneralSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('com_name');
            $table->string('com_logo'); 
            $table->string('com_email'); 
            $table->string('com_phone');
            $table->string('address');
            $table->text('description');
            $table->string('copyright_text');
            $table->string('cur_format',20); 
            $table->string('latitude'); 
            $table->string('longitude'); 
            $table->timestamps();
        });

        DB::table('general_settings')->insert([
            'com_name' => 'YB Real Estate',
            'com_logo' => '1785851104logo.png',
            'com_email' => 'company@email.com',
            'com_phone' => '0987654321',
            'address' => '1966 Glenview Drive, Victoria, Texas, United States',
            'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.',
            'copyright_text' => 'Copyright © 2021-2022',
            'cur_format' => '$',
            'latitude' => '25.197600498235378',
            'longitude' => '55.27535141617953',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}
