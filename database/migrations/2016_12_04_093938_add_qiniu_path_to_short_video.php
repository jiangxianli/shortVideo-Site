<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQiniuPathToShortVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('short_video', function (Blueprint $table) {
            $table->string('qiniu_key')->default('')->comment('七牛Key');
            $table->string('qiniu_hash')->default('')->comment('七牛Hash');
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
            $table->dropColumn('qiniu_key');
            $table->dropColumn('qiniu_hash');
        });
    }
}
