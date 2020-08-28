<?php

namespace App\Http\Controllers\api;

use App\Exceptions\ApiExceptions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\aliyun_sms\api_demo\SmsDemo;
use App\Http\api\CommonController;
use App\ParamMsg\Error;
use App\Model\User;
class LoginController extends Controller
{

    //执行登录
    public function login(Request $request)
    {

        $phone=$this->checkParamIsEmpty('phone');
        $password=$this->checkParamIsEmpty('password');
        $password=md5($password);
//        dump($password);
//        dump($phone);die;
        $res=User::where('phone',$phone)->first();
        $time=time();
        //根据手机号码查询
        if($res){
            if($res['password']!=$password){
                throw new ApiExceptions('账号密码错误');
            //判断该用户状态是否可以登录
            if($res['err_num']>=5 && $time - $res['err_time'] < 3600){
                $err_info=date('H:i:s',$res -> err_time + 3600);
                //dd($err_info);
                $err=[
                    'status'=>100,
                    'msg'=>"账号已被锁定,请与".$err_info."时分以后登录",
                ];
                return $err;
            }



            if($res['password']!=$password){
                
                //判断该用户上一次错误时间距离现在时间是否超过1小时  超过一小时则更新错误时间 未超过则添加错误次数
                if(($time-$res['err_time'])>3600){
                    $err_info=[
                        'err_time'=>$time,
                        'err_num'=>1
                    ];
                    $res=User::where('uid',$res['uid'])->update($err_info);
                    $err=[
                        'status'=>100,
                        'msg'=>"账号密码错误,还剩余4次输入密码机会,超过5次锁定60分钟",
                    ];
                    return $err;
                }else{
                    $err_info=[
                      'err_time'=>$time,
                      'err_num'=>$res['err_num']+1
                    ];
                    $res=User::where('uid',$res['uid'])->update($err_info);
                    $now=5-$err_info['err_num'];
                    $err=[
                        'status'=>100,
                        'msg'=>"账号密码错误,还剩余".$now."次输入密码机会,超过5次锁定60分钟",
                    ];
                    return $err;

                }
            }else{
                //密码正确 返回200状态码,将用户id和token存入session
                $token=md5($time);
                $success=[
                    'status'=>200,
                    'msg'=>"登陆成功",
                    "uid"=>$res['uid'],
                    "token"=>$token
                ];
                //错误时间和错误次数改为null,更新用户token
                $err_info=[
                  'err_num'=>0,
                  'err_time'=>null,
                  'token'=>$token
                ];
                $upd_token=User::where('uid',$res['uid'])->update($err_info);
                //将用户ID和TOKEN存入session
                $userInfo=[
                    "uid"=>$res['uid'],
                    "token"=>$token
                ];
                session(['userInfo'=>$userInfo]);
                return $success;
            }
        //未查询到给出提示
        }else{
            throw new ApiExceptions('账号密码错误');
        }
    }
    protected function checkParamIsEmpty( $key )
    {

        # 接受客户端传递的参数
        $request_data = request() -> all();

        # 判断是否传递参数
        if( empty( $request_data[$key] ) ){

            # 给出对应的提示
            return $this -> fail( $this -> getErrorMsg( $key ), 1000 );

        }else{

            # 没有问题的时候，返回对应的值
            return $request_data[$key];
        }

    }
    /**
     * 获取对应的错误提示信息
     */
    public function getErrorMsg( $key )
    {
        $error_all = Error::MSG;

        if( isset( $error_all[$key]) ){
            $error_msg = $error_all[$key];
        }else{
            $error_msg = '出现错误了';
        }
        return $error_msg;
    }

    protected function  fail( $msg = 'fail' , $status = 1 , $data = [] )
    {
        $arr =  $this -> jsonOutPut( $status , $msg , $data );

//        return response( $arr );
//        return response($arr);
        echo json_encode($arr ,  JSON_UNESCAPED_UNICODE );
        exit;
    }

    private function jsonOutPut( $status , $msg , $data )
    {

        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ];
    }
}
