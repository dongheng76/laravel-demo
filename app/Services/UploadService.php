<?php

namespace App\Services;

use App\Http\Requests;
use Storage;
use File;
use Dflydev\ApacheMimeTypes\PhpRepository;
use App\Repositories\SysFileRepositoryEloquent;
use Intervention\Image\ImageManager;

class UploadService
{
    protected $disk;

    protected $phpRepository;

    //上传文件
    protected $sysFile;

    public function __construct(PhpRepository $phpRepository,SysFileRepositoryEloquent $sysFile)
    {
        $this->disk = Storage::disk(config('blog.uploads.storage'));
        $this->phpRepository = $phpRepository;
        $this->sysFile = $sysFile;
    }

    public function disk()
    {
        return $this->disk;
    }

    /**
     * 检查目录是否存在
     *
     * @param $path
     * @return bool
     */
    public function dirExists($path)
    {
        if ($path != "/") {
            return $this->disk->exists($path);
        }

        return true;
    }

    /**
     * 文件上传
     *
     * @param $request
     * @return array
     */
    public function uploadFile($request)
    {
        $input = $request->all();
        if($request->dir && $request->dir=='images'){
            $input['type']=1;
        }else{
            $input['type']=2;
        }

        $dir = "/".trim(str_replace('\\', '/', $request->dir), '/')."/";
        $str = md5(uniqid(mt_rand(), true));

        $yymmdd = date('Y').'/'.date('m').'/'.date('d').'/';
        $dir .= $yymmdd;

        //如果目录不存在就创建一个
        /*if (! file_exists ( $dir )) {
            mkdir ( $dir, 0777, true );
        }*/
        if (!$this->dirExists($dir)) {
            $this->disk->makeDirectory($dir);
        }

        $file = $request->file('file');
        $input['size'] = $file->getSize();
        $input['suffix'] = $file->getClientOriginalExtension();
        $input['ori_name'] = $file->getClientOriginalName();
        $input['name'] = $str;
        $input['path'] = $yymmdd.$str;
        //dd($file);
        $name = $request->name;

        $fileName = $str;
        $saveFile = $dir.$fileName.'.'.$file->getClientOriginalExtension();

        if ($this->disk->exists($saveFile)) {
            return ['status' => false, 'msg' => '文件名以存在或文件以存在'];
        }

        if ($this->disk->put($saveFile, File::get($file->getPathname()))) {

            //如果有缩放要求的就进行缩放
            if(isset($input['format']) && $input['format']!=''){
                $manager = new ImageManager(array('driver' => 'imagick'));

                // open an image file
                $img = $manager->make($file->getPathname());
                $strArray = $input['format'];
                $strArray = str_replace("@","\"",$strArray);

                $json = stripslashes($strArray);
                $input['format'] = $json;
                $formatArray = json_decode($json, true);

                //宽度
                $widthOrg = $img->getWidth();
                //高度
                $heightOrg = $img->getHeight();
                foreach ($formatArray as $format){
                    //取出图片宽和高
                    $frameWidth = $format['width'];
                    $frameHeight = $format['height'];
                    $finalWidth = 0;
                    $finalHeight = 0;
                    //等比例缩放
                    //图片原始宽高都小于等于要缩放的宽和高就不必缩放
                    if(!($widthOrg<=$frameWidth && $heightOrg<=$frameHeight)){
                        //高比宽长,以高为
                        if($heightOrg/$widthOrg>1){
                            $finalHeight = $frameHeight;
                            $finalWidth = $widthOrg/$heightOrg * $finalHeight;
                        }
                        //宽比高长
                        else if($heightOrg/$widthOrg<1){
                            $finalWidth = $frameWidth;
                            $finalHeight = $heightOrg/$widthOrg * $finalWidth;
                        }
                        //宽高相等
                        else if($heightOrg/$widthOrg==1){
                            $finalWidth = $frameWidth;
                            $finalHeight = $frameHeight;
                        }
                        // resize image instance
                        $img->resize($finalWidth, $finalHeight);
                        $path = config('filesystems.disks.upload.root').'/images/'.$yymmdd.$str.'_'.$frameWidth.'x'.$frameHeight.'.'.$file->getClientOriginalExtension();

                        // save image in desired format
                        $img->save($path);
                    }else{
                        $img->resize($widthOrg, $heightOrg);
                        $path = config('filesystems.disks.upload.root').'/images/'.$yymmdd.$str.'_'.$frameWidth.'x'.$frameHeight.'.'.$file->getClientOriginalExtension();

                        // save image in desired format
                        $img->save($path);
                    }
                }

            }

            $url = route('backend.upload.index', ['dir' => $dir]);

            //创建成功后向数据库插入数据
            $this->sysFile->store($input);

            return ['status' => true, 'url' => $url,'file'=>$input];
        }
        return ['status' => false, 'msg' => '上传失败'];
    }

