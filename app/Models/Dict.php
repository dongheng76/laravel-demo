<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Dict extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id','value','label' ,  'type', 'description','sort','parent_id',
        'create_by','create_date','update_by', 'update_date','remarks','del_flag'];

    public $table = 'sys_dict';

    public $incrementing = false;

    public $timestamps = false;
}
