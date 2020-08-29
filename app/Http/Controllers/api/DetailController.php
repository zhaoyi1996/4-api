<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\CommonController;
use App\models\NewsModel;
use Illuminate\Http\Request;

class DetailController extends CommonController
{
    /**
     * 新闻详情页
     */
    public function detail(){
        $news_id=request()->post('news_id');
        //根据新闻id查询新闻信息
        $where=[
            ['news_id','=',$news_id]
        ];
        $news_list=NewsModel::where($where)->leftJoin('news_cate','news_news.cate_id','=','news_cate.cate_id')->first();
        $news_list=collect($news_list)->toArray();

        return $this->success($news_list);
    }
}
