<?php

namespace App\Presenters;

use App\Transformers\SystemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;
use App\Repositories\SystemRepositoryEloquent;
use App\Repositories\DictRepositoryEloquent;
use App\Util\DictUtils;

/**
 * Class SystemPresenter
 *
 * @package namespace App\Presenters;
 */
class SystemPresenter extends FractalPresenter
{
    protected $system;

    protected $list;

    protected $dict;

    public function __construct(SystemRepositoryEloquent $system,DictRepositoryEloquent $dict)
    {
        $this->dict = $dict;
        $this->system = $system;
        $this->list = $this->system->optionList();
        parent::__construct();
    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SystemTransformer();
    }

    /**
     * 根据key获取value
     *
     * @param $key
     * @return mixed
     */
    public function getKeyValue($key)
    {
        return isset($this->list[$key]) ? $this->list[$key] : '';
    }

    /**
     * 检查返回相应的value
     *
     * @param $key
     * @param $defaultValue
     * @return mixed
     */
    public function checkReturnValue($key, $defaultValue)
    {
        if ($defaultValue != "") {
            return $defaultValue;
        }

        return $this->getKeyValue($key);
    }

    /**
     * 根据字典type和key查询字典对应的label
     */
    public function queryDictLabel($type,$value){
        $where = [];
        $where[] = ['type','=',$type];
        $where[] = ['value','=',$value];
        return DictUtils::getDictLabel($value,$type,'');
    }

    /**
     * 根据字典type取得字典的select2
     */
    public function getDictLabel($type,$name,$width,$defaultValue = false){
        $html = '<select style="width:'.$width.'px" class="select2" name="'.$name.'"><option />';
        $where = [];
        $where[] = ['type','=',$type];
        $dicts = DictUtils::getDictList($type);

        foreach($dicts as $dict){
            $html .=  '<option value="'.$dict->value.'" '.($dict->value==$defaultValue?'selected=""':'').' />'.$dict->label;
        }
        $html .= '</select>';

        return $html;
    }

    /**
     * 上传图片插件
     */
    public function makeUpload($input,$type,$selectMultiple,$limitCount,$showFormat = false,$format = false){
        $html = "
       	<div id=\"".$input."Preview\"></div><a href=\"javascript:\" onclick=\"".$input."FinderOpen();\" class=\"btn\">".($selectMultiple?"添加":"选择")."</a>&nbsp;<a href=\"javascript:\" onclick=\"".$input."DelAll();\" class=\"btn\">清除</a>
      		<script type=\"text/javascript\">
      			function ".$input."FinderOpen(){
					var url = \"/backend/fileframe?type=".$input."&isDialog=true&func=".$input."SelectAction&sm=".($selectMultiple?1:0)."&format=".$format."&showformat=".$showFormat."\";
					windowOpen(url,\"".($type == "images" ? '图片' : '文件')."管理\",1000,700);
				}

				function ".$input."SelectAction(files){
					".($selectMultiple?"
						try{
							var filesJson = JSON.parse($(\"".$input."\").val());
							for(var i=0;i<files.length;i++){
								".($limitCount?"
									if(filesJson.length+i+1>parseInt('".$limitCount."')){
										showTip(\"上传数量最大不能超过\"+".$limitCount."+\"张\");
										break;
									}
								":"")."

								filesJson.push(files[i]);
							}

							$(\"#".$input."\").val(JSON.stringify(filesJson));
						}catch(e){
							".($limitCount?"
									if(filesJson.length+i+1>parseInt('".$limitCount."')){
										showTip(\"上传数量最大不能超过\"+".$limitCount."+\"张\");
										break;
									}
								":"")."
							$(\"#".$input."\").val(JSON.stringify(files));
						}
					":"$(\"#".$input."\").val(JSON.stringify(files));").$input."Preview(files);
				}

				function ".$input."Callback(api){
					ckfinderAPI = api;
				}
				function ".$input."Del(obj){
					var name = $(obj).parent().attr(\"name\");
					var filesJson = JSON.parse($(\"#".$input."\").val());
					for(var i=0;i<filesJson.length;i++){
						if(filesJson[i].name == name){
							filesJson.remove(i);
							break;
						}
					}
					$(\"#".$input."\").val(JSON.stringify(filesJson));

					".$input."Preview();
				}
				function ".$input."DelAll(){
					$(\"#".$input."\").val(\"\");
					".$input."Preview();
				}

				function ".$input."Preview(){
					var isHas = false;
					try{
						var filesJson = JSON.parse($(\"#".$input."\").val());
						$(\"#".$input."Preview\").children().remove();
						for (var i=0; i<filesJson.length; i++){
							if (filesJson[i]!=null){
								var fileFrame = $('<div></div>').addClass('ckfinder-imgFrame').attr('name',filesJson[i].name);

								".($type=="files"?"
									fileFrame.css({
										width:150,
										height:150,
										float:'left',
										marginRight:'10px',
										border:'1px',
										borderColor:'#EEEEEE',
										borderStyle:'solid',
										backgroundPosition:'center center',
										//backgroundImage:'url('+ctxStatic+'/ckfinder/images/'+suffix+'.png)',
										backgroundRepeat:'no-repeat',
										marginBottom:'10px',
										position:'relative'
									});
									var fileName = $('<a target=\"_blank\" href=\"/ckfinder/core/connector/java/connector.java?command=DownloadFile&type=files&langCode=zh-cn&newFileName='+filesJson[i].title+\".\"+filesJson[i].suffix+'&FileName='
									+filesJson[i].path+\".\"+filesJson[i].suffix+'\">'+filesJson[i].title+'.'+filesJson[i].suffix+'</a>').css({
										height:30,
										lineHeight:'30px',
										position:'absolute',
										bottom:0,
										width:'100%',
										left:0,
										textAlign:'center'
									}).appendTo(fileFrame);

									var fileTypeImg = $('<img style=\"margin-left:32px;margin-top:10px;\" src=\"/ckfinder/images/'+filesJson[i].suffix+'.png\" width=\"84\" height=\"108\"/>').appendTo(fileFrame);
								":"
								    ".($showFormat?"
                                 var thumb = ".$showFormat.";
						            filesJson[i].path = filesJson[i].path+\"_\"+thumb.width+\"x\"+thumb.height;
						            fileFrame.css({
                                    width:thumb.width,
                                    height:thumb.height,
                                    float:'left',
                                    marginRight:'10px',
                                    border:'1px',
                                    borderColor:'#EEEEEE',
                                    borderStyle:'solid',
                                    backgroundPosition:'center center',
                                    backgroundImage:'url('+filesJson[i].path+\".\"+filesJson[i].suffix+')',
                                    backgroundRepeat:'no-repeat',
                                    marginBottom:'10px',
                                    position:'relative'
                                });
                                ":"")."
								")."

								$(\"#".$input."Preview\").append(fileFrame);
								isHas = true;
							}
						}
						$(\"#".$input."Preview\").append('<div class=\"auto-height\"></div>');
					}
					catch(e){
					}
					if (!isHas){
						$(\"#".$input."Preview\").html(\"<li style='list-style:none;padding-top:5px;'>无</li>\");
					}
				}
				".$input."Preview();
				</script>
       ";
        return $html;
    }

    /**
     * 字符串解码
     */
}
