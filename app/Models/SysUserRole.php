<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SysUserRole extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['user_id','role_id'];

    protected $table = 'sys_user_role';

    public $incrementing = false;

    public $timestamps = false;
}
