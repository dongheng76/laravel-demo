<?php

namespace App\Repositories;

use App\Repositories\Util\UtilBaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepository;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends UtilBaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * 按条件查询用户
     *
     * @param array $where
     * @return mixed
     */
    public function backendSearchUser(array $where,$inp)
    {
        $model = $this->model->leftJoin('sys_office','sys_user.office_id','=','sys_office.id');

        $this->dataScopeFilter($model,'sys_office');

        if (count($where) > 0) {
            foreach ($where as $whereRow){
                $model->where($whereRow[0],$whereRow[1],$whereRow[2]);
            }
        }
        $sortName = 'sys_office.update_date';$sortOrder = 'desc';
        if(isset($inp['sortName']) && isset($inp['sortOrder'])){
            $sortName = $inp['sortName'];
            $sortOrder = $inp['sortOrder'];
        }
        $roles = $model->orderBy($sortName,$sortOrder)->select('sys_user.*')->paginate(30);
        return $roles;
    }

    public function store(array $input){
        //有id为修改无id为插入
        if(isset($input['id'])){
            $inp['office_id'] = $input['office_id'];
            if(isset($input['password'])&&$input['password']!=''){
                $inp['password'] = Hash::make($input['password']);
            }
            $inp['no'] = $input['no'];
            $inp['name'] = $input['name'];
            $inp['email'] = $input['email'];
            $inp['phone'] = $input['phone'];
            $inp['mobile'] = $input['mobile'];
            $inp['user_type'] = $input['user_type'];
            $inp['photo'] = $input['photo'];
            $inp['login_ip'] = $_SERVER['REMOTE_ADDR'];
            $inp['login_flag'] = $input['login_flag'];
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
                'login_name' => $input['login_name'],
                'password' => isset($input['password'])?Hash::make($input['password']):Hash::make(''),
                'no' => $input['no'],
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => isset($input['phone'])?$input['phone']:null,
                'mobile' => isset($input['mobile'])?$input['mobile']:null,
                'user_type' => $input['user_type'],
                'photo' => isset($input['photo'])?$input['photo']:null,
                'login_ip' => $_SERVER['REMOTE_ADDR'],
                'login_flag' => $input['login_flag'],
                'create_by' => Auth::user()->id,
                'update_by' => Auth::user()->id,
                'create_date'=> date('y-m-d h:i:s',time()),
                'update_date'=> date('y-m-d h:i:s',time()),
                'remarks' => isset($input['remarks'])?$input['remarks']:'',
                'del_flag' => '0']) ? $id : false;
        }
    }

    public function updateUser(array $input, $id, $avatar = '')
    {
        $attr['email'] = $input['email'];
        $attr['name'] = $input['name'];
        if ($input['password'] != "")  {
            $attr['password'] = bcrypt($input['password']);
        }
        if ($avatar != "") {
            $attr['user_pic'] = $avatar;
        }

        if (parent::update($attr, $id)) {
            return true;
        }
        return false;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
