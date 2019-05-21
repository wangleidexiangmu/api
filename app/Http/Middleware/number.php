<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
class number
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //var_dump($_SERVER['REQUEST_URI']);exit;
        $key=md5($_SERVER['REQUEST_URI']);
        $history = Redis::incr($key);  //次数
        $tim= Redis::expire($key,60 );
//echo $history;exit;
        if($history >20){
            $response=[
                'msg'=>"请求次数超限",
                'erron'=>50001,
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $uid=Auth::id();
      //  var_dump($uid);exit;
        $token=$_GET['token'];
        $r_token = Redis::get($uid);
        if($token==$r_token){

        }else{
            $response=[
                'msg'=>"token错误",
                'erron'=>50003,
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        return $next($request);
    }
}
