<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortVideoTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_video_tag', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tag_id')->default(0)->comment('标签ID');
            $table->integer('short_video_id')->default(0)->comment('视频ID');

            $table->timestamps();
            $table->softDeletes();

            $table->index('tag_id', 'tag_id');
            $table->index('short_video_id', 'short_video_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_video_tag');
    }
}
