<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->default('')->comment('标签名称');
            $table->string('sort')->default(0)->comment('排序值');
            $table->boolean('hidden')->default(0)->comment('隐藏');

            $table->timestamps();
            $table->softDeletes();

            $table->index('name','name');
            $table->index('sort','sort');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag');
    }
}
