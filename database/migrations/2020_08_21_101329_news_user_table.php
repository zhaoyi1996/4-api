<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('user_id')->comment('主键');
            $table->string('nick_name',30)->comment('用户昵称');
            $table->string('user_name',30)->comment('用户的名字');
            $table->char('phone',11)->comment('手机号');
            $table->string('email',50)->comment('邮箱');
            $table->char('password',32)->comment('密码');
            $table->char('rand_code')->comment('随机码');
            $table->tinyInteger('error_count')->comment('累计错误次数');
            $table->timestamp('last_error_time')->comment('最后一次错误时间');
            $table->unsignedBigInteger('last_login_ip')->comment('登录的ip');
            $table->tinyInteger('status')->comment('状态：1、待审核  2、锁定  3、正常   4、已删除');
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
        Schema::drop('news_user');
    }
}
