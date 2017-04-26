@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/role',request()) }}

@extends('layouts.backend')

@section('title', '新增角色管理')

@section('header')
    <h1>
        Home
        <small>Moell Blog</small>
    </h1>
@endsection

@section('content')
    <!-- statistics chart built with jQuery Flot -->
    <div class="table-wrapper products-table section">
        <div class="row-fluid head">
            <div class="span12">
                <h4 style="float:left;display: inline-block">新增角色信息</h4>
            </div>
        </div>

        @inject('systemPresenter', 'App\Presenters\SystemPresenter')
        <div class="row-fluid">
            <form name="create" action="/backend/role" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                @if(isset($role))
                    <input type="hidden" name="id" value="{{ $role->id }}"/>
                @endif
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span8 column">
                    <div class="field-box">
                        <label>所属机构:</label>
                        <select style="width:400px" class="select2" name="office_id">
                            <option />
                            @foreach($offices as $key=>$office)
                                <option value="{{$office->id}}" @if(isset($role) && $role->office_id==$office->id) selected="" @endif/>{{$office->name}}
                                @foreach($office->children as $childOffices)
                                    <option value="{{$childOffices->id}}" @if(isset($role) && $role->office_id==$childOffices->id) selected="" @endif/>{{$office->name}}>{{$childOffices->name}}
                                    @foreach($childOffices->children as $childChildOffices)
                                        <option value="{{$childChildOffices->id}}" @if(isset($role) && $role->office_id==$childChildOffices->id) selected="" @endif/>{{$office->name}}>{{$childOffices->name}}>{{$childChildOffices->name}}
                                        @foreach($childChildOffices->children as $childChildChildOffices)
                                            <option value="{{$childChildChildOffices->id}}" @if(isset($role) && $role->office_id==$childChildChildOffices->id) selected="" @endif/>{{$office->name}}>{{$childOffices->name}}>{{$childChildOffices->name}}>{{$childChildChildOffices->name}}
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>角色名:</label>
                        <input style="width:400px" class="span8" type="text" name="name" @if(isset($role)) value="{{$role->name}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>角色英文名:</label>
                        <input style="width:400px" class="span8" type="text" name="enname" @if(isset($role)) value="{{$role->enname}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>角色权限范围:</label>
                        @if(isset($role))
                            {!! $systemPresenter->getDictLabel('sys_data_scope','data_scope',400,$role->data_scope) !!}
                        @else
                            {!! $systemPresenter->getDictLabel('sys_data_scope','data_scope',400) !!}
                        @endif
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>角色菜单:</label>
                        <div class="span8">
                            <div id="menuTree" class="ztree" style="margin-top:3px;float:left;"></div>
                            <script type="application/javascript">
                                var setting = {check:{enable:true,nocheckInherit:true},view:{selectedMulti:false},
                                    data:{simpleData:{enable:true}},callback:{beforeClick:function(id, node){
                                        tree.checkNode(node, !node.checked, true, true);
                                        return false;
                                    }}};

                                // 用户-菜单
                                var zNodes=[
                                    @foreach($sysmenus as $key=>$menu)
                                        {
                                            id:"{{$menu->id}}",
                                            @if(empty($menu->parent_id)) pId:"0"
                                            @else pId:"{{$menu->parent_id}}"
                                            @endif,
                                            name:"@if(empty($menu->parent_id))权限列表@else{{$menu->name}}@endif"
                                            @if(!empty($menu->checked))
                                                ,checked:{{$menu->checked}}
                                            @endif
                                        },
                                    @endforeach
                                ];
                                // 初始化树结构
                                var tree = $.fn.zTree.init($("#menuTree"), setting, zNodes);
                                // 不选择父节点
                                tree.setting.check.chkboxType = { "Y" : "ps", "N" : "s" };
                                // 默认选择节点
                                var ids = "${role.menuIds}".split(",");
                                for(var i=0; i<ids.length; i++) {
                                    var node = tree.getNodeByParam("id", ids[i]);
                                    try{tree.checkNode(node, true, false);}catch(e){}
                                }
                                // 默认展开全部节点
                                tree.expandAll(true);
                            </script>
                        </div>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>是否是系统角色:</label>
                        <div class="span8">
                            <label class="radio">
                                <input type="radio" name="is_sys" id="optionsRadios1" value="1" @if(isset($role)) @if($role->is_sys==1) checked="" @endif  @else checked="" @endif/>是
                            </label>
                            <label class="radio">
                                <input type="radio" name="is_sys" id="optionsRadios2" value="0" @if(isset($role) && $role->is_sys==0) checked="" @endif/>否
                            </label>
                        </div>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>备注:</label>
                        <textarea style="width:400px" name="remarks" rows="4">@if(isset($role)) {{$role->remarks}} @endif</textarea>
                    </div>
                </div>
            </div>
                @if(isset($role))
                    <button type="button" class="btn-glow inverse" id="editRoleBtn">确定修改</button>
                @else
                    <button type="button" class="btn-glow inverse" id="addRoleBtn">确定添加</button>
                @endif
                <a class="btn-glow" href="/backend/role">返回</a>
            </form>
        </div>
    </div>
    <script type="application/javascript">
        $('#addRoleBtn').click(function(){
            var nodes = tree.getCheckedNodes(true);
            var menuIds = '';
            for(var i=0;i<nodes.length;i++){
                if(i==nodes.length-1)
                    menuIds+= nodes[i].id;
                else
                    menuIds+= nodes[i].id+',';
            }

            $.post('/backend/role/store?menuIds='+menuIds,$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，创建成功。', '创建成功！');
                    window.location.href = '/backend/role';
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

        $('#editRoleBtn').click(function(){
            var nodes = tree.getCheckedNodes(true);
            var menuIds = '';
            for(var i=0;i<nodes.length;i++){
                if(i==nodes.length-1)
                    menuIds+= nodes[i].id;
                else
                    menuIds+= nodes[i].id+',';
            }

            $.post('/backend/role/store?menuIds='+menuIds,$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，修改成功。', '修改成功！');
                    window.location.href = '/backend/role';
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

    </script>

@endsection
