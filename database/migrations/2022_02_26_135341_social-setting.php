<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SocialSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social-setting', function (Blueprint $table) {
            $table->id('social_id');
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linked_in')->nullable();
            $table->string('you_tube')->nullable();
            $table->string('google_plus')->nullable();
        });

        DB::table('social-setting')->insert([
            'facebook' => 'facebook.com',
            'twitter' => 'twitter.com',
            'linked_in' => 'linkedin.com',
            'you_tube' => 'youtube.com',
            'google_plus' => '',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social-setting');
    }
}
