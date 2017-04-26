<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','company_id','office_id','login_name','password','no','name','email','phone','mobile','user_type','photo','login_ip','login_date','login_flag','create_by'
        ,'create_date','update_by','update_date','remarks','del_flag'];

    protected $table = 'sys_user';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获得用户所属公司信息
     */
    public function company(){
        return $this->hasOne('App\Models\Office', 'id', 'company_id');
    }

    /**
     * 获得用户所属机构信息
     */
    public function office(){
        return $this->hasOne('App\Models\Office', 'id', 'office_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 查询用户的所有角色信息
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'sys_user_role', 'user_id', 'role_id');
    }

    /**
     * 查看该用户是否是系统超级管理员
     */
    public function isAdmin(){
        if($this->id == '1') {
            return true;
        }else{
            return false;
        }
    }
}