    /**
     * 缩放上传的文件
     *
     * @param $request
     * @return array
     */
    public function imgZoom($request)
    {
        $input = $request->all();
        $ids = $input['ids'];
        $idsArray = explode('|',$ids);

        for($i=0;$i<count($idsArray);$i++){
            //根据id查询图片信息
            $img = $this->sysFile->find($idsArray[$i]);
            $manager = new ImageManager(array('driver' => 'imagick'));
            // 读取原始文件
            $imgObj = $manager->make(config('filesystems.disks.upload.root').'/images/'.$img['path'].'.'.$img['suffix']);
            $json = str_replace("@","\"",$input['format']);
            $formatArray = json_decode($json, true);

            //宽度
            $widthOrg = $imgObj->getWidth();
            //高度
            $heightOrg = $imgObj->getHeight();
            //数据库里的原始缩放尺寸
            $orgFormatArray = json_decode($img['format'], true);
            $newFormatArray = $orgFormatArray;

            foreach ($formatArray as $format){
                //查看是否需要缩放,如果以前已经缩放的格式将不会再次缩放
                $isNeedZoom = true;

                if(isset($img['format']) && $img['format']!=''){
                    if(isset($orgFormatArray)){
                        foreach ($orgFormatArray as $orgFormat){
                            if($orgFormat['width']==$format['width'] && $orgFormat['height']==$format['height']){
                                $isNeedZoom = false;
                                break;
                            }
                        }
                    }
                }

                if($isNeedZoom){
                    $newFormatArray[] = ['width'=>$format['width'],'height'=>$format['height']];
                    //取出图片宽和高
                    $frameWidth = $format['width'];
                    $frameHeight = $format['height'];
                    $finalWidth = 0;
                    $finalHeight = 0;

                    //等比例缩放
                    //图片原始宽高都小于等于要缩放的宽和高就不必缩放
                    if(!($widthOrg<=$frameWidth && $heightOrg<=$frameHeight)){
                        //高比宽长,以高为
                        if($heightOrg/$widthOrg>1){
                            $finalHeight = $frameHeight;
                            $finalWidth = $widthOrg/$heightOrg * $finalHeight;
                        }
                        //宽比高长
                        else if($heightOrg/$widthOrg<1){
                            $finalWidth = $frameWidth;
                            $finalHeight = $heightOrg/$widthOrg * $finalWidth;
                        }
                        //宽高相等
                        else if($heightOrg/$widthOrg==1){
                            $finalWidth = $frameWidth;
                            $finalHeight = $frameHeight;
                        }
                        // resize image instance
                        $imgObj->resize($finalWidth, $finalHeight);
                        $path = config('filesystems.disks.upload.root').'/images/'.$img['path'].'_'.$frameWidth.'x'.$frameHeight.'.'.$img['suffix'];

                        // save image in desired format
                        $imgObj->save($path);
                    }else{
                        $imgObj->resize($widthOrg, $heightOrg);
                        $path = config('filesystems.disks.upload.root').'/images/'.$img['path'].'_'.$frameWidth.'x'.$frameHeight.'.'.$img['suffix'];
                        // save image in desired format
                        $imgObj->save($path);
                    }
                }
            }
            $newFormatArrayJson = json_encode($newFormatArray);
            //最后修改该图片的缩放字段
            $img->format = $newFormatArrayJson;
            $this->sysFile->store($img->toArray());
        }

        return true;
    }

    /**
     * 获取目录下文件和文件列表
     *
     * @param $dir
     * @return array
     */
    public function folderInfo($dir)
    {
        $fileList = $this->fileInfo($dir);

        $dirList = $this->dirList($dir);

        return compact('fileList', 'dirList');
    }

    /**
     * 获取目录列表
     *
     * @param $dir
     * @return mixed
     */
    public function dirList($dir)
    {
        $list = $this->disk->directories($dir);
        $dirList = [];
        foreach ($list as $l) {
            $lArray = explode('/', str_replace('\\', '/', $l));
            $dirList[] = array_pop($lArray);
        }
        return $dirList;
    }

    /**
     * 文件信息
     *
     * @param $dir
     * @return array
     */
    public function fileInfo($dir)
    {
        $files = $this->disk->files($dir);

        $filesInfo = [];
        $webPath = config('blog.uploads.webPath');
        $host = url('/');
        if ($files) {
            foreach ($files as $file) {
                $temp = [];
                $temp['file_name']  = basename($file);
                $temp['mime_type']  = $this->getFileMimeType($file);
                $temp['size']       = $this->getFileSize($file);
                $temp['modified_date']   = $this->getLastModified($file);
                $temp['path']       = $host.$webPath."/".$file;

                $filesInfo[] = $temp;
            }
        }

        return $filesInfo;
    }

    public function getFileMimeType($path)
    {
        return $this->phpRepository->findType(pathinfo($path, PATHINFO_EXTENSION));
    }

    public function getFileSize($path)
    {
        return $this->disk->size($path);
    }

    public function getLastModified($path)
    {
        return date('Y-m-d H:i:s', $this->disk->lastModified($path));
    }
}