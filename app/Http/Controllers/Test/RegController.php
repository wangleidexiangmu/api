<?php

namespace App\Http\Controllers\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\RegModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;

class RegController extends Controller
{
    public function reg(){
        return view('reg');
    }
    public function regest(Request $request){
        $res=$request->input();
        if ($request->isMethod('POST')) {
            $fileCharater = $request->file('phoon');
            if ($fileCharater->isValid()) {
                $ext = $fileCharater->getClientOriginalExtension();
                $path = $fileCharater->getRealPath();
                $filename = date('Y-m-d-h-i-s').'.'.$ext;
                Storage::disk('public')->put($filename, file_get_contents($path));
            }
        }
        $data=[
            'pusername'=>$res['pusername'],
            'username'=>$res['username'],
            'number'=>$res['number'],
            'pubnum'=>$res['pubnum'],
            'phoon'=>$filename,
            'appid'=>md5($res['pusername']),
            'key'=>md5($res['username']),
            'status'=>0,
            'uid'=>Auth::id(),
        ];
       $result=RegModel::insert($data);
       $pass=RegModel::where(['status'=>1])->first();
      // var_dump($result);exit;
       if($result==true){
           $response=[
               'msg'=>"注册成功等待审核",
               'erron'=>50007,

           ];
           header('Refresh: 3; url=http://www.api.com/home');
           return (json_encode($response,JSON_UNESCAPED_UNICODE));


       }else{
           $response=[
               'msg'=>"注册失败",
               'erron'=>50009,
           ];
           die(json_encode($response,JSON_UNESCAPED_UNICODE));
       }

    }
    public function getall(){
        $uid=Auth::id();
        $st=RegModel::where(['uid'=>$uid])->first();
       // var_dump($st);exit;
       $pass=$st->status;
      // var_dump($pass);exit;
       $appid=$st->appid;
       $key=$st->key;
        if($pass==1){
            $response=[
                'msg'=>"审核通过",
                'erron'=>0,
                'APPID'=>$appid,
                'KEY'=>$key,
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $response=[
                'msg'=>"审核未通过",
                'erron'=>50009,
            ];
            header('Refresh: 3; url=http://www.api.com/home');
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }
    public function getToken(){
        $id=0;
        $id='id:'.$id;
        $history = Redis::incr($id);  //次数
        $tim= Redis::expire($id,3600 );
        if($history >100){
            $response=[
                'msg'=>"请求次数超限",
                'erron'=>50001,
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
       // echo $history;exit;
        $appid=$_GET['APPID'];
        //var_dump($appid);exit;
        $key=$_GET['KEY'];
       if( empty($appid)||empty($key)){
           $response=[
               'msg'=>"参数不完整",
               'erron'=>50002,
           ];
           die(json_encode($response ,JSON_UNESCAPED_UNICODE));
       }else{

           $one=RegModel::where(['appid'=>$appid],['key'=>$key])->first();
           //  var_dump($one);exit;
           if($one){
               $uid = Auth::id();
               // var_dump($uid);exit;
               $token=substr(md5($uid.time().Str::random(10)),5,15);
               Redis::set($uid, $token);
               Redis::expire($uid, 7200);
               $response=[
                   'token'=>$token,
                   'msg'=>'ok',
               ];
               die(json_encode($response));
           }else{
               $response=[
                   'msg'=>"请先注册",
                   'erron'=>50002,
               ];
               die(json_encode($response ,JSON_UNESCAPED_UNICODE));
           }
       }




    }
    public function getid(){
        $ip=$_SERVER['REMOTE_ADDR'];
       // var_dump($_SERVER);
        $response=[
            'msg'=>"ok",
            'ip'=>$ip,
        ];
        die(json_encode($response));
    }
    public function getUA(){

        $UA=$_SERVER['HTTP_USER_AGENT'];
        $response=[
            'msg'=>"ok",
            'UA'=>$UA,
        ];
        die(json_encode($response));
    }
    public function getuser(){
        header("Location:http://www.api.com/admin/user");

    }
}
