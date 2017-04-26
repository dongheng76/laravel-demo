<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Office extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id','parent_id','parent_ids','name','sort','area_id','code','type','grade','address','zip_code','master','phone','fax','email','create_by'
        ,'create_date','update_by','update_date','remarks','del_flag'];

    public $table = 'sys_office';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * 获得机构所属区域
     */
    public function area(){
        return $this->hasOne('App\Models\SysArea', 'id', 'area_id');
    }
}
