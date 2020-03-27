<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingBlockToUsers extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasColumn('users', 'blocked')){
            return;
            }else{
                Schema::table('users', function (Blueprint $table)
                {
                    $table->integer('blocked')->default(0);
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['blocked']);
        });
    }
}
