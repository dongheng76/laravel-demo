<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SysAreaRepositoryEloquent;
use App\Http\Requests\Backend\Area\CreateRequest;
use DB;

class AreaController extends Controller
{
    //
    protected $sysArea;


    public function __construct(SysAreaRepositoryEloquent $sysArea)
    {
        $this->sysArea = $sysArea;
    }

    public function index(Request $request)
    {

        $sysAreas = $this->sysArea->queryChildrenByPId('0');

        $list = json_encode($sysAreas);
        return view('backend.area.index',compact('list'));
    }

    public function create(Request $request)
    {
        if($request->get('parent_id')){
            //查找当前的区域信息
            $parentId = $request->get('parent_id');
            $parentSysArea = $this->sysArea->find($parentId);
            //查看该区域下的最大排序号
            $where = [];
            $where[] = ['parent_id','=',$parentId];
            $where[] = ['del_flag','=','0'];
            $childrenSysArea = $this->sysArea->backendSearchSysAreaNoRecursion($where);
            $sort = 0;
            if(count($childrenSysArea)>0){
                $sort = $childrenSysArea[count($childrenSysArea)-1]->sort;
            }else{
                $sort = 10;
            }

            return view('backend.area.create',compact('parentSysArea','sort'));
        }else{
            return view('backend.area.create');
        }
    }

    //通过父亲ID查询孩子信息
    public function findAreaByPid(Request $request){

        $sysAreas = $this->sysArea->queryChildrenByPId($request->get('parent_id'));
        return $sysAreas;
    }

    //编辑菜单信息
    public function edit(Request $request){
        $id = $request->get('id');
        $area = $this->sysArea->find($id);

        $parentSysArea = $this->sysArea->find($area->parent_id);
        return view('backend.area.create',compact('area','parentSysArea'));
    }

    /**
     * @param CreateRequest $request
     * @return $this
     */
    public function store(CreateRequest $request)
    {
        $this->sysArea->store($request->all());

        return ['result'=>true];
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
        $sysArea = $this->sysArea->find($id);
        if ($sysArea) {
            $inp['del_flag'] = 1;

            if($this->sysArea->update($inp,$id)){
                //除此之外还需要关联的删除
                $parent_ids = $sysArea['parent_ids'].$sysArea['id'].',';
                $relativeInp['del_flag'] = '1';

                $condition[] = ['parent_ids','like','%'.$parent_ids.'%'];
                DB::table('sys_area')->where('parent_ids','like','%'.$parent_ids.'%')->update($relativeInp);

                return ['result'=>true];
            }else{
                return ['result'=>false];
            }
        }
        return ['result'=>false];
    }
}
