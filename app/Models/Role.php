<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Role extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id','office_id','name','enname','role_type','data_scope','is_sys','useable','create_by','create_date','update_by','update_date','remarks','del_flag'];

    public $table = 'sys_role';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * 获得角色所属部分信息
     */
    public function office(){
        return $this->hasOne('App\Models\Office', 'id', 'office_id');
    }
}
