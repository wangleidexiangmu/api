<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function user(Request $request){
        $uid=$request->input('id');
        $data=[];
        $user_info=[
            'name'=>'zhangsan',
            'email'=>'123456'

        ];
        $data=[
            'error'=>'0',
            'msg'=>'ok',
            'user_info'=>$user_info
        ];
        echo json_encode($data);
    }
    public function test(){
        $url ='http://www.apitest.com/user?id=4';
        //创建一个新curl
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        $res=curl_exec($ch);
        $code=curl_errno($ch);
        var_dump($code);
        curl_close($ch);
        echo $res;
    }
    public function testform(){
        $url ="http://www.apitest.com/userinfo";
        $post_arr = [
            'nick_name' => 'lisi',
            'email'     => 'lisi@qq.com'
        ];
        //创建一个新curl
       // var_dump($post_arr);die;
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_arr);

        $res=curl_exec($ch);
        $code=curl_errno($ch);
        var_dump($code);
        curl_close($ch);

    }
    public function testapp(){
        $url ='http://www.apitest.com/test';
        $post_str = "nickname=zhangsan&email=zhangsan@qq.com";
        //创建一个新curl
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_str);
        $res=curl_exec($ch);
        $code=curl_errno($ch);
        var_dump($code);
        curl_close($ch);
    }
    public function testraw(){
        $url ='http://www.apitest.com/testw';
        //创建一个新curl
        $ch=curl_init();
        $post_json = json_encode($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_json);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        $res=curl_exec($ch);
        $code=curl_errno($ch);
        var_dump($code);
        curl_close($ch);
    }
}
