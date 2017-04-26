<?php

namespace App\Http\Controllers\Backend;

use App\Util\CacheUtils;
use App\Util\UserUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\DictRepositoryEloquent;
use App\Http\Requests\Backend\Dict\CreateRequest;
use Validator;

class DictController extends Controller
{
    protected $dict;


    public function __construct(DictRepositoryEloquent $dict)
    {
        $this->dict = $dict;
    }

    //查询字典列表页
    public function index(Request $request)
    {
        $where = [];
        $where[] = ['del_flag','=','0'];

        if ($request->type != "") {
            $where[] = ['type', '=', $request->type];
        }
        $dicts = $this->dict->backendPageSearchDict($where);
        $dictsGroup = $this->dict->queryDictAllType();

        return view('backend.dict.index',compact('dicts','dictsGroup'));
    }

    public function create(Request $request)
    {
        $maxSort = 10;
        //查看是否有传入type如果有就进行根据type查询最大的order
        if($request->get('type')){
            $where = [];
            $where[] = ['del_flag','=','0'];
            $where[] = ['type','=',$request->get('type')];

            $dicts = $this->dict->backendSearchDict($where);

            $maxSort =$dicts[count($dicts)-1]->sort;
            $maxSort += 10;

            $type = $request->get('type');
        }

        //$dictsGroup = $this->dict->queryDictAllType();
        return view('backend.dict.create',compact('maxSort','type'));
    }

    //保存字典信息
    public function store(CreateRequest $request){
        if($this->dict->store($request)){
            return ['result'=>true];
        }else{
            return ['result'=>false];
        }

        //修改或保存新的字典信息后应该清除缓存里面的信息让系统重新读取缓存信息
        CacheUtils::removeAll(UserUtil::$SYS_MENU_NAME);
    }

    //编辑字典信息
    public function edit(Request $request){
        $id = $request->get('id');
        $dict = $this->dict->find($id);
        return view('backend.dict.create',compact('dict','id'));
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
        //判断是否是多用户删除
        $ids = explode('|',$id);

        if(count($ids)>1){
            $result = true;
            foreach ($ids as $key => $id){
                if($key == count($ids)-1){
                    break;
                }

                if ($this->dict->find($id)) {
                    $inp['del_flag'] = 1;

                    if(!($this->dict->update($inp,$id))){
                        $result = false;
                    }
                }
            }

            if($result){
                return ['result'=>true];
            }else{
                return ['result'=>false];
            }
        }else{
            if ($this->dict->find($id)) {
                $inp['del_flag'] = 1;

                if($this->dict->update($inp,$id)){
                    return ['result'=>true];
                }else{
                    return ['result'=>false];
                }
            }
        }
        return ['result'=>false];
    }
}
