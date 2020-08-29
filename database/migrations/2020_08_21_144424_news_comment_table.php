<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_comment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('c_id')->comment('主键');
            $table->string('c_content',255)->comment('评论内容');
            $table->integer('c_time')->comment('评论时间');
            $table->integer('uid')->comment('用户ID');
            $table->integer('n_id')->comment('评论的新闻ID');
            $table->tinyInteger('c_del')->comment('1、未删除  2、已删除')->default(1);
            $table->unsignedInteger('ctime')->comment('创建时间');
            $table->unsignedInteger('utime')->comment('修改时间');
            $table->string('head_img')->comment('用户的头像字段');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('news_comment');
    }
}
