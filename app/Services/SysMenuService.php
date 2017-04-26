<?php

namespace App\Services;

use App\Repositories\SysMenuRepositoryEloquent;
use App\Http\Request;

class SysMenuService
{
    protected $sysMenu;

    public function __construct(SysMenuRepositoryEloquent $sysMenu)
    {
        $this->sysMenu = $sysMenu;
    }

    /**
     * 搜索where条件
     *
     * @param $request
     * @return array
     */
    public static function backendSearchWhere($request)
    {
        $where = [];

        if ($request->name != "") {
            $where[] = ['name', 'like', "%".$request->name."%"];
        }

        if ($request->parent_ids != "") {
            $where[] = ['parent_ids', 'like', "%".$request->parent_ids."%"];
        }
        if ($request->parent_id>=0) {
            $where[] = ['parent_id', '=', $request->parent_id];
        }
        $where[] = ['del_flag', '=', '0'];
        return $where;
    }

    /**
     * 搜索菜单
     *
     * @param array $where
     * @return mixed
     */
    public  function backendSearchChilrenSysMenu(array $data)
    {
        $count = 0;
        foreach ($data as $d) {
            $request = array();
            $request->parent_id = $d['id'];
            $where = $this->backendSearchWhere($request);
            $data[$count]['chilren'] = $this->sysMenu->backendSearchSysMenu($where);
        }
        return $data;
    }
}