<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SysMenuRepositoryEloquent;
use App\Http\Requests\Backend\Menu\CreateRequest;
use Auth;
use App\Services\SysMenuService;
use DB;

class MenuController extends Controller
{
    protected $sysMenu;


    public function __construct(SysMenuRepositoryEloquent $sysMenu)
    {
        $this->sysMenu = $sysMenu;
    }

    public function index(SysMenuService $sysMenuService, Request $request)
    {
        $request->parent_id = "1";
        $where = SysMenuService::backendSearchWhere($request);
        $sysMenus = $this->sysMenu->backendSearchSysMenu($where);

        return view('backend.menu.index',compact('sysMenus'));
    }

    public function create(Request $request)
    {
        $request->parent_id = "1";
        $where = SysMenuService::backendSearchWhere($request);
        $sysMenus = $this->sysMenu->backendSearchSysMenu($where);

        if($request->get('parent_id')){
            $parentId = $request->get('parent_id');

            //计算当前排序号
            $where = [] ;
            $where[] = ['parent_id','=',$parentId];
            $parentIdSysMenus = $this->sysMenu->backendSearchSysMenuNoRecursion($where);
            if(count($parentIdSysMenus)>0)
                $sort = (int)$parentIdSysMenus[count($parentIdSysMenus)-1]->sort+10;
            else
                $sort = 10;

            return view('backend.menu.create',compact('sysMenus','parentId','sort'));
        }else{

            return view('backend.menu.create',compact('sysMenus'));
        }
    }

    //编辑菜单信息
    public function edit(Request $request){
        $id = $request->get('id');
        $request->parent_id = "1";
        $where = SysMenuService::backendSearchWhere($request);
        $sysMenus = $this->sysMenu->backendSearchSysMenu($where);

        $menu = $this->sysMenu->find($id);
        return view('backend.menu.create',compact('menu','sysMenus'));
    }

    /**
     * @param CreateRequest $request
     * @return $this
     */
    public function store(CreateRequest $request)
    {
        $this->sysMenu->store($request->all());

        return ['result'=>true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        $sysMenu = $this->sysMenu->find($id);
        if ($sysMenu) {
            $inp['del_flag'] = 1;

            if($this->sysMenu->update($inp,$id)){
                //除此之外还需要关联的删除
                $parent_ids = $sysMenu['parent_ids'].$sysMenu['id'].',';
                $relativeInp['del_flag'] = '1';

                $condition[] = ['parent_ids','like','%'.$parent_ids.'%'];
                DB::table('sys_menu')->where('parent_ids','like','%'.$parent_ids.'%')->update($relativeInp);

                return ['result'=>true];
            }else{
                return ['result'=>false];
            }
        }
        return ['result'=>false];
    }
}
