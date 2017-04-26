@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/menu',request()) }}

@extends('layouts.backend')

@section('title', '菜单管理')

@section('header')
    <h1>
        Home
        <small>Moell Blog</small>
    </h1>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/tables.css') }}" type="text/css" media="screen" />
    <!-- statistics chart built with jQuery Flot -->
    <div class="table-wrapper products-table section">
        <div class="row-fluid head">
            <div class="span12">
                <h4>菜单管理</h4>
            </div>
        </div>

        <div class="row-fluid filter-block">
            <div class="pull-right">
                <a href="/backend/menu/create" ><div class="btn-glow"><i class="icon-plus"></i> 增加新主菜单</div>
                </a>
            </div>
        </div>

        <div class="row-fluid">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="span2">
                        名称
                    </th>
                    <th class="span2">
                        <span class="line"></span>url
                    </th>
                    <th class="span1">
                        <span class="line"></span>排序
                    </th>
                    <th class="span2">
                        <span class="line"></span>权限
                    </th>
                    <th class="span2">
                        <span class="line"></span>操作
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($sysMenus as $key=>$sysMenu)
                    <tr class="treeNode" treeId="{{$sysMenu->id}}"  parentIds="{{$sysMenu->parent_ids}}">
                        <td>
                            <span arrow="true" class="default_active_node default_open"></span>
                            <a href="#" class="name">{{$sysMenu->name}}</a>
                        </td>
                        <td class="description">
                            {{$sysMenu->href}}
                        </td>
                        <td>
                            {{$sysMenu->sort}}
                        </td>
                        <td>
                            {{$sysMenu->permission}}
                        </td>
                        <td>
                            <span class="label label-success">有效</span>
                            <ul class="actions">
                                <li><a href="/backend/menu/create?parent_id={{$sysMenu->id}}">添加下级菜单</a></li>
                                <li><a href="/backend/menu/edit?id={{$sysMenu->id}}">编辑</a></li>
                                <li class="last"><a href="javascript:void(0)" onclick="javascript:delMenu('{{$sysMenu->id}}')">删除</a></li>
                            </ul>
                        </td>
                    </tr>
                    @foreach($sysMenu->children as $sysSubMenu)
                        <tr class="treeNode" treeId="{{$sysSubMenu->id}}" parentIds="{{$sysSubMenu->parent_ids}}">
                            <td style="padding-left:30px;">
                                <span arrow="true" class="default_active_node default_open"></span>
                                <a href="#" class="name">{{$sysSubMenu->name}}</a>
                            </td>
                            <td class="description">
                                {{$sysSubMenu->href}}
                            </td>
                            <td>
                                {{$sysSubMenu->sort}}
                            </td>
                            <td>
                                {{$sysSubMenu->permission}}
                            </td>
                            <td>
                                <span class="label label-success">有效</span>
                                <ul class="actions">
                                    <li><a href="/backend/menu/create?parent_id={{$sysSubMenu->id}}">添加下级菜单</a></li>
                                    <li><a href="/backend/menu/edit?id={{$sysSubMenu->id}}">编辑</a></li>
                                    <li class="last"><a href="javascript:void(0)" onclick="javascript:delMenu('{{$sysSubMenu->id}}')">删除</a></li>
                                </ul>
                            </td>
                        </tr>
                        @foreach($sysSubMenu->children as $sysSubNextMenu)
                            <tr class="treeNode" treeId="{{$sysSubNextMenu->id}}" parentIds="{{$sysSubNextMenu->parent_ids}}">
                                <td style="padding-left:60px;">
                                    <span arrow="true" class="default_active_node default_open"></span>
                                    <a href="#" class="name">{{$sysSubNextMenu->name}}</a>
                                </td>
                                <td class="description">
                                    {{$sysSubNextMenu->href}}
                                </td>
                                <td>
                                    {{$sysSubNextMenu->sort}}
                                </td>
                                <td>
                                    {{$sysSubNextMenu->permission}}
                                </td>
                                <td>
                                    <span class="label label-success">有效</span>
                                    <ul class="actions">
                                        <li><a href="/backend/menu/create?parent_id={{$sysSubNextMenu->id}}">添加下级菜单</a></li>
                                        <li><a href="/backend/menu/edit?id={{$sysSubNextMenu->id}}">编辑</a></li>
                                        <li class="last"><a href="javascript:void(0)" onclick="javascript:delMenu('{{$sysSubNextMenu->id}}')">删除</a></li>
                                    </ul>
                                </td>
                            </tr>
                            @foreach($sysSubNextMenu->children as $sysSubNextNextMenu)
                                <tr class="treeNode" treeId="{{$sysSubNextNextMenu->id}}" parentIds="{{$sysSubNextNextMenu->parent_ids}}">
                                    <td style="padding-left:80px;">
                                        <a href="#" class="name">{{$sysSubNextNextMenu->name}}</a>
                                    </td>
                                    <td class="description">
                                        {{$sysSubNextNextMenu->href}}
                                    </td>
                                    <td>
                                        {{$sysSubNextMenu->sort}}
                                    </td>
                                    <td>
                                        {{$sysSubNextNextMenu->permission}}
                                    </td>
                                    <td>
                                        <span class="label label-success">有效</span>
                                        <ul class="actions">
                                            <li><a href="/backend/menu/edit?id={{$sysSubNextNextMenu->id}}">编辑</a></li>
                                            <li class="last"><a href="javascript:void(0)" onclick="javascript:delMenu('{{$sysSubNextNextMenu->id}}')">删除</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
                </tbody>
                <script type="application/javascript">
                    $('table .default_active_node').click(function(){
                        var _parent = $(this).parent().parent();
                        var parentIds = _parent.attr('parentIds');
                        var id = _parent.attr('treeId');
                        var indexOfStr = (parentIds+id+',');

                        if($(this).hasClass('default_open')){
                            $(this).removeClass('default_open').addClass('default_shut');
                            $('.treeNode').each(function(){
                                if($(this).attr('parentIds').indexOf(indexOfStr)!=-1){
                                    $(this).hide();
                                }
                            });
                        }else{
                            $(this).removeClass('default_shut').addClass('default_open');
                            $('.treeNode').each(function(){
                                if($(this).attr('parentIds').indexOf(indexOfStr)!=-1){
                                    $(this).show();
                                }
                            });
                        }
                    });

                    function delMenu(id) {
                        var submit = function (v, h, f) {
                            if (v == 'ok'){
                                $.ajax({
                                    type:'post',
                                    url:'/backend/menu/delete?id='+id+'&_token={{ csrf_token() }}',
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
                            else if (v == 'cancel'){

                            }
                        };
                        $.jBox.confirm("确定要删除该菜单吗？", "提示", submit);
                    }
                </script>
            </table>
        </div>
    </div>
@endsection