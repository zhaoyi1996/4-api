<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\CommonController;
use App\models\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class NewsController extends CommonController
{
    /**
     * 新闻首页展示
     */
    public function index( Request $request ){
        //接收传递的数据
        $page=$request->get('page')??'1';
        $pageSize=$request->get('pagesize')??'10';
        //拼接要存入Redis的key
        $page_key='index_list'.$page;
        $page_key.='_'.$this->getCacheVersion('news');
        //查询缓存中是否存在数据
        $id_list=Redis::get($page_key);
        if(!empty($id_list)){
            $id_arr=unserialize($id_list);
            $list=$this->getListCache($id_arr);
            return $this->success($list);
        }
        //设置查询的条件
        $where=[
            ['status','=',3]
        ];
        //设置排序状态
        $order_field='publish_time';
        $order_type='desc';
        $new_list_obj=NewsModel::leftJoin('news_cate','news_news.cate_id','=','news_cate.cate_id')->where($where)
            ->orderBy($order_field,$order_type)
            ->paginate($pageSize);
        if(!empty($new_list_obj)){
            foreach($new_list_obj as $k=>$v){
                $v->news_image=env('IMG_URL').$v->news_image;
            }
        }
        $news_list=collect($new_list_obj) -> toArray();
        //根据列表的数据生成 原子的缓存   按照详情数据缓存
        if( !empty($news_list)){
            $this->buildNewsDetailCache($news_list['data']);
        }
        //把查询出来的数据生成缓存，写入redis
        $this->buildNewsListCache($page_key,$news_list['data']);
        return $this->success($news_list['data']);
    }

    public function buildNewsListCache( $page_key ,$news_list ){
        $id_arr=array_column( $news_list , 'news_id' );
        if( Redis::set( $page_key , serialize( $id_arr ) )){
            Redis::expire( $page_key , 60 * 5 );
            return true;
        }else{
            return false;
        }
    }
    /**
     * 根据列表的数据   生成详情的缓存
     */
    public function buildNewsDetailCache( $news_list )
    {
        foreach( $news_list as $k=>$v ){
            $detail_key='news_detail_'.$v['news_id'];
            Redis::hMset($detail_key,$v);
            Redis::expire($detail_key, 60*5);
        }
        return true;
    }
    public function getListCache( $id_arr ){
        $all=[];
        foreach($id_arr as $v){
            $detail_key='news_detail_'.$v;
            $detail=Redis::hGetAll($detail_key);
            if(empty($detail)){
                $detail_obj=NewsModel::leftJoin('news_cate','news_news.cate_id','=','news_cate.cate_id')->find($v);
                $detail->cate_name=$detail_obj ->getCate ->cate_name;
                $detail=collect($detail_obj)->toArray();
                Redis::hMset($detail_key,$detail);
                $all[]=$detail;
            }else{
                $all[]=$detail;
            }
        }
        return $all;
    }

    //新闻详情页面收藏
    public function  news_details(){
        $arr=[
            'news_id'=>2,
            'news_title'=>"统一阿萨姆 原味奶茶",
            'news_info'=>"精选喜马拉雅山红茶，奶茶饮料，净含量：500毫升"
        ];
        return $arr;
    }
}
