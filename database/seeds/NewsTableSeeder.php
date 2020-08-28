<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<20;$i++){
            $model=new \App\models\NewsModel();
            $model->news_title='大连万达集团的官网上曾在2015年7月9日发表过一篇关于洛杉矶比弗利山项目的报道。';
            $model->news_content='大连万达集团的官网上曾在2015年7月9日发表过一篇关于洛杉矶比弗利山项目的报道';
            $model->allow_comment=1;
            $model->cate_id=2;
            $model->comment_count=111;
            $model->browse_count=200;
            $model->click_count=311;
            $model->publish_time=1597837388;
            $model->status=3;
            $model->ctime=1597837582;
            $model->utime=1597837582;
            $model->news_image='/news/2020/0820/小特.jpg';
            $model->save();
        }

    }
}
