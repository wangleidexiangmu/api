<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    public function reg(Request $request){
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        $email=$request->input('email');
        $e=UserModel::where(['email'=>$email])->first();
        if($e){
            $response=[
                'errno'=>50004,
                'msg'=>'邮箱已存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        $pass=password_hash($pass2,PASSWORD_BCRYPT);
        if($pass1!=$pass2){
            $response=[
                'errno'=>50002,
                'msg'=>'密码不一致'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $data=[
            'name'=>$request->input('name'),
            'email'=>$email,
            'pass'=>$pass
        ];
        $uid=UserModel::insertGetId($data);
        if($uid){
            $response=[
                'errno'=>0,
                'msg'=>'ok'
            ];
        }else{
            $response=[
                'errno'=>50003,
                'msg'=>'注册失败'
            ];
        }
        die(json_encode($response));
    }
    public function login(Request $request){
       // var_dump(getcookie());
        $email=$request->input('email');
        $pass=$request->input('pass');
        $u=UserModel::where(['email'=>$email])->first();
        if($u){
                if(password_verify($pass,$u->pass)){
                    $token=$this->getlogintoken($u->uid);
                    $redis_token_key='login_token:uid:'.$u->uid;
                    Redis::set($redis_token_key,$token);
                    Redis::expire($redis_token_key,60480);
                    $response=[
                        'errno'=>0,
                        'msg'=>'ok',
                        'data'=>[
                            'token'=>$token
                        ]
                    ];
                    echo (json_encode($response));
                }else{
                    $response=[
                        'errno'=>50007,
                        'msg'=>'登录失败'
                    ];
                    die(json_encode($response,JSON_UNESCAPED_UNICODE));
                }
        }else{
            $response=[
                'errno'=>50004,
                'msg'=>'用户不存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }
    protected function getlogintoken($uid){
        $token=substr(md5($uid.time().Str::random(10)),5,15);
        return $token;
    }
    public function conter(){
        echo 123;
    }
}
