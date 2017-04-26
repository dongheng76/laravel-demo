<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SysFile extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id','type','file_cate_id','name','width','height','ori_name','size','path','suffix','format','create_by','create_date','update_by','update_date','remarks','del_flag'];

    protected $table = 'sys_file';

    public $incrementing = false;

    public $timestamps = false;
}
