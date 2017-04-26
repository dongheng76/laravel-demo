<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\sysFileRepository;
use App\Models\SysFile;
use Auth;

/**
 * Class SysFileRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SysFileRepositoryEloquent extends BaseRepository implements SysFileRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SysFile::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 根据条件搜索文件信息
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchSysFile(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $sysFiles = $this->orderBy('update_date', 'desc')->paginate(30);
        return $sysFiles;
    }

    /**
     * 插入一个文件信息
     * @param $input
     * @return bool
     */
    public function store($input)
    {

        //有id为修改无id为插入
        if(isset($input['id'])){
            $inp['type'] = $input['type'];
            $inp['file_cate_id'] = $input['file_cate_id'];
            $inp['name'] = $input['name'];
            $inp['width'] = $input['width'];
            $inp['update_date'] = date('y-m-d h:i:s',time());
            $inp['height'] = $input['height'];
            $inp['ori_name'] = $input['ori_name'];
            $inp['size'] = $input['size'];
            $inp['path'] = $input['path'];
            $inp['suffix'] = $input['suffix'];
            $inp['format'] = $input['format'];
            $inp['del_flag'] = $input['del_flag'];

            return parent::update($inp, $input['id']);
        }else{
            return $this->model->create([
                'id' => $input['name'],
                'type' => $input['type'],
                'file_cate_id' => isset($input['file_cate_id'])?$input['file_cate_id']:'0',
                'name' => $input['name'],
                'width' => isset($input['width'])?$input['width']:0,
                'height' => isset($input['height'])?$input['height']:0,
                'ori_name' => $input['ori_name'],
                'size' => $input['size'],
                'path' => $input['path'],
                'suffix' => $input['suffix'],
                'format' => isset($input['format'])?$input['format']:'',
                'create_by' => Auth::user()->id,
                'update_by' => Auth::user()->id,
                'create_date'=> date('y-m-d h:i:s',time()),
                'update_date'=> date('y-m-d h:i:s',time()),
                'remarks' => isset($input['remarks'])?$input['remarks']:'',
                'del_flag' => '0']) ? true : false;
        }
    }
}
