<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SysRoleMenuRepository;
use App\Models\SysRoleMenu;
use App\Validators\SysRoleMenuValidator;
use DB;

/**
 * Class SysRoleMenuRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SysRoleMenuRepositoryEloquent extends BaseRepository implements SysRoleMenuRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SysRoleMenu::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function batchStore($arrayInput)
    {
        if(DB::table('sys_role_menu')->insert($arrayInput)){
            return true;
        }else{
            return false;
        }
    }
}
