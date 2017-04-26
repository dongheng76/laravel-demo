@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/area',request()) }}

@extends('layouts.backend')

@section('title', '区域管理')

@section('header')
    <h1>
        Home
        <small>Moell Blog</small>
    </h1>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/tables.css') }}" type="text/css" media="screen" />
    <style type="text/css">
        .ztree {overflow:auto;margin:0;_margin-top:10px;padding:10px 0 10px 10px;}
        .ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}
    </style>
    <!-- statistics chart built with jQuery Flot -->
    <div class="table-wrapper products-table section">
        <div class="row-fluid head">
            <div class="span12">
                <h4>区域管理</h4>
            </div>
        </div>
        <div id="treeTable" class="ztree">

        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                /* var tpl = $("#treeTableTpl").html().replace(/(\/\/\<!\-\-)|(\/\/\-\->)/g,"");
                 var data = ${fns:toJson(list)}, rootId = "0";
                 addRow("#treeTableList", tpl, data, rootId, true);
                 $("#treeTable").treeTable({expandLevel : 5}); */
                var setting = {
                    view: {
                        addHoverDom: addHoverDom,
                        removeHoverDom: removeHoverDom,
                        selectedMulti: false
                    },
                    async: {
                        enable: true,
                        url: "/backend/findareabypid?_token={{ csrf_token() }}",
                        autoParam: ["id=parent_id"],
                        dataFilter: ajaxDataFilter
                    },
                    edit: {
                        enable: true,
                        editNameSelectAll: false,
                        showRemoveBtn: showRemoveBtn,
                        showRenameBtn: showRenameBtn
                    },
                    callback: {
                        onClick: zTreeOnClick,
                        beforeDrag: beforeDrag,
                        beforeEditName: beforeEditName,
                        beforeRemove: beforeRemove,
                        onRemove: onRemove,
                        onAsyncSuccess: zTreeOnAsyncSuccess
                    },
                    data:{
                        simpleData:{enable:true,idKey:"id",pIdKey:"parent_id",rootPId:'0'}
                    }
                };
                var currentFolder = $('#currentFolder').val();
                var className = "dark";
                var treeObj;

                function zTreeOnAsyncError(event, treeId, treeNode, XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest);

                    console.log(event);
                    /* var treeObj = $.fn.zTree.getZTreeObj(treeId);
                     var nodes = treeObj.getSelectedNodes();
                     alert(nodes.length); */
                };
                function zTreeOnAsyncSuccess(event, treeId, treeNode, msg) {
                };

                function ajaxDataFilter(treeId, parentNode, responseData) {
                    return responseData;
                };
                function beforeDrag(treeId, treeNodes) {
                    return false;
                }
                function beforeRemove(treeId, treeNode) {
                    className = (className === "dark" ? "":"dark");
                    var zTree = $.fn.zTree.getZTreeObj("treeTable");
                    zTree.selectNode(treeNode);

                    top.$.jBox.confirm("确认要删除"+treeNode.name+"吗？","系统提示",function(v,h,f){
                        if(v=="ok"){
                            $.ajax({
                                type:'post',
                                url:'/backend/area/delete?id='+treeNode.id+'&_token={{ csrf_token() }}',
                                dataType:'json',
                                success:function(data){
                                    if(data.result){
                                        $.jBox.messager('感谢您的使用，删除成功。', '删除成功！');
                                        window.location.reload();
                                    }else{
                                        $.jBox.messager('非常抱歉，系统或网络发生异常，请重试!', '修改失败！');
                                    }
                                }
                            });
                        }
                    },{buttonsFocus:1});
                    top.$('.jbox-body .jbox-icon').css('top','55px');
                    return false;
                }
                function onRemove(e, treeId, treeNode) {

                }
                function beforeEditName(treeId, treeNode, newName) {
                    window.location.href = '/backend/area/edit?id='+treeNode.id;
                    return false;
                }
                function onRename(e, treeId, treeNode) {
                }
                function showRemoveBtn(treeId, treeNode) {
                    return treeNode.id!=1;
                }
                function showRenameBtn(treeId, treeNode) {
                    return true;
                }
                function zTreeOnClick(event, treeId, treeNode) {

                }

                var newCount = 1;
                function addHoverDom(treeId, treeNode) {
                    var sObj = $("#" + treeNode.tId + "_span");
                    if (treeNode.editNameFlag || $("#addBtn_"+treeNode.id).length>0) return;
                    var addStr = "<span class='button add' id='addBtn_" + treeNode.id + "' title='add node' onfocus='this.blur();'></span>";
                    sObj.after(addStr);
                    var addBtn = $("#addBtn_"+treeNode.id);
                    if (addBtn) addBtn.bind("click", function(){
                        window.location.href = '/backend/area/create?parent_id='+treeNode.id;
                    });
                };

                function removeHoverDom(treeId, treeNode) {
                    $("#addBtn_"+treeNode.id).unbind().remove();
                };

                function refreshTree(){
                    var data = {!! $list !!};
                    treeObj = $.fn.zTree.init($("#treeTable"), setting,data);

                    //如果默认一级大于1个就不进行节点展开了
                    if(data.length<=1){
                        // 默认展开一级节点
                        var nodes = treeObj.getNodesByParam("level", 0);
                        for(var i=0; i<nodes.length; i++) {
                            treeObj.expandNode(nodes[i], true, false, false);
                        }
                        //异步加载子节点（加载用户）
                        var nodesOne = treeObj.getNodesByParam("isParent", true);
                        for(var j=0; j<nodesOne.length; j++) {
                            treeObj.reAsyncChildNodes(nodesOne[j],"!refresh",true);
                        }
                    }
                }
                refreshTree();
            });
        </script>
    </div>
@endsection