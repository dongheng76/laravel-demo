<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepositoryEloquent;
use App\Repositories\OfficeRepositoryEloquent;
use App\Repositories\SysMenuRepositoryEloquent;
use App\Repositories\SysRoleMenuRepositoryEloquent;
use App\Http\Requests\Backend\Role\CreateRequest;

class RoleController extends Controller
{
    protected $role;
    protected $office;
    protected $sysmenu;
    protected $sysrolemenu;

    public function __construct(RoleRepositoryEloquent $role,OfficeRepositoryEloquent $office,SysMenuRepositoryEloquent $sysmenu,SysRoleMenuRepositoryEloquent $rolemenu)
    {
        $this->role = $role;
        $this->office = $office;
        $this->sysmenu = $sysmenu;
        $this->rolemenu = $rolemenu;
    }

    //查询角色列表页
    public function index(Request $request)
    {
        $where = [];
        $where[] = ['del_flag','=','0'];

        if ($request->name != "") {
            $where[] = ['name', '=', $request->name];
        }

        $roles = $this->role->backendSearchRole($where);

        return view('backend.role.index',compact('roles'));
    }

    public function create(Request $request)
    {
        //查询所有可选的部门
        $where1 = [];
        $where1[] = ['del_flag','=','0'];
        $where1[] = ['parent_id','=','0'];
        $where1[] = ['type','<=','2'];
        $offices = $this->office->backendSearchSysOffice($where1);
        //非查询所有能够选择的菜单
        $where2 = [];
        $where2[] = ['del_flag','=','0'];
        $sysmenus = $this->sysmenu->backendSearchSysMenuNoRecursion($where2);

        return view('backend.role.create',compact('offices','sysmenus'));
    }

    //保存角色信息
    public function store(CreateRequest $request){
        $id = $this->role->store($request->all());
        if($id){
            //插入之前先删除以前的角色菜单信息
            $roleMenuWhere = [];
            $roleMenuWhere[] = ['role_id','=',$id];
            $this->rolemenu->deleteWhere($roleMenuWhere);
            //保存好角色信息后保存角色菜单信息
            //取得菜单集合信息
            $menuIds = explode(',',$request->get('menuIds'));
            $roleMenus = [];
            foreach ($menuIds as $menuId){
                $roleMenus[] = ['role_id'=>$id,'menu_id'=>$menuId];
            }
            if ($this->rolemenu->batchStore($roleMenus)){
                return ['result'=>true];
            }else{
                return ['result'=>false];
            }
        }
    }

    //编辑角色信息
    public function edit(Request $request){
        $id = $request->get('id');
        //查询所有可选的部门
        $where1 = [];
        $where1[] = ['del_flag','=','0'];
        $where1[] = ['parent_id','=','0'];
        $where1[] = ['type','<=','2'];
        $offices = $this->office->backendSearchSysOffice($where1);
        //非查询所有能够选择的菜单
        $where2 = [];
        $where2[] = ['del_flag','=','0'];
        $sysmenus = $this->sysmenu->backendSearchSysMenuNoRecursionMy($id);

        $role = $this->role->find($id);
        return view('backend.role.create',compact('role','offices','sysmenus'));
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
        //判断是否是多用户删除
        $ids = explode('|',$id);

        if(count($ids)>1){
            $result = true;
            foreach ($ids as $key => $id){
                if($key == count($ids)-1){
                    break;
                }

                if ($this->role->find($id)) {
                    $inp['del_flag'] = 1;

                    if(!($this->role->update($inp,$id))){
                        $result = false;
                    }
                }
            }

            if($result){
                return ['result'=>true];
            }else{
                return ['result'=>false];
            }
        }else{
            if ($this->role->find($id)) {
                $inp['del_flag'] = 1;

                if($this->role->update($inp,$id)){
                    return ['result'=>true];
                }else{
                    return ['result'=>false];
                }
            }
        }
        return ['result'=>false];
    }
}
