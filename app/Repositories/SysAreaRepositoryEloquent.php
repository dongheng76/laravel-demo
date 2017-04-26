<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SysAreaRepository;
use App\Models\SysArea;
use App\Validators\SysAreaValidator;
use DB;
use Auth;

/**
 * Class SysAreaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SysAreaRepositoryEloquent extends BaseRepository implements SysAreaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SysArea::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 非递归搜索菜单
     *
     * @param array $where
     * @return mixed
     */
    public  function queryChildrenByPId($id)
    {
        $sysAreas = DB::select("select id,parent_id,parent_ids,name,sort,code,type,create_by,create_date,update_by,update_date,remarks,'true' as isParent
            from sys_area where parent_id = '".$id."'
            and del_flag = '0'
        ");
        return $sysAreas;
    }

    /**
     * 非递归搜索菜单
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchSysAreaNoRecursion(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $sysAreas = $this->orderBy('sort','asc')->all();
        return $sysAreas;
    }

    /**
     * 插入一个区域信息
     * @param $input
     * @return bool
     */
    public function store($input)
    {

        //有id为修改无id为插入
        if(isset($input['id'])){
            $inp['name'] = $input['name'];
            $inp['sort'] = $input['sort'];
            $inp['code'] = $input['code'];
            $inp['type'] = $input['type'];
            $inp['update_by'] = Auth::user()->id;
            $inp['update_date'] = date('y-m-d h:i:s',time());
            $inp['remarks'] = $input['remarks'];

            return parent::update($inp, $input['id']);
        }else{
            return $this->model->create([
                'id' => $this->create_uuid(),
                'parent_id' => $input['parent_id'],
                'parent_ids' => $input['parent_ids'].$input['parent_id'].',',
                'name' => $input['name'],
                'sort' => $input['sort'],
                'code' => $input['code'],
                'type' => $input['type'],
                'create_by' => Auth::user()->id,
                'update_by' => Auth::user()->id,
                'create_date'=> date('y-m-d h:i:s',time()),
                'update_date'=> date('y-m-d h:i:s',time()),
                'remarks' => isset($input['remarks'])?$input['remarks']:'',
                'del_flag' => '0']) ? true : false;
        }
    }
}
