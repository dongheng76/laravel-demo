<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DictRepository;
use App\Models\Dict;

/**
 * Class DictRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DictRepositoryEloquent extends BaseRepository implements DictRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Dict::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 查询字段的所有类型
     */
    public function queryDictAllType(){
        $where = [['del_flag','=','0']];
        $dicts = $this->model->where($where)->orderBy('type','asc')->groupBy('type')->get();

        return $dicts;
    }

    /**
     * 按条件查询字典
     *
     * @param array $where
     * @return mixed
     */
    public function backendSearchDict(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }
        $dicts = $this->orderBy('type', 'asc')->orderBy('sort', 'asc')->all();
        return $dicts;
    }

    /**
     * 按条件查询字典
     *
     * @param array $where
     * @return mixed
     */
    public function backendPageSearchDict(array $where)
    {
        if (count($where) > 0) {
            $this->applyConditions($where);
        }

        $dicts = $this->orderBy('type', 'asc')->orderBy('sort', 'asc')->paginate(30);

        return $dicts;
    }

    /**
     * @param $input
     * @return bool
     */
    public function store(Request $input)
    {

        //有id为修改无id为插入
        if($input->get('id')){
            $inp['value'] = $input->get('value');
            $inp['label'] = $input->get('label');
            $inp['type'] = $input->get('type');
            $inp['sort'] = $input->get('sort');
            $inp['update_date'] = date('y-m-d h:i:s',time());

            return parent::update($inp, $input->get('id'));
        }else{
            return $this->model->create([
                'id' => $this->create_uuid(),
                'value' => $input->get('value'),
                'label' => $input->get('label'),
                'type' => $input->get('type'),
                'sort' => $input->get('sort'),
                'parent_id' => 0,
                'del_flag' => 0,
                'create_date'=> date('y-m-d h:i:s',time()),
                'update_date'=> date('y-m-d h:i:s',time())]) ? true : false;
        }
    }
}
