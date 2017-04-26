<?php

namespace App\Http\Middleware;

use Closure;
use App\Util\UserUtil;

class BackendAuth
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
        $href = '/'.$request->path();
        $matchResult = false;
        $sysMenus = UserUtil::getUserSysMenu($request);

        if($href!='/backend'){
            //以?分割取前面一个字符串需要完全匹配数据库字符串为符合要求的字符串
            $hrefArr = explode("?", $href);
            foreach ($sysMenus as $sysMenu){
                if($sysMenu->href!='' && $hrefArr[0]==$sysMenu->href){
                    $matchResult = true;
                    break;
                }
            }
        }else{
            return $next($request);
        }

        if($matchResult){
            return $next($request);
        }else{
            return '非常抱歉！您的权限不够，不能访问改模块！';
        }

    }
}
