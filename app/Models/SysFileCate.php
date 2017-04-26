<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SysFileCate extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id','type','parent_id','parent_ids','name','sort','description','create_by','create_date','update_by','update_date','remarks','del_flag'];

    protected $table = 'sys_file_cate';

    public $incrementing = false;

    public $timestamps = false;
}
