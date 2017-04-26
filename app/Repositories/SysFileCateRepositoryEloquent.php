<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\sysFileCateRepository;
use App\Models\SysFileCate;
use App\Validators\SysFileCateValidator;
use Auth;

/**
 * Class SysFileCateRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SysFileCateRepositoryEloquent extends BaseRepository implements SysFileCateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SysFileCate::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 根据条件搜索文件夹信息
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchSysFileCate(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $sysFiles = $this->orderBy('update_date', 'desc')->paginate(30,['id','type','parent_id','parent_ids as parentIds','name','sort','description','create_by','create_date','update_by','update_date','remarks','del_flag']);
        return $sysFiles;
    }

    /**
     * 插入一个文件分类信息
     * @param $input
     */
    public function store($input)
    {

        //有id为修改无id为插入
        if(isset($input['id'])){
            $inp['type'] = $input['type'];
            $inp['parent_id'] = $input['parent_id'];
            $inp['parent_ids'] = $input['parent_ids'];
            $inp['name'] = $input['name'];
            $inp['sort'] = $input['sort'];
            $inp['description'] = $input['description'];
            $inp['update_by'] = $input['update_by'];
            $inp['update_date'] = date('y-m-d h:i:s',time());
            $inp['remarks'] = $input['remarks'];
            $inp['del_flag'] = $input['del_flag'];
            return parent::update($inp, $input['id']);
        }else{
            return $this->model->create([
                'id' => $this->create_uuid(),
                'type' => $input['type']=='images'?'1':'2',
                'parent_id' => $input['parent_id'],
                'parent_ids' => $input['parent_ids'].$input['parent_id'].',',
                'name' => $input['name'],
                'sort' => isset($input['sort'])?$input['sort']:null,
                'description' => isset($input['description'])?$input['description']:'',
                'create_by' => Auth::user()->id,
                'update_by' => Auth::user()->id,
                'create_date'=> date('y-m-d h:i:s',time()),
                'update_date'=> date('y-m-d h:i:s',time()),
                'remarks' => isset($input['remarks'])?$input['remarks']:'',
                'del_flag' => '0']) ? true : false;
        }
    }

    /**
     * 删除一个文件目录
     * @param $input
     */
    public function delDir($input)
    {
        //有id为修改无id为插入
        if(isset($input['id'])){
            $inp['update_by'] = Auth::user()->id;
            $inp['update_date'] = date('y-m-d h:i:s',time());
            $inp['del_flag'] = 1;
            return parent::update($inp, $input['id']);
        }else{
            return false;
        }
    }
}
