<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SysMenu extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id','parent_id','parent_ids','name','sort','href','target','icon','is_show','permission','create_by','create_date','update_by','update_date','remarks','del_flag'];

    protected $table = 'sys_menu';

    public $parentKey = 'parent_id'; //必要字段                MySQL需加索引
    public $orderKey = 'sort'; //无需此字段请设置NULL   MySQL需加索引
    public $incrementing = false;

    public $timestamps = false;

    public function parent()
    {
        return $this->hasOne(get_class($this), $this->getKeyName(), 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(get_class($this), 'parent_id', $this->getKeyName());
    }
}
