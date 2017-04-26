<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 11:07
 */



namespace App\Util;

use Auth;
use App\Util\CacheUtils;
use Illuminate\Http\Request;
use DB;

class UserUtil
{
    public static $SYS_MENU_NAME = 'sysmenu';
    public static $SYS_PARENT_MENU_NAME = 'sysmenuparent';

    //取得用户菜单信息
    public static function getUserSysMenu(Request $request){
        //取得session里的用户信息
        $user = Auth::user();
        //首先取得该用户的菜单信息redis缓存
        $my_menu = CacheUtils::get(self::$SYS_MENU_NAME.$user->id);
        $sys_menus_parents = CacheUtils::get(self::$SYS_PARENT_MENU_NAME.$user->id);

        if($my_menu==null){
            //查询用户
            $sysMenus = DB::select("
                SELECT
                 DISTINCT	sm.id,sm.parent_id,sm.parent_ids,sm.name,sm.sort,sm.href,sm.target,sm.icon,sm.is_show,sm.permission,sm.create_by
                FROM
                    sys_user_role sur
                LEFT JOIN sys_role_menu srm ON sur.role_id = srm.role_id
                left join sys_menu sm on srm.menu_id=sm.id
                where sur.user_id = '".$user->id."'
                and sm.del_flag ='0'
                order by sm.sort asc
            ");

            CacheUtils::putCache(self::$SYS_MENU_NAME.$user->id,$sysMenus);
            $my_menu = $sysMenus;
        }

        if($sys_menus_parents==null){
            $sysMenusParents = DB::select("
                SELECT
                 DISTINCT	sm.id,sm.parent_id,sm.parent_ids,sm.name,sm.sort,sm.href,sm.target,sm.icon,sm.is_show,sm.permission,sm.create_by
                FROM
                    sys_user_role sur
                LEFT JOIN sys_role_menu srm ON sur.role_id = srm.role_id
                left join sys_menu sm on srm.menu_id=sm.id
                where sur.user_id = '".$user->id."'
                and sm.del_flag ='0'
                and sm.parent_id = '1'
                order by sm.sort asc
            ");

            CacheUtils::putCache(self::$SYS_PARENT_MENU_NAME.$user->id,$sysMenusParents);
            $sys_menus_parents = $sysMenusParents;
        }

        //每次重新请求数据库就要重新设置session
        $request->session()->set('sysMenus',$sys_menus_parents);
        return $my_menu;
    }

    //根据PID查询PID下的菜单信息
    public static function queryChildrenByPId(Request $request,$pId){
        $sysMenus = [];
        $myMenus = self::getUserSysMenu($request);
        if($myMenus!=null){
            $i = 0;
            foreach ($myMenus as $key => $menu){
                if($menu->parent_id == $pId){
                    $sysMenus[$i] = $menu;
                    //不仅如此我们还为你找寻一次孩子
                    $sysMenus[$i]->children = [] ;
                    foreach($myMenus as $cmenu){
                        if($cmenu->parent_id == $sysMenus[$i]->id){
                            $sysMenus[$i]->children[] = $cmenu;
                        }
                    }
                    $i++;
                }
            }
        }

        return $sysMenus;
    }
}