<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('facebooks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default(1);
            // references signed id from user
            $table->unsignedInteger('uid');
            $table->foreign('uid')->references('id')->on('users')->onDelete('cascade');
            $table->text('title');
            $table->longText('appId');
            $table->longText('appSecret');
            $table->longText('pageId')->nullable();
            $table->longText('userAccessToken')->nullable();
            $table->longText('foreverPageAccessToken')->nullable();
            $table->longText('tags')->default('N/A');
            $table->longText('categories')->default('N/A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('facebooks');
    }
}
