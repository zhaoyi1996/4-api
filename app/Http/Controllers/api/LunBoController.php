<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LunBoController extends Controller
{
    public function lunbo(){
        $news_lunbo=[
                        [
                            'n_id'=>1,
                            'n_title'=>"新闻标题",
                            'n_img'=>""
                        ],
                        [
                            'n_id'=>2,
                            'n_title'=>"南非",
                            "n_img"=>""
                        ],
                        [
                            'n_id'=>3,
                            'n_title'=>"666",
                            "n_img"=>""
                        ]
        ];
        return $news_lunbo;
    }
}
