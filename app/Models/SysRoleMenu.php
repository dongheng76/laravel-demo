<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SysRoleMenu extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['role_id','menu_id'];

    protected $table = 'sys_role_menu';

    public $incrementing = false;

    public $timestamps = false;
}
