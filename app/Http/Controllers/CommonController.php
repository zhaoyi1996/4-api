<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CommonController extends Controller
{
    /**
     * 获取缓存的版本号
     */
    public function getCacheVersion($cache_type='news')
    {
        switch($cache_type)
        {
            case 'news':
                $cache_version_key= 'news_cache_version';
                $version = Redis::get($cache_version_key);
                break;
            default:
                break;
        }
        if(empty($version)){
            Redis::set($cache_version_key,1);
            $version=1;
        }
        return $version;
    }
    //返回json数据
    public function success($data=[],$status="200",$msg='success'){
        $success =  [
            'status'=>$status,
            'msg'=>$msg,
            'data'=>$data
        ];
        return json_encode($success);
    }

}
