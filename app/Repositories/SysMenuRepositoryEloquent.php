<?php

namespace App\Repositories;

use DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SysMenuRepository;
use App\Models\SysMenu;
use App\Validators\SysMenuValidator;
use Auth;

/**
 * Class SysMenuRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SysMenuRepositoryEloquent extends BaseRepository implements SysMenuRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SysMenu::class;
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 搜索菜单
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchSysMenu(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $sysmenus = $this->orderBy('sort', 'asc')->all();
        $count = 0;
        foreach($sysmenus as $sysmenu){
            $this->queryChildren($sysmenus[$count]);
            $count++;
        }
        return $sysmenus;
    }

    /**
     * 递归查询所有数据
     */
    public function queryChildren(&$sysmenu){
        if($sysmenu){
            $sysmenu['children'] = $this->orderBy('sort', 'asc')->findWhere([['parent_id','=',$sysmenu['id']],['del_flag','=','0']]);
            if(count($sysmenu['children'])>0){
                $count = 0;
                foreach($sysmenu['children'] as $child){
                    $this->queryChildren($sysmenu['children'][$count]);
                    $count++;
                }
            }
        }
    }

    /**
     * 非递归搜索菜单
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchSysMenuNoRecursion(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $sysmenus = $this->orderBy('sort', 'asc')->all();
        return $sysmenus;
    }

    /**
     * 非递归搜查询我拥有权限的菜单
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchSysMenuNoRecursionMy($roleId)
    {
        $sysMenus = DB::select("select sm.*,(case when srm.menu_id is not null then 'true' else 'false' end) as checked
        from sys_menu sm left join sys_role_menu srm on sm.id=srm.menu_id and srm.role_id = '".$roleId."' 
        where sm.del_flag = 0
        order by sm.sort asc
        ");
        return $sysMenus;
    }

    /**
     * 插入一个菜单信息
     * @param $input
     * @return bool
     */
    public function store($input)
    {
        //有id为修改无id为插入
        if(isset($input['id'])){
            $parentMenu = $this->find($input['parent_id']);
            $inp['parent_id'] = $input['parent_id'];
            $inp['parent_ids'] = $parentMenu->parent_ids.$parentMenu->id.',';
            $inp['name'] = $input['name'];
            $inp['sort'] = $input['sort'];
            $inp['href'] = $input['href'];
            $inp['icon'] = $input['icon'];
            $inp['permission'] = $input['permission'];
            $inp['update_by'] = Auth::user()->id;
            $inp['update_date'] = date('y-m-d h:i:s',time());
            $inp['remarks'] = $input['remarks'];

            return parent::update($inp, $input['id']);
        }else{
            $parentMenu = $this->find($input['parent_id']);
            return $this->model->create([
                'id' => $this->create_uuid(),
                'parent_id' => $input['parent_id'],
                'parent_ids' => $parentMenu->parent_ids.$parentMenu->id.',',
                'name' => $input['name'],
                'sort' => $input['sort'],
                'href' => isset($input['href'])?$input['href']:0,
                'icon' => isset($input['icon'])?$input['icon']:'',
                'permission' => isset($input['permission'])?$input['permission']:'',
                'create_by' => Auth::user()->id,
                'update_by' => Auth::user()->id,
                'create_date'=> date('y-m-d h:i:s',time()),
                'update_date'=> date('y-m-d h:i:s',time()),
                'remarks' => isset($input['remarks'])?$input['remarks']:'',
                'del_flag' => '0']) ? true : false;
        }
    }
}
