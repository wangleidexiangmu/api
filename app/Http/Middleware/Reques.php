<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;
use Closure;

class Reques
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
       // print_r($_SERVER);
        $key='reques:ip'.$_SERVER['REMOTE_ADDR'].':token:'.$request->input('token');
        $num=Redis::get($key);
        if($num>10){
            $response=[
                'errno'=>400009,
                'msg'=>'请求次数超限'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));

        }
        Redis::incr($key);
        Redis::expire($key,30);
       // echo date('Y-m-d H:i:s');echo '<br>';
       // echo $num;echo '</br>';
        return $next($request);
    }

}
