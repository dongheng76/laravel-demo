<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\officeRepository;
use App\Models\Office;
use App\Validators\OfficeValidator;
use Auth;

/**
 * Class OfficeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OfficeRepositoryEloquent extends BaseRepository implements OfficeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Office::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 搜索机构信息非递归
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchSysOfficeNoRecursion(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $offices = $this->orderBy('sort', 'asc')->all();
        return $offices;
    }

    /**
     * 搜索机构信息
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchSysOffice(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $offices = $this->orderBy('sort', 'asc')->all();
        $count = 0;
        foreach($offices as $office){
            $this->queryChildren($offices[$count]);
            $count++;
        }
        return $offices;
    }

    /**
     * 递归查询所有数据
     */
    public function queryChildren(&$office){
        if($office){
            $where2[] = ['parent_id','=',$office['id']];

            $office['children'] = $this->findWhere($where2);
            if(count($office['children'])>0){
                $count = 0;
                foreach($office['children'] as $child){
                    $this->queryChildren($office['children'][$count]);
                    $count++;
                }
            }
        }
    }

    /**
     * 插入一个机构信息
     * @param $input
     * @return bool
     */
    public function store($input)
    {
        //有id为修改无id为插入
        if(isset($input['id'])){
            $inp['name'] = $input['name'];
            $inp['sort'] = $input['sort'];
            $inp['area_id'] = $input['area_id'];
            $inp['type'] = $input['type'];
            if($input['code']){
                $inp['code'] = $input['code'];
            }
            if($input['address']){
                $inp['address'] = $input['address'];
            }
            if($input['phone']){
                $inp['phone'] = $input['phone'];
            }
            if($input['fax']){
                $inp['fax'] = $input['fax'];
            }
            if($input['email']){
                $inp['email'] = $input['email'];
            }
            $inp['update_by'] = Auth::user()->id;
            $inp['update_date'] = date('y-m-d h:i:s',time());
            $inp['remarks'] = $input['remarks'];

            return parent::update($inp, $input['id']);
        }else{
            return $this->model->create([
                'id' => $this->create_uuid(),
                'parent_id' => isset($input['parent_id'])?$input['parent_id']:'0',
                'parent_ids' => isset($input['parent_id'])?($input['parent_ids'].$input['parent_id'].','):'0,',
                'name' => $input['name'],
                'sort' => $input['sort'],
                'area_id' => $input['area_id'],
                'code' => $input['code'],
                'type' => $input['type'],
                'address' => isset($input['address'])?$input['address']:'',
                'phone' => isset($input['phone'])?$input['phone']:'',
                'fax' => isset($input['fax'])?$input['fax']:'',
                'email' => isset($input['email'])?$input['email']:'',
                'create_by' => Auth::user()->id,
                'update_by' => Auth::user()->id,
                'create_date'=> date('y-m-d h:i:s',time()),
                'update_date'=> date('y-m-d h:i:s',time()),
                'remarks' => isset($input['remarks'])?$input['remarks']:'',
                'del_flag' => '0']) ? true : false;
        }
    }
}
