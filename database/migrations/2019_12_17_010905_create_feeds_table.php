<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('author')->nullable();
            $table->integer('uid')->nullable();
            $table->text('title');
            $table->text('path');
            $table->text('guid');
            $table->longText('body')->nullable();
            $table->text('channel')->nullable();
            $table->longText('enclosure')->nullable();
            $table->text('source')->nullable();
            $table->integer('source_id')->nullable();
            $table->text('image')->default('img/blogImage.jpg');
            $table->longText('tags')->default('N/A');
            $table->longText('categories')->default('N/A');
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
        Schema::dropIfExists('feeds');
    }
}
