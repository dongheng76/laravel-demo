<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\OfficeRepositoryEloquent;
use App\Repositories\RoleRepositoryEloquent;
use App\Repositories\SysUserRoleRepositoryEloquent;
use App\Http\Requests\Backend\User\CreateRequest;
use App\Http\Requests\Backend\User\UpdateRequest;
use Storage;
use Auth;
use App\Services\ImageUploads;
use App\Util\CacheUtils;
use App\Util\UserUtil;

class UserController extends Controller
{
    protected $user;
    protected $office;
    protected $role;
    protected $userRole;

    /**
     * UserController constructor.
     * @param UserRepositoryEloquent $user
     */
    public function __construct(UserRepositoryEloquent $user,OfficeRepositoryEloquent $office,RoleRepositoryEloquent $role,SysUserRoleRepositoryEloquent $userRole)
    {
        $this->user = $user;
        $this->office = $office;
        $this->role = $role;
        $this->userRole = $userRole;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        $where[] = ['sys_user.del_flag','=','0'];
        if($request->get('name')){
            $where[] = ['sys_user.name','like','%'.$request->get('name').'%'];
        }
        if($request->get('login_name')){
            $where[] = ['sys_user.login_name','like','%'.$request->get('login_name').'%'];
        }
        if($request->get('create_date_start')){
            $where[] = ['sys_user.create_date','>=',$request->get('create_date_start')];
        }
        if($request->get('create_date_end')){
            $where[] = ['sys_user.create_date','<=',$request->get('create_date_end')];
        }

        $users = $this->user->backendSearchUser($where,$request->all());
        $condition = $request->all();
        return view("backend.user.index", compact('users','condition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //查询所有可选的机构
        $where2 = [];
        $where2[] = ['del_flag','=','0'];
        $where2[] = ['parent_id','=','0'];
        $offices = $this->office->backendSearchSysOffice($where2);
        //查询能够选择的角色
        $roleWhere = [];
        $roleWhere[] = ['del_flag','=','0'];
        $roleWhere[] = ['is_sys','=','1'];
        $roles = $this->role->backendSearchRoleNoPage($roleWhere);

        return view('backend.user.create', compact('companys','offices','roles'));
    }

    /**
     * @param CreateRequest $request
     * @param ImageUploads $imageUploads
     * @return $this
     */
    public function store(CreateRequest $request)
    {
        $userId = $this->user->store($request->all());
        if ($userId) {
            //首先先删除用户的角色信息
            $userRoleWhere = [];
            $userRoleWhere[] = ['user_id','=',$userId];
            $this->userRole->deleteWhere($userRoleWhere);
            //如果成功后需要把用户角色信息进行插入操作
            $roles = $request->get("role");
            foreach ($roles as $role) {
                $user = array('user_id'=>$userId,'role_id'=>$role);
                $this->userRole->store($user);
            }

            return ['result'=>true];
        }

        return ['result'=>false];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        //查询所有可选的机构
        $where2 = [];
        $where2[] = ['del_flag','=','0'];
        $where2[] = ['parent_id','=','0'];
        $offices = $this->office->backendSearchSysOffice($where2);
        //查询能够选择的角色
        $roleWhere = [];
        $roleWhere[] = ['del_flag','=','0'];
        $roleWhere[] = ['is_sys','=','1'];
        $roles = $this->role->backendSearchRoleNoPage($roleWhere);

        $user = $this->user->find($id);

        //搜索当前用户的角色信息
        $userRoleWhere = [];
        $userRoleWhere[] = ['user_id','=',$id];
        $userRoles = $this->userRole->backendSearchUserRole($userRoleWhere);

        return view("backend.user.create", compact('user','offices','roles','userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        $userId = $this->user->store($request->all());
        if ($userId) {
            //首先先删除用户的角色信息
            $userRoleWhere = [];
            $userRoleWhere[] = ['user_id','=',$userId];
            $this->userRole->deleteWhere($userRoleWhere);
            //如果成功后需要把用户角色信息进行插入操作
            $roles = $request->get("role");
            foreach ($roles as $role) {
                $user = array('user_id'=>$userId,'role_id'=>$role);
                $this->userRole->store($user);
            }

            //修改完信息后需要对该用户进行redis缓存权限更新
            CacheUtils::removeAll(UserUtil::$SYS_MENU_NAME.$userId);
            return ['result'=>true];
        }

        return ['result'=>false];
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

                if ($this->user->find($id)) {
                    $inp['del_flag'] = 1;

                    if(!($this->user->update($inp,$id))){
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
            if ($this->user->find($id)) {
                $inp['del_flag'] = 1;

                if($this->user->update($inp,$id)){
                    return ['result'=>true];
                }else{
                    return ['result'=>false];
                }
            }
        }
        return ['result'=>false];
    }
}
