<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->nullable();
            $table->longText('body');
            $table->integer('public')->default(1);
            $table->integer('new')->default(1);
            $table->string('image')->default('img/proPostImage.png');
            $table->string('tags')->default('N/A');
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
        Schema::dropIfExists('pro_posts');
    }
}
