<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlug extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasColumn('posts', 'path')){
            return;
            }else{
                Schema::table('posts', function (Blueprint $table)
                {
                    $table->text('path')->nullable();
                });
            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['path']);
        });
    }
}
