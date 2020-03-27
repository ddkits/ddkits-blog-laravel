<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostShared extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasColumn('pro_posts', 'shared')){
            return;
            }else{
                Schema::table('pro_posts', function (Blueprint $table)
                {
                    $table->text('shared')->nullable();
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
        Schema::table('pro_posts', function (Blueprint $table) {
            $table->dropColumn(['shared']);
        });
    }
}
