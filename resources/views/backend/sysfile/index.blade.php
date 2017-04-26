@inject('userUtil', 'App\Presenters\UserPresenter')
@if(request()->get('type')=='images')
    {{ $userUtil->getParentIdsByUrl('/backend/sysfile?type=images',request()) }}
@else
    {{ $userUtil->getParentIdsByUrl('/backend/sysfile?type=files',request()) }}
@endif


@extends('layouts.backend')

@section('title', '图片管理')

@section('header')
    <h1>
        Home
        <small>Moell Blog</small>
    </h1>
@endsection

@section('content')
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
                                url: '/backend/filestore?dir=images&_token={{ csrf_token() }}',
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
                    });
                    $.getJSON('/backend/getfiles',{
                        file_cate_id:$('#currentFolder').val()
                        ,page:1
                        ,type:'image'
                    },function(data){
                        $('.pagination').html(data.pageHtml);
                        imagesManage.load(data.sysFiles.data);
                    });

                    //如果是弹出框要加入选取后调用父级函数赋值
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
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
