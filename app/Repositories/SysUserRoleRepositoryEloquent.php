<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SysUserRoleRepository;
use App\Models\SysUserRole;
use App\Validators\SysUserRoleValidator;

/**
 * Class SysUserRoleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SysUserRoleRepositoryEloquent extends BaseRepository implements SysUserRoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SysUserRole::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 插入一个文件分类信息
     * @param $input
     */
    public function store($input)
    {
        return $this->model->create([
            'user_id' => $input['user_id'],
            'role_id' => $input['role_id']
        ]) ? true : false;
    }

    /**
     * 搜索用户角色信息
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchUserRole(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $userRoles = $this->all();
        return $userRoles;
    }
}
