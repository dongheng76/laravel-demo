<!-- bootstrap -->
<link href="{{ asset('bootstrapui/css/bootstrap/bootstrap.css') }}" rel="stylesheet" />
<link href="{{ asset('bootstrapui/css/bootstrap/bootstrap-responsive.css') }}" rel="stylesheet" />
<link href="{{ asset('bootstrapui/css/bootstrap/bootstrap-overrides.css') }}" type="text/css" rel="stylesheet" />

<!-- libraries -->
<link href="{{ asset('bootstrapui/css/lib/jquery-ui-1.10.2.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('bootstrapui/css/lib/font-awesome.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('bootstrapui/css/lib/bootstrap-wysihtml5.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('bootstrapui/css/lib/uniform.default.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('bootstrapui/css/lib/select2.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('bootstrapui/css/lib/bootstrap.datepicker.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('bootstrapui/css/lib/font-awesome.css') }}" type="text/css" rel="stylesheet" />

<!-- this page specific styles -->
<link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/form-showcase.css') }}" type="text/css" media="screen" />
<link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/tables.css') }}" type="text/css" media="screen" />


<!-- global styles -->
<link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/layout.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/elements.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/icons.css') }}" />

<!-- jstree -->
<link href="{{ asset('ztree/3.5.12/css/zTreeStyle/zTreeStyle.min.css') }}" rel="stylesheet" type="text/css"/>

<!-- this page specific styles -->
<link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/index.css') }}" type="text/css" media="screen" />

{{--<!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />--}}

    <!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- scripts -->
<script src="{{ asset('bootstrapui/js/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('bootstrapui/js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('bootstrapui/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrapui/js/bootstrap-wysihtml5-0.0.2.js') }}"></script>
<script src="{{ asset('bootstrapui/js/jquery-ui-1.10.2.custom.min.js') }}"></script>
<script src="{{ asset('bootstrapui/js/common.js') }}"></script>

<script src="{{ asset('bootstrapui/js/bootstrap.datepicker.js') }}"></script>
<script src="{{ asset('bootstrapui/js/jquery.uniform.min.js') }}"></script>
<script src="{{ asset('bootstrapui/js/select2.min.js') }}"></script>
<!-- knob -->
<script src="{{ asset('bootstrapui/js/jquery.knob.js') }}"></script>
<!-- flot charts -->
<script src="{{ asset('bootstrapui/js/jquery.flot.js') }}"></script>
<script src="{{ asset('bootstrapui/js/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('bootstrapui/js/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('bootstrapui/js/theme.js') }}"></script>

<!-- jstree -->
<script src="{{ asset('ztree/3.5.12/js/jquery.ztree.all-3.5.min.js') }}" type="text/javascript"></script>

<!-- Generic page styles -->
<link rel="stylesheet" href="{{ asset('jqueryFileUpload/css/jquery.fileupload.css') }}">
<script src="{{ asset('jqueryFileUpload/js/vendor/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('jqueryFileUpload/js/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('jqueryFileUpload/js/jquery.fileupload.js') }}"></script>

<!-- 相册管理器 -->
<link href="{{ asset('imagesManage/css/jquery.imageManage.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('imagesManage/css/jquery.contextMenu.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('imagesManage/css/viewer.css') }}" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="{{ asset('imagesManage/js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('imagesManage/js/viewer.js') }}"></script>
<script type="text/javascript" src="{{ asset('imagesManage/js/jquery.ui.position.js') }}"></script>
<script type="text/javascript" src="{{ asset('imagesManage/js/jquery.contextMenu.js') }}"></script>
<script type="text/javascript" src="{{ asset('imagesManage/js/jquery.imagesManage.js') }}"></script>

<!-- 编辑器 -->
<script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.config.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.all.js') }}"> </script>
<!-- H5编辑器 -->
<link href="{{ asset('squire/css/color.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('squire/css/squire.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('squire/css/stylesheet.css') }}" type="text/css" rel="stylesheet" />
<script type="text/javascript" charset="utf-8" src="{{ asset('squire/js/colorpicker.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('squire/js/squire-raw.js') }}"></script>
<!-- 编辑器 -->
<script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.config.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.all.js') }}"> </script>

<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/lang/zh-cn/zh-cn.js') }}"></script>

<link href="{{ asset('jquery-jbox/2.3/Skins/Bootstrap/jbox.min.css') }}" rel="stylesheet" />
<script src="{{ asset('jquery-jbox/2.3/jquery.jBox-2.3.min.js') }}" type="text/javascript"></script>
<style type="text/css">
    .section{padding-top:0;margin-top:0;}
    body{background-color:#FFFFFF;}
</style>

<body>
@include('backend.common')
<style type="text/css">
    .ztree {overflow:auto;margin:0;_margin-top:10px;padding:10px 0 0 10px;}
    .ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}
