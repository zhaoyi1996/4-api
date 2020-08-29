<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Common;
use Illuminate\Http\Request;

class RegisterController extends Common
{
    /**
     * 获取图片验证码路径
     */
    public function getImgCodeUrl(Request $request){
        //开启session
        $request->session()->start();
        //获取sessionID
        $sid=$request->session()->getId();
        $arr['url']='http://api.practice1.com/reg/imageCode?sid='.$sid;
        $arr['sid']=$sid;
        //调用返回
        $this->success($arr);
    }
    /**
     * 图片验证码方法
     */
    public function imageCode(){
        // Set the content-type
        header('Content-Type: image/png');

        // Create the image
        $im = imagecreatetruecolor(100, 30);

        // Create some colors
        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 128, 128, 128);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 399, 29, $white);

        // The text to draw
        $text = ''.rand(1000,9999);
        // Replace path by your own font path
        $font = storage_path('arial.ttf');

        // Add some shadow to the text
        //imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

        // Add the text
        $i=0;
        while($i<strlen($text)){
            imageline($im,rand(0,10),rand(0,50),rand(120,50),rand(0,30),$grey);
            imagettftext($im, 20, rand(-15,15), 11+20*$i, 25, $black, $font, $text[$i]);
            $i++;
        }

        // Using imagepng() results in clearer text compared with imagejpeg()
        imagepng($im);
        imagedestroy($im);

        exit;
    }
}
