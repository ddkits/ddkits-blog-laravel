<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReplyMsgTo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('msgs', 'reply')){
            return;
            }else{
                Schema::table('msgs', function (Blueprint $table)
                {
                    $table->integer('reply')->nullable();
                    $table->integer('original')->nullable();
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
         Schema::table('msgs', function (Blueprint $table) {
            $table->dropColumn(['reply']);
            $table->dropColumn(['original']);
        });
    }
}
