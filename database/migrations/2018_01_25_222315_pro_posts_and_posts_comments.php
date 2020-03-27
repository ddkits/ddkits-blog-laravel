<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProPostsAndPostsComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasColumn('comments', 'type')){
            return;
            }else{
                Schema::table('comments', function (Blueprint $table)
                {
                    $table->text('type');
                    $table->text('tags')->nullable();
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
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['type']);
            $table->dropColumn(['tags']);
        });
    }
}
