<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Common extends Controller
{
    /**
     * 返回数据
     */
    public function success( $data = [], $status = 200, $msg = 'success')
    {
        //返回数据
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ];
    }
}
