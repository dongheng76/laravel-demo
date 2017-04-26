<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SysMenuRepositoryEloquent;
use Auth;
use App\Services\SysMenuService;
use App\Util\UserUtil;

class HomeController extends Controller
{
    protected $sysMenu;


    public function __construct(SysMenuRepositoryEloquent $sysMenu)
    {
        $this->sysMenu = $sysMenu;
    }

    public function index(SysMenuService $sysMenuService, Request $request)
    {
        $user = Auth::user();
        //return view('backend.home', compact('user'));


        $request->parent_id = "1";
        $where = SysMenuService::backendSearchWhere($request);
        $sysMenus = $this->sysMenu->backendSearchSysMenu($where);

        //$request->session()->set('sysMenus',$sysMenus);
        //$request->session()->put('currentParentIds','0,1,27,28,');
        return view('backend.home',compact('sysMenus','user'));
    }

    //查询子菜单信息
    public function querymenubypid(Request $request)
    {
        $sysMenus = UserUtil::queryChildrenByPId($request,$request->parent_id);
        return $sysMenus;
    }
}
