<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_video', function (Blueprint $table) {
            $table->increments('id');

            $table->string('url')->default('')->comment('视频地址');
            $table->string('poster')->default('')->comment('封面图');

            $table->string('title')->default('')->comment('标题');
            $table->string('platform_id')->default('')->comment('平台ID');
            $table->string('platform_type')->default('')->comemnt('平台来源');
            $table->integer('click_count')->default(0)->comment('点击量');
            $table->tinyInteger('status')->default(1)->comment('审核状态');

            $table->timestamps();
            $table->softDeletes();

            $table->index('click_count');
            $table->index('platform_id','platform_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_video');
    }
}
