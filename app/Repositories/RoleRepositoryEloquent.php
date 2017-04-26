<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\roleRepository;
use App\Models\Role;
use App\Validators\RoleValidator;
use Auth;

/**
 * Class RoleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 按条件查询角色不带分页的
     *
     * @param array $where
     * @return mixed
     */
    public function backendSearchRoleNoPage(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $roles = $this->orderBy('update_date', 'desc')->all();

        return $roles;
    }

    /**
     * 按条件查询角色
     *
     * @param array $where
     * @return mixed
     */
    public function backendSearchRole(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $roles = $this->orderBy('update_date', 'desc')->paginate(30);

        return $roles;
    }

    /**
     * 插入及其修改角色
     * @param $input
     * @return bool
     */
    public function store($input)
    {
        //有id为修改无id为插入
        if(isset($input['id'])){
            $inp['office_id'] = $input['office_id'];
            $inp['name'] = $input['name'];
            $inp['enname'] = $input['enname'];
            $inp['data_scope'] = $input['data_scope'];
            $inp['is_sys'] = $input['is_sys'];
            $inp['useable'] = 1;
            $inp['update_by'] = Auth::user()->id;
            $inp['update_date'] = date('y-m-d h:i:s',time());
            $inp['remarks'] = $input['remarks'];

            if(parent::update($inp, $input['id'])){
                return $input['id'];
            }else{
                return false;
            }
        }else{
            $id = $this->create_uuid();
            return $this->model->create([
                'id' => $id,
                'office_id' => $input['office_id'],
                'name' => $input['name'],
                'enname' => $input['enname'],
                'data_scope' => $input['data_scope'],
                'is_sys' => $input['is_sys'],
                'useable' => 1,
                'create_by' => Auth::user()->id,
                'update_by' => Auth::user()->id,
                'create_date'=> date('y-m-d h:i:s',time()),
                'update_date'=> date('y-m-d h:i:s',time()),
                'remarks' => isset($input['remarks'])?$input['remarks']:'',
                'del_flag' => '0']) ? $id : false;
        }
    }
}
