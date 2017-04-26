@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/office',request()) }}

@extends('layouts.backend')

@section('title', '新增机构管理')

@section('header')
@endsection

@section('content')
    <!-- statistics chart built with jQuery Flot -->
    <div class="table-wrapper products-table section">
        <div class="row-fluid head">
            <div class="span12">
                <h4 style="float:left;display: inline-block">新增机构信息</h4>
            </div>
        </div>

        @inject('systemPresenter', 'App\Presenters\SystemPresenter')
        <div class="row-fluid">
            <form name="create" action="/backend/office" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                @if(isset($currentOffice))
                    <input type="hidden" name="id" value="{{ $currentOffice->id }}"/>
                @endif
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span8 column">
                    <div class="field-box">
                        <label>所属上级机构:
                            @if(isset($parentOffice))
                                {{$parentOffice->name}} <input type="hidden" name="parent_id" value="{{$parentOffice->id}}"/><input type="hidden" name="parent_ids" value="{{$parentOffice->parent_ids}}"/>
                            @else
                                根目录 <input type="hidden" name="parent_id" value="0"/><input type="hidden" name="parent_ids" value="0,"/>
                            @endif
                        </label>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>机构名称:</label>
                        <input style="width:400px" class="span8" type="text" name="name" @if(isset($currentOffice)) value="{{$currentOffice->name}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>所属区域:</label>
                        <div class="btn-glow" id="selectArea"><i class="icon-plus"></i>请选择一个区域</div>
                        <label style="display: inline-block;" id="currentSelectArea">@if(isset($currentOffice)){{$currentOffice->area->name}}@endif</label>
                        <input type="hidden" name="area_id" @if(isset($currentOffice)) value="{{$currentOffice->area->id}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>机构类型:</label>
                        @if(isset($currentOffice))
                            {!! $systemPresenter->getDictLabel('sys_office_type','type',400,$currentOffice->type) !!}
                        @else
                            {!! $systemPresenter->getDictLabel('sys_office_type','type',400) !!}
                        @endif
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>当前排序:</label>
                        <input style="width:400px" class="span8" type="text" name="sort" @if(isset($currentOffice)) value="{{$currentOffice->sort}}" @endif  @if(isset($sort)) value="{{$sort}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>机构地址:</label>
                        <input style="width:400px" class="span8" type="text" name="address" @if(isset($currentOffice)) value="{{$currentOffice->address}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>机构电话:</label>
                        <input style="width:400px" class="span8" type="text" name="phone" @if(isset($currentOffice)) value="{{$currentOffice->phone}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>机构邮箱:</label>
                        <input style="width:400px" class="span8" type="text" name="email" @if(isset($currentOffice)) value="{{$currentOffice->email}}" @endif/>
                        <div class="auto-height"></div>
                    </div><div class="field-box">
                        <label>机构传真:</label>
                        <input style="width:400px" class="span8" type="text" name="fax" @if(isset($currentOffice)) value="{{$currentOffice->fax}}" @endif/>
                        <div class="auto-height"></div>
                    </div>

                    <div class="field-box">
                        <label>邮编:</label>
                        <input style="width:400px" class="span8" type="text" name="code" @if(isset($currentOffice)) value="{{$currentOffice->code}}" @endif/>
                    </div>
                    <div class="field-box">
                        <label>备注:</label>
                        <textarea style="width:400px" name="remarks" rows="4">@if(isset($currentOffice)){{$currentOffice->remarks}}@endif</textarea>
                    </div>
                </div>
            </div>
                @if(isset($currentOffice))
                    <button type="button" class="btn-glow inverse" id="editBtn">确定修改</button>
                @else
                    <button type="button" class="btn-glow inverse" id="addBtn">确定添加</button>
                @endif
                <a class="btn-glow" href="/backend/office">返回</a>
            </form>
        </div>
    </div>
    <div id="select-area" style="display:none;">
        <div id="treeTable" class="ztree">

        </div>
    </div>
    <script type="application/javascript">
        $('#addBtn').click(function(){

            $.post('/backend/office/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，创建成功。', '创建成功！');
                    window.location.href = '/backend/office';
                }else{
                    $.jBox.messager('非常抱歉，系统或网络发生异常，请重试!', '创建失败！');
                }
            }).error(function(data) {
                eval('var d ='+data.responseText+';');
                var props = '';

                for ( var p in d ){ // 方法
                    if ( typeof ( d [ p ]) == " function " ){
                        d [ p ]() ;
                    } else { // p 为属性名称，obj[p]为对应属性的值
                        props += d [ p ] + " <br/> " ;
                    }
                } // 最后显示所有的属性

                $.jBox.messager(props, '创建失败！');
            });
        });

        $('#editBtn').click(function(){
            $.post('/backend/office/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，修改成功。', '修改成功！');
                    window.location.href = '/backend/office';
                }else{
                    $.jBox.messager('非常抱歉，系统或网络发生异常，请重试!', '修改失败！');
                }
            }).error(function(data) {
                eval('var d ='+data.responseText+';');
                var props = '';

                for ( var p in d ){ // 方法
                    if ( typeof ( d [ p ]) == " function " ){
                        d [ p ]() ;
                    } else { // p 为属性名称，obj[p]为对应属性的值
                        props += d [ p ] + " <br/> " ;
                    }
                } // 最后显示所有的属性

                $.jBox.messager(props, '创建失败！');
            });
        });

        var setting = {
            view: {
                selectedMulti: false
            },
            async: {
                enable: true,
                url: "/backend/findareabypid?_token={{ csrf_token() }}",
                autoParam: ["id=parent_id"],
                dataFilter: ajaxDataFilter
            },
            callback: {
                onClick: zTreeOnClick,
                onAsyncSuccess: zTreeOnAsyncSuccess
            },
            data:{
                simpleData:{enable:true,idKey:"id",pIdKey:"parent_id",rootPId:'0'}
            }
        };
        var currentFolder = $('#currentFolder').val();
        var treeObj;

        function zTreeOnAsyncSuccess(event, treeId, treeNode, msg) {
        };

        function ajaxDataFilter(treeId, parentNode, responseData) {
            return responseData;
        };

        function zTreeOnClick(event, treeId, treeNode) {
            $('#currentSelectArea').text(treeNode.name);
            $('input[name="area_id"]').val(treeNode.id);
        }

        function refreshTree(){
            var data = {!! $list !!};
            treeObj = $.fn.zTree.init($(".jbox-content #treeTable"), setting,data);

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


        $('#selectArea').click(function(){
            $.jBox.prompt($('#select-area').html(), '请选择一个区域', { },{width: 400,height:600,loaded:function(){
                refreshTree();
            }});
        });
    </script>

@endsection
