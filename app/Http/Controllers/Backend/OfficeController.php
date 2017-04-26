<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\OfficeRepositoryEloquent;
use App\Repositories\SysAreaRepositoryEloquent;
use App\Http\Requests\Backend\Office\CreateRequest;
use DB;

class OfficeController extends Controller
{
    protected $office;
    protected $sysArea;

    public function __construct(OfficeRepositoryEloquent $office,SysAreaRepositoryEloquent $sysArea)
    {
        $this->office = $office;
        $this->sysArea = $sysArea;
    }

    public function index(Request $request)
    {
        $where1 = [];
        $where1[] = ['del_flag','=','0'];
        $where1[] = ['parent_id','=','0'];
        $where1[] = ['type','<=','2'];
        $offices = $this->office->backendSearchSysOffice($where1);
        return view('backend.office.index',compact('offices'));
    }

    public function create(Request $request)
    {
        $sysAreas = $this->sysArea->queryChildrenByPId('0');
        $list = json_encode($sysAreas);
        //查询所有可选的部门
        $where1 = [];
        $where1[] = ['del_flag','=','0'];
        $where1[] = ['parent_id','=','0'];
        $where1[] = ['type','<=','2'];
        $offices = $this->office->backendSearchSysOffice($where1);

        //根据parent_id查询父级office对象
        if($request->get('parent_id')){
            $parentOffice = $this->office->find($request->get('parent_id'));
            //有parent_id要计算parent_id下的孩子的最大sort号
            $where = [];
            $where[] = ['del_flag','=','0'];
            $where[] = ['parent_id','=',$request->get('parent_id')];
            $officeChildren = $this->office->backendSearchSysOffice($where);
            $sort = 10;
            if(count($officeChildren)>0){
                $sort = (int)$officeChildren[count($officeChildren)-1]->sort + 10 ;
            }

            return view('backend.office.create',compact('offices','list','parentOffice','sort'));
        }else{
            $where2 = [];
            $where2[] = ['del_flag','=','0'];
            $where2[] = ['parent_id','=','0'];
            $officesRoot = $this->office->backendSearchSysOffice($where1);
            $sort = 10;
            if(count($officesRoot)>0){
                $sort = (int)$officesRoot[count($officesRoot)-1]->sort + 10 ;
            }

            return view('backend.office.create',compact('offices','list','sort'));
        }
    }

    //保存角色信息
    public function store(CreateRequest $request){
        $result = $this->office->store($request->all());
        if($result){
            return ['result'=> true];
        }else{
            return ['result'=> false];
        }
    }

    //编辑角色信息
    public function edit(Request $request){
        $id = $request->get('id');
        $sysAreas = $this->sysArea->queryChildrenByPId('0');
        $list = json_encode($sysAreas);
        //查询所有可选的部门
        $where1 = [];
        $where1[] = ['del_flag','=','0'];
        $where1[] = ['parent_id','=','0'];
        $where1[] = ['type','<=','2'];
        $offices = $this->office->backendSearchSysOffice($where1);

        $currentOffice = $this->office->find($id);

        return view('backend.office.create',compact('offices','list','currentOffice'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        $office = $this->office->find($id);
        if ($office) {
            $inp['del_flag'] = 1;

            if($this->office->update($inp,$id)){
                //除此之外还需要关联的删除
                $parent_ids = $office['parent_ids'].$office['id'].',';
                $relativeInp['del_flag'] = '1';

                $condition[] = ['parent_ids','like','%'.$parent_ids.'%'];
                DB::table('sys_office')->where('parent_ids','like','%'.$parent_ids.'%')->update($relativeInp);

                return ['result'=>true];
            }else{
                return ['result'=>false];
            }
        }
        return ['result'=>false];
    }
}
