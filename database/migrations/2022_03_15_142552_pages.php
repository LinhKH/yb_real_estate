<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Pages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id('page_id');
            $table->string('page_title');
            $table->string('slug');
            $table->longText('description'); //LONGTEXT equivalent to the table
            $table->tinyInteger('status')->default('1'); //Declare a default value for a column
            $table->integer('show_in_header')->nullable(); //Declare a default value for a column
            $table->integer('show_in_footer')->nullable(); //Declare a default value for a column
            $table->timestamps();
        });

        DB::table('pages')->insert([
            'page_title' => 'About',
            'slug' => 'about',
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo',
            'status' => '1',
            'show_in_header' => '1',
            'show_in_footer' => '1',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
