<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nick_name')->default('')->comment('用户昵称');
            $table->string('image_url')->default('')->comment('头像地址');
            $table->string('duo_shuo_id')->default('')->comment('多说ID');
            $table->mediumText('duo_shuo_info')->comment('多说信息');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index('nick_name', 'nick_name');
            $table->index('duo_shuo_id', 'duo_shuo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
