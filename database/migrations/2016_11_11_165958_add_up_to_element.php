<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpToElement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('short_video', function (Blueprint $table) {
            $table->integer('up')->default(0)->comment('点赞数');
            $table->integer('down')->default(0)->comment('讨厌数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('short_video', function (Blueprint $table) {
            $table->dropColumn('up');
            $table->dropColumn('down');
        });
    }
}
