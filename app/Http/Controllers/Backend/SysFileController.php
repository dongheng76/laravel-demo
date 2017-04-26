<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepositoryEloquent;
use App\Repositories\OfficeRepositoryEloquent;
use App\Repositories\SysFileRepositoryEloquent;

class SysFileController extends Controller
{
    protected $role;
    protected $office;
    protected $sysFile;

    public function __construct(RoleRepositoryEloquent $role,OfficeRepositoryEloquent $office,SysFileRepositoryEloquent $sysFile)
    {
        $this->role = $role;
        $this->office = $office;
        $this->sysFile = $sysFile;
    }

    //查询图片或文件列表页
    public function index(Request $request)
    {
        $where = [];
        $where[] = ['del_flag','=','0'];

        return view('backend.sysfile.index');
    }

    //查询图片或文件列表页
    public function selectFrame(Request $request)
    {
        $where = [];
        $where[] = ['del_flag','=','0'];

        $func = $request->get('func');
        $format = $request->get('format');
        $sm = $request->get('sm');

        return view('backend.sysfile.select_frame',compact('func','format','sm'));
    }
}