</style>
<!-- statistics chart built with jQuery Flot -->
<div class="table-wrapper products-table section">
    <div id="content" class="row-fluid">
        <div id="left" class="accordion-group" style="width:200px;height:100%;">
            <div class="accordion-heading">
                <a class="accordion-toggle">用户@if(request()->get('type')=='images') 图片@else 文件夹 @endif<i class="icon-refresh pull-right" onclick="refreshTree();"></i></a>
            </div>
            <div id="ztree" class="ztree"></div>
        </div>
        <div id="openClose" class="close">&nbsp;</div>
        <div id="right" style="overflow-y:auto;">
            <ul class="nav nav-tabs">
                <li class="active"><a href="${ctx}/sys/user/list">@if(request()->get('type')=='images') 图片@else 文件 @endif管理</a></li>
            </ul>
            <div class="content-ui">
                <form id="searchForm" modelAttribute="user" action="/backend/sysfile?type=images" method="get" class="breadcrumb form-search">
                    <input id="page" name="page" type="hidden"/>
                    <input id="isDialog" name="isDialog" type="hidden"/>
                    <input id="func" name="func" type="hidden"/>
                    <input id="format" name="format" type="hidden"/>

                    <input id="currentFolder" name="currentFolder" value="" type="hidden"/>

					<span class="btn btn-success fileinput-button">
				        <i class="glyphicon glyphicon-plus"></i>
				        <span>上传@if(request()->get('type')=='images') 图片@else 文件 @endif</span>
                        <!-- The file input field used as target for the file upload widget -->

				        <input id="fileupload" type="file" name="file" multiple >
				    </span>

                    <li class="clearfix"></li>
                </form>
                <div id="imagesManage">

                </div>
            </div>
            <div class="pagination" style="margin-left:10px;"></div>
        </div>
    </div>

    <div class="modal hide fade" id="createFolder" tabindex="-1" role="dialog">
        <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal">×</button>
            <h5 id="createFolderLabel">请输入新建文件夹名</h5>
        </div>
        <div class="modal-body">
            <div class="breadcrumb form-search">
                <input type="hidden" name="currentFolder" id="currentParentFolder"/>
                <input type="hidden" name="parentIds" id="parentIds"/>
                <ul class="ul-form">
                    <li><label>目录名称：</label><input id="NewFolderName" name="NewFolderName" type="text" value=""/></li>
                    <li class="clearfix"></li>
                </ul>
            </div>
            <div class="form-actions" style="margin-bottom:0;">
                <input id="btnSubmit" class="btn btn-primary" type="submit" value="确定"/>
                <input id="btnCancel" class="btn" type="button" value="取消"/>
            </div>
            <script type="text/javascript">
                $('#btnSubmit').click(function(){
                    if($('#NewFolderName').val()!=null){
                        $.getJSON('/backend/mkdir?type=images',{
                            parent_id:$('#currentParentFolder').val(),
                            name:$('#NewFolderName').val(),
                            parent_ids:$('#parentIds').val(),
                            _token:'{{ csrf_token() }}'
                        },function(data){
                            if(data.result)
                                refreshTree();
                        });
                    }

                    $('#createFolder').modal('hide');
                });
                $('#btnCancel').click(function(){
                    $('#createFolder').modal('hide');
                });
            </script>
            <script type="text/javascript">
                function page(n){
                    $.getJSON('/backend/getfiles',{
                        file_cate_id:$('#currentFolder').val()
                        ,page:n
                        ,type:'image'
                    },function(data){
                        $('.pagination').html(data.pageHtml);
                        imagesManage.load(data.sysFiles.data);
                    });
                }

                var setting = {
                    view: {
                        addHoverDom: addHoverDom,
                        removeHoverDom: removeHoverDom,
                        selectedMulti: false
                    },
                    edit: {
                        enable: true,
                        editNameSelectAll: true,
                        showRemoveBtn: showRemoveBtn,
                        showRenameBtn: showRenameBtn
                    },
                    callback: {
                        onClick: zTreeOnClick,
                        beforeDrag: beforeDrag,
                        beforeRemove: beforeRemove,
                        beforeRename: beforeRename,
                        onRemove: onRemove,
                        onRename: onRename
                    },
                    data:{
                        simpleData:{enable:true,idKey:"id",pIdKey:"parent_id",rootPId:'%'}
                    }
                };
                var currentFolder = $('#currentFolder').val();
                var className = "dark";
                function beforeDrag(treeId, treeNodes) {
                    return false;
                }
                function beforeRemove(treeId, treeNode) {
                    className = (className === "dark" ? "":"dark");
                    var zTree = $.fn.zTree.getZTreeObj("ztree");
                    zTree.selectNode(treeNode);

                    $.jBox.confirm("确认要删除"+treeNode.name+"吗？","系统提示",function(v,h,f){
                        if(v=="ok"){
                            $.getJSON('/backend/dirdel',{
                                id:treeNode.id,
                                _token:'{{ csrf_token() }}'
                            },function(data){
                                refreshTree();
                            });
                        }
                    },{buttonsFocus:1});
                    top.$('.jbox-body .jbox-icon').css('top','55px');
                    return false;
                }
                function onRemove(e, treeId, treeNode) {

                }
                function beforeRename(treeId, treeNode, newName) {
                    className = (className === "dark" ? "":"dark");
                    if (newName.length == 0) {
                        alert("节点名称不能为空.");
                        var zTree = $.fn.zTree.getZTreeObj("ztree");
                        setTimeout(function(){zTree.editName(treeNode)}, 10);
                        return false;
                    }
                    return true;
                }
                function onRename(e, treeId, treeNode) {

                }
                function showRemoveBtn(treeId, treeNode) {
                    return treeNode.id!=0;
                }
                function showRenameBtn(treeId, treeNode) {
                    return false;
                }
                function zTreeOnClick(event, treeId, treeNode) {
                    currentFolder = treeNode.id;
                    $('#currentFolder').val(treeNode.id);

                    $.getJSON('/backend/getfiles',{
                        file_cate_id:treeNode.id
                        ,page:1
                        ,type:'image'
                    },function(data){
                        $('.pagination').html(data.pageHtml);
                        imagesManage.load(data.sysFiles.data);
                    });
                }

                var newCount = 1;
                function addHoverDom(treeId, treeNode) {
                    var sObj = $("#" + treeNode.tId + "_span");
                    if (treeNode.editNameFlag || $("#addBtn_"+treeNode.id).length>0) return;
                    var addStr = "<span class='button add' id='addBtn_" + treeNode.id + "' title='add node' onfocus='this.blur();'></span>";
                    sObj.after(addStr);
                    var btn = $("#addBtn_"+treeNode.id);
                    if (btn) btn.bind("click", function(){
                        $('#createFolder').modal('show');
                        $('#currentParentFolder').val(treeNode.id);
                        $('#NewFolderName').val("");
                        $('#parentIds').val(treeNode.parentIds);
                    });
                };

                function removeHoverDom(treeId, treeNode) {
                    $("#addBtn_"+treeNode.id).unbind().remove();
                };

                function refreshTree(){
                    $.getJSON("/backend/getfolders",{
                                type:'image'
                            }
                            ,function(data){
                                var treeObj = $.fn.zTree.init($("#ztree"), setting, data.sysFileCates.data);
                                treeObj.expandAll(true);
                                var nodes = treeObj.transformToArray(treeObj.getNodes());

                                for(var i=0;i<nodes.length;i++){
                                    if(nodes[i].id==$('#currentFolder').val()){
                                        treeObj.selectNode(nodes[i]);
                                    }
                                }
                            });
                }
                refreshTree();

                var leftWidth = 180; // 左侧窗口大小
                var htmlObj = $("html"), mainObj = $("#main");
                var frameObj = $("#left, #openClose, #right, #right iframe");
                function wSize(){
                    var strs = getWindowSize().toString().split(",");
                    htmlObj.css({"overflow-x":"hidden", "overflow-y":"hidden"});
                    mainObj.css("width","auto");

                    frameObj.height(strs[0] - 5);
                    var leftWidth = ($("#left").width() < 0 ? 0 : $("#left").width());
                    $("#right").width($("#content").width()- leftWidth - $("#openClose").width() -5);
                    $(".ztree").width(leftWidth - 10).height(frameObj.height() - 46);
                }

                $('#fileupload').fileupload({
                            url: '/backend/filestore?dir=images&_token={{ csrf_token() }}&format={{$format}}',
                            dataType: 'json',
                            autoUpload: true,
                            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                            disableImageMetaDataLoad: true,
                            done: function (e, data) {
                                //if(!data.status)top.$.jBox.tip(data.result.Connector.FileUpload.failReason, 'error');

                                $.getJSON('/backend/getfiles',{
                                    file_cate_id:currentFolder
                                    ,page:1
                                    ,type:'image'
                                },function(data){
                                    $('.pagination').html(data.pageHtml);
                                    imagesManage.load(data.sysFiles.data);
                                });
                            },
                            progressall: function (e, data) {
                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                $('#progress .progress-bar').css(
                                        'width',
                                        progress + '%'
                                );
                            }
                        })
                        .bind('fileuploadsubmit', function (e, data) {
                            data.formData = {file_cate_id: currentFolder};
                            //loading('正在上传文件中，请稍等...');
                        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');


                var imagesManage = $('#imagesManage').fileManage({
                    //imagePrefix : ctxImg,
                    callback : {
                        onclickMenu : function(key, selectData, selectElement) {
                            switch(key){
                                case 'download':
                                    var url = ctxStatic+'/ckfinder/core/connector/java/connector.java?command=DownloadFile&type=${type}&langCode=zh-cn&newFileName='+selectData[0].title+"."+selectData[0].suffix+'&FileName='+selectData[0].path+"."+selectData[0].suffix;
                                    window.open(url);
                                    break;
                                case 'delete':
                                    var fileIds = "";
                                    for(var i=0;i<selectData.length;i++){
                                        if(i<selectData.length-1){
                                            fileIds+=selectData[i].id+'|';
                                        }else{
                                            fileIds+=selectData[i].id;
                                        }
                                    }

                                    loading('正在删除文件中，请稍等...');
                                    $.getJSON('${ctxStatic}/ckfinder/core/connector/java/connector.java?command=DeleteFiles&type=${type}&langCode=zh-cn&startupPath=',{
                                        fileIds:fileIds
                                    },function(data){
                                        top.$.jBox.closeTip();
                                        if(data.Connector.DeleteFiles.result){
                                            window.location.reload();
                                        }else{
                                            top.$.jBox.tip(data.result.Connector.DeleteFiles.failReason, 'error');
                                        }
                                    });
                                    break;
                                case 'move':
                                    top.$.jBox('get:${ctx}/sys/user/fileCateSelect;JSESSIONID=<shiro:principal property="sessionid"/>?type=${type}',
                                            {title:'选择移动到的文件夹', buttons:{'确定':1,'关闭':0}, width:300, height: 350, top:30,
                                                submit: function (v, h, f) {
                                                    if (v == 1) {
                                                        var fileIds = "";
                                                        for(var i=0;i<selectData.length;i++){
                                                            if(i<selectData.length-1){
                                                                fileIds+=selectData[i].id+'|';
                                                            }else{
                                                                fileIds+=selectData[i].id;
                                                            }
                                                        }

                                                        loading('正在删除文件中，请稍等...');
                                                        $.getJSON('${ctxStatic}/ckfinder/core/connector/java/connector.java?command=MoveFiles&type=${type}&langCode=zh-cn&startupPath=',{
                                                            fileIds:fileIds,
                                                            fileCateId:top.currentFolder
                                                        },function(data){
                                                            top.$.jBox.closeTip();
                                                            if(data.Connector.MoveFiles.result){
                                                                window.location.reload();
                                                            }else{
                                                                top.$.jBox.tip(data.result.Connector.MoveFiles.failReason, 'error');
                                                            }
                                                        });
                                                        return true; // close the window
                                                    }
                                                    return true;
                                                }
                                            });

                                    break;
                            }
                        },
                        dblclick : function(e,selectData, selectElement) {
                        }
                    }
                    @if(isset($sm))
                        @if($sm==1)
                            ,multiSelect:true
                        @elseif($sm==0)
                            ,multiSelect:false
                        @endif
                    @endif
                });
                $.getJSON('/backend/getfiles',{
                    file_cate_id:$('#currentFolder').val()
                    ,page:1
                    ,type:'image'
                },function(data){
                    $('.pagination').html(data.pageHtml);
                    imagesManage.load(data.sysFiles.data);
                });

                $(window).keyup(function(e){
                    if(e.which==13){
                        goThumbnail();
                        return false;
                    }
                });
                $('#btnDialogSubmit').click(function(){
                    goThumbnail();
                    return false;
                });

                $('#btnDialogCancel').click(function(){
                    window.close();
                });

                function goThumbnail(){
                    if(imagesManage.getSelectedData().length<=0){
                        top.$.jBox.tip("请选择一个后再确定",'error');
                        return false;
                    }

                    var files = imagesManage.getSelectedData();
                    var ids = "";
                    for(var i=0; i<files.length; i++){
                        ids += files[i].id;
                        if (i<files.length-1){
                            ids+="|";
                        }
                    }

                    $.getJSON('/backend/imgzoom',
                    {
                        ids:ids,
                        format:'{{$format}}'
                    },function(data){
                        if(data.result){
                            opener.{{$func}}(imagesManage.getSelectedData());
                            window.close();
                        }
                    });
			    }
            </script>
        </div>
    </div>
</div>
</body>