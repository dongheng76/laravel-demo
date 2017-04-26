<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\UploadService;
use App\Http\Requests\Backend\Upload\FileDeleteRequest;
use App\Http\Requests\Backend\Upload\DirDeleteRequest;
use App\Http\Requests\Backend\Upload\MakeDirRequest;
use App\Http\Requests\Backend\Upload\UploadStoreRequest;
use App\Repositories\SysFileRepositoryEloquent;
use App\Repositories\SysFileCateRepositoryEloquent;

class UploadController extends Controller
{
    protected $uploadService;

    protected $disk;

    protected $sysFile;

    protected $sysFileCate;

    public function __construct(UploadService $uploadService,SysFileRepositoryEloquent $sysFile,SysFileCateRepositoryEloquent $sysFileCate)
    {
        $this->uploadService = $uploadService;
        $this->sysFile = $sysFile;
        $this->sysFileCate = $sysFileCate;
        $this->disk = $this->uploadService->disk();
    }

    /**
     * 文件管理页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $dir = str_replace('\\', '/', $request->get('dir', '/'));
        $fileList = $this->uploadService->folderInfo($dir);
        return view('backend.upload.index', compact('fileList', 'dir'));
    }

    /**
     * 根据条件取得图片的信息
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFiles(Request $request)
    {
        $where = [];
        $where[] = ['del_flag','=','0'];
        $where[] = ['create_by','=',Auth::user()->id];

        if($request->get('type') && $request->get('type')=='image'){
            $where[] = ['type','=','1'];
        }else{
            $where[] = ['type','=','2'];
        }

        if($request->get('file_cate_id')){
            $where[] = ['file_cate_id','=',$request->get('file_cate_id')];
        }

        $sysFiles = $this->sysFile->backendSearchSysFile($where);

        $pageHtml = "<ul>
        ".($sysFiles->currentPage()-1>0?"<li><a style=\"font-size:12px;\" href=\"javascript:\" onclick=\"page(".($sysFiles->currentPage()-1).",'');\">« 上一页</a></li>":"<li class=\"disabled\"><a style=\"font-size:12px;\" href=\"javascript:\">« 上一页</a></li>")."
        ".($sysFiles->currentPage()-3>0?"<li><a href=\"javascript:\" onclick=\"page(".($sysFiles->currentPage()-3).",'');\">".($sysFiles->currentPage()-3)."</a></li>":"")."
        ".($sysFiles->currentPage()-2>0?"<li><a href=\"javascript:\" onclick=\"page(".($sysFiles->currentPage()-2).",'');\">".($sysFiles->currentPage()-2)."</a></li>":"")."
        ".($sysFiles->currentPage()-1>0?"<li><a href=\"javascript:\" onclick=\"page(".($sysFiles->currentPage()-1).",'');\">".($sysFiles->currentPage()-1)."</a></li>":"")."
        <li class=\"active\"><a href=\"javascript:\">".$sysFiles->currentPage()."</a></li>
        ".($sysFiles->currentPage()+1<=$sysFiles->lastPage()?"<li><a href=\"javascript:\" onclick=\"page(".($sysFiles->currentPage()+1).",'');\">".($sysFiles->currentPage()+1)."</a></li>":"")."
        ".($sysFiles->currentPage()+2<=$sysFiles->lastPage()?"<li><a href=\"javascript:\" onclick=\"page(".($sysFiles->currentPage()+2).",'');\">".($sysFiles->currentPage()+2)."</a></li>":"")."
        ".($sysFiles->currentPage()+3<=$sysFiles->lastPage()?"<li><a href=\"javascript:\" onclick=\"page(".($sysFiles->currentPage()+3).",'');\">".($sysFiles->currentPage()+3)."</a></li>":"")."
        ".($sysFiles->lastPage()-$sysFiles->currentPage()>0?"<li><a href=\"javascript:\" onclick=\"page(".($sysFiles->currentPage()+1).",'');\">下一页 »</a></li>":"<li class=\"disabled\"><a href=\"javascript:\">下一页 »</a></li>")."
        <li class=\"disabled controls\">
            当前
                <input type=\"text\" value=\"".$sysFiles->currentPage()."\" style=\"padding:2px 3px;width:20px;\" onkeypress=\"var e=window.event||event;var c=e.keyCode||e.which;if(c==13)page(this.value,30,'');\" onclick=\"this.select();\"/> /
                ".$sysFiles->lastPage()." 页，共 ".$sysFiles->total()." 条
        </li>
        </ul>
        <div style=\"clear:both;\"></div>";

        //把type按照类型进行重新分类赋值
        foreach($sysFiles as $key=>$sysFile){
            $sysFiles[$key]->type = $sysFile->type=='1'?'image':'file';
            $sysFiles[$key]->title = $sysFile->ori_name;
            if($request->get('type') && $request->get('type')=='image'){
                //切割字符串在拼接
                $strs = explode(".",$sysFile->path);
                $path = '';
                foreach($strs as $i=>$u){
                    if($i ==0){
                        $path .= $u;
                    }elseif($i==count($strs)-1){
                        break;
                    }else{
                        $path .= '.'.$u;
                    }
                }

                $sysFiles[$key]->path = config('blog.uploads.webPath').'/images/'.$path;
            }else{
                //$sysFiles[$key]->path = config('blog.uploads.webPath').'/files/'.$sysFile->path;
            }
        }

        return ['result'=>true,'sysFiles'=>$sysFiles,'pageHtml'=>$pageHtml];
    }

    /**
     * 根据条件取得用户文件夹信息
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFolders(Request $request)
    {
        $where = [];
        $where[] = ['del_flag','=','0'];
        $where[] = ['create_by','=',Auth::user()->id];
        if($request->get('type') && $request->get('type')=='image'){
            $where[] = ['type','=','1'];
        }else{
            $where[] = ['type','=','2'];
        }

        $sysFileCates = $this->sysFileCate->backendSearchSysFileCate($where);

        if($request->get('type') && $request->get('type')=='image'){
            $sysFileCates[] = ["id"=>"0","name"=>"我的相册","parent_id"=>"%","iconSkin"=>"customIcon"];
        }else{
            $sysFileCates[] = ["id"=>"0","name"=>"我的文件","parent_id"=>"%","iconSkin"=>"customIcon"];
        }
        return ['result'=>true,'sysFileCates'=>$sysFileCates];
    }

    /**
     * 文件上传
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fileUpload(Request $request)
    {
        $dir = $request->dir;
        if ($dir == "") {
            return redirect()->back()->withErrors('非法参数');
        }
        if (!$this->uploadService->dirExists($dir)) {
            return redirect()->back()->withErrors('目录不存在');
        }
        return view('backend.upload.upload', compact('dir'));
    }

    /**
     * 文件上传保存
     *
     * @param UploadStoreRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function fileStore(UploadStoreRequest $request)
    {
        $response = $this->uploadService->uploadFile($request);

        return $response;
        
    }

    /**
     * 文件删除
     *
     * @param Request $request
     * @return $this
     */
    public function fileDelete(FileDeleteRequest $request)
    {
        try {
            $this->disk->delete($request->file);
            return response()->json(['status' => 0]);
        } catch (\Exception $e)  {
            return response()->json(['status' => 1, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 目录删除
     *
     * @param Request $request
     * @return $this
     */
    public function dirDelete(DirDeleteRequest $request)
    {
        $input = $request->all();
        $result = $this->sysFileCate->delDir($input);

        if($result){
            return ['result'=>true];
        }else{
            return ['result'=>false];
        }
    }

    /**
     * 创建目录
     *
     * @param Request $request
     */
    public function makeDir(MakeDirRequest $request)
    {
        $input = $request->all();
        $result = $this->sysFileCate->store($input);

        if($result){
            return ['result'=>true];
        }else{
            return ['result'=>false];
        }
    }

    /**
     * 自动缩放
     *
     * @param Request $request
     */
    public function imgZoom(Request $request)
    {
        $result = $this->uploadService->imgZoom($request);

        if($result){
            return ['result'=>true];
        }else{
            return ['result'=>false];
        }
    }
}
