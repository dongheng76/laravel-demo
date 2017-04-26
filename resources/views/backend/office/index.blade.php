@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/office',request()) }}

@extends('layouts.backend')

@section('title', '机构管理')

@section('header')
@endsection

@section('content')
    @include('backend.common')
    @inject('systemPresenter', 'App\Presenters\SystemPresenter')
    <!-- statistics chart built with jQuery Flot -->
    <div class="table-wrapper products-table section">
        <div class="row-fluid head">
            <div class="span12">
                <h4 style="float:left;display: inline-block">机构管理</h4>
            </div>
        </div>

        <div class="row-fluid filter-block">
            <form name="create" action="/backend/office" method="get">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="pull-right">
                    <a href="/backend/office/create" ><div class="btn-glow"><i class="icon-plus"></i> 增加新根机构</div>
                    </a>
                </div>
            </form>
        </div>

        <div class="row-fluid">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="span1">
                        机构名称
                    </th>
                    <th class="span1">
                        <span class="line"></span>所属区域
                    </th>
                    <th class="span1">
                        <span class="line"></span>创建时间
                    </th>
                    <th class="span1">
                        <span class="line"></span>机构类型
                    </th>
                    <th class="span1">
                        <span class="line"></span>当前排序
                    </th>
                    <th class="span1">
                        <span class="line"></span>邮编
                    </th>
                    <th class="span1">
                        <span class="line"></span>状态
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($offices as $key=>$office)
                    <tr class="treeNode" treeId="{{$office->id}}"  parentIds="{{$office->parent_ids}}">
                        <td>
                            <span arrow="true" class="default_active_node default_open"></span>
                            <a href="#" class="name">{{$office->name}}</a>
                        </td>
                        <td class="description">
                            @if(isset($office->area->parent->parent->parent->name)){{$office->area->parent->parent->parent->name}}-@endif
                            @if(isset($office->area->parent->parent->name)){{$office->area->parent->parent->name}}-@endif
                            @if(isset($office->area->parent->name)){{$office->area->parent->name}}-@endif{{$office->area->name}}
                        </td>
                        <td>
                            {{$office->create_date}}
                        </td>
                        <td>
                            {!! $systemPresenter->queryDictLabel('sys_office_type',$office->type) !!}
                        </td>
                        <td>
                            {{$office->sort}}
                        </td>
                        <td>
                            {{$office->code}}
                        </td>
                        <td>
                            <span class="label label-success">有效</span>
                            <ul class="actions">
                                <li><a href="/backend/office/create?parent_id={{$office->id}}">添加下级机构</a></li>
                                <li><a href="/backend/office/edit?id={{$office->id}}">编辑</a></li>
                                <li class="last"><a href="javascript:void(0)" onclick="javascript:delMenu('{{$office->id}}')">删除</a></li>
                            </ul>
                        </td>
                    </tr>
                    @foreach($office->children as $officeSub)
                        <tr class="treeNode" treeId="{{$officeSub->id}}" parentIds="{{$officeSub->parent_ids}}">
                            <td style="padding-left:30px;">
                                <span arrow="true" class="default_active_node default_open"></span>
                                <a href="#" class="name">{{$officeSub->name}}</a>
                            </td>
                            <td class="description">
                                @if(isset($officeSub->area->parent->parent->parent->name)){{$officeSub->area->parent->parent->parent->name}}-@endif
                                @if(isset($officeSub->area->parent->parent->name)){{$officeSub->area->parent->parent->name}}-@endif
                                @if(isset($officeSub->area->parent->name)){{$officeSub->area->parent->name}}-@endif{{$officeSub->area->name}}
                            </td>
                            <td>
                                {{$officeSub->create_date}}
                            </td>
                            <td>
                                {!! $systemPresenter->queryDictLabel('sys_office_type',$officeSub->type) !!}
                            </td>
                            <td>
                                {{$officeSub->sort}}
                            </td>
                            <td>
                                {{$officeSub->code}}
                            </td>
                            <td>
                                <span class="label label-success">有效</span>
                                <ul class="actions">
                                    <li><a href="/backend/office/create?parent_id={{$officeSub->id}}">添加下级机构</a></li>
                                    <li><a href="/backend/office/edit?id={{$officeSub->id}}">编辑</a></li>
                                    <li class="last"><a href="javascript:void(0)" onclick="javascript:delMenu('{{$officeSub->id}}')">删除</a></li>
                                </ul>
                            </td>
                        </tr>
                        @foreach($officeSub->children as $officeSubNext)
                            <tr class="treeNode" treeId="{{$officeSubNext->id}}" parentIds="{{$officeSubNext->parent_ids}}">
                                <td style="padding-left:60px;">
                                    <span arrow="true" class="default_active_node default_open"></span>
                                    <a href="#" class="name">{{$officeSubNext->name}}</a>
                                </td>
                                <td class="description">
                                    @if(isset($officeSubNext->area->parent->parent->parent->name)){{$officeSubNext->area->parent->parent->parent->name}}-@endif
                                    @if(isset($officeSubNext->area->parent->parent->name)){{$officeSubNext->area->parent->parent->name}}-@endif
                                    @if(isset($officeSubNext->area->parent->name)){{$officeSubNext->area->parent->name}}-@endif{{$officeSubNext->area->name}}
                                </td>
                                <td>
                                    {{$officeSubNext->create_date}}
                                </td>
                                <td>
                                    {!! $systemPresenter->queryDictLabel('sys_office_type',$officeSubNext->type) !!}
                                </td>
                                <td>
                                    {{$officeSubNext->sort}}
                                </td>
                                <td>
                                    {{$officeSubNext->code}}
                                </td>
                                <td>
                                    <span class="label label-success">有效</span>
                                    <ul class="actions">
                                        <li><a href="/backend/office/create?parent_id={{$officeSubNext->id}}">添加下级机构</a></li>
                                        <li><a href="/backend/office/edit?id={{$officeSubNext->id}}">编辑</a></li>
                                        <li class="last"><a href="javascript:void(0)" onclick="javascript:delMenu('{{$officeSubNext->id}}')">删除</a></li>
                                    </ul>
                                </td>
                            </tr>
                            @foreach($officeSubNext->children as $officeSubNextNext)
                                <tr class="treeNode" treeId="{{$officeSubNextNext->id}}" parentIds="{{$officeSubNextNext->parent_ids}}">
                                    <td style="padding-left:80px;">
                                        <a href="#" class="name">{{$officeSubNextNext->name}}</a>
                                    </td>
                                    <td class="description">
                                        @if(isset($officeSubNextNext->area->parent->parent->parent->name)){{$officeSubNextNext->area->parent->parent->parent->name}}-@endif
                                        @if(isset($officeSubNextNext->area->parent->parent->name)){{$officeSubNextNext->area->parent->parent->name}}-@endif
                                        @if(isset($officeSubNextNext->area->parent->name)){{$officeSubNextNext->area->parent->name}}-@endif{{$officeSubNextNext->area->name}}
                                    </td>
                                    <td>
                                        {{$officeSubNextNext->create_date}}
                                    </td>
                                    <td>
                                        {!! $systemPresenter->queryDictLabel('sys_office_type',$officeSubNextNext->type) !!}
                                    </td>
                                    <td>
                                        {{$officeSubNextNext->sort}}
                                    </td>
                                    <td>
                                        {{$officeSubNextNext->code}}
                                    </td>
                                    <td>
                                        <span class="label label-success">有效</span>
                                        <ul class="actions">
                                            <li><a href="/backend/office/edit?id={{$officeSubNextNext->id}}">编辑</a></li>
                                            <li class="last"><a href="javascript:void(0)" onclick="javascript:delMenu('{{$officeSubNextNext->id}}')">删除</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
                <!-- row -->
                </tbody>
            </table>
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
                                url:'/backend/office/delete?id='+id+'&_token={{ csrf_token() }}',
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
                    $.jBox.confirm("确定要删除该机构吗？", "提示", submit);
                }
            </script>
        </div>
    </div>
@endsection
