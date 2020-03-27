<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('weight')->default(0);
            $table->string('name');
            $table->string('menu')->default('mainmenu');
            $table->integer('menuparent')->nullable();
            $table->text('description')->nullable();
            $table->string('link');
            $table->string('class')->nullable();
            $table->string('iconclass')->nullable();
            $table->string('adminlevel')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
