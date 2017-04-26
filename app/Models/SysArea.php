<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SysArea extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id','parent_id','parent_ids','name','sort','code','type','create_by','create_date','update_by','update_date','remarks','del_flag'];

    public $table = 'sys_area';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * 获得父亲的相关信息
     */
    public function parent(){
        return $this->hasOne(get_class($this), 'id', 'parent_id');
    }
}
