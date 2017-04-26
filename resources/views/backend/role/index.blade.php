@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/role',request()) }}

@extends('layouts.backend')

@section('title', '角色管理')

@section('header')
@endsection

@section('content')
    @include('backend.common')
    @inject('systemPresenter', 'App\Presenters\SystemPresenter')
    <!-- statistics chart built with jQuery Flot -->
    <div class="table-wrapper products-table section">
        <div class="row-fluid head">
            <div class="span12">
                <h4 style="float:left;display: inline-block">角色管理</h4>
            </div>
        </div>

        <div class="row-fluid filter-block">
            <form name="create" action="/backend/dict" method="get">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="pull-right">
                    角色范围：{!! $systemPresenter->getDictLabel('sys_data_scope','user_type',160) !!}
                    <button type="submit" class="btn-glow"><i class="icon-search"></i> 搜索</button>
                    <a href="/backend/role/create" ><div class="btn-glow"><i class="icon-plus"></i> 增加新角色</div></a>
                    <a href="javascript:void(0)" id="dels"><div class="btn-glow"><i class="icon-minus"></i> 删除所选</div></a>
                </div>
            </form>
        </div>

        <div class="row-fluid">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="span1">
                        <input type="checkbox" name="mainCheckbox">
                        角色名称
                    </th>
                    <th class="span1">
                        <span class="line"></span>所属部门
                    </th>
                    <th class="span1">
                        <span class="line"></span>角色英文名
                    </th>
                    <th class="span1">
                        <span class="line"></span>创建时间
                    </th>
                    <th class="span1">
                        <span class="line"></span>角色范围
                    </th>
                    <th class="span1">
                        <span class="line"></span>是否系统角色
                    </th>
                    <th class="span1">
                        <span class="line"></span>状态
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($roles as $key=>$role)
                    <tr>
                        <td>
                            <input type="checkbox" name="subCheckbox" roleId="{{$role->id}}">
                            <a href="/backend/dict?type={{$role->name}}" class="name">{{$role->name}}</a>
                        </td>
                        <td>
                            {{$role->office->name}}
                        </td>
                        <td>
                            {{$role->enname}}
                        </td>
                        <td>
                            {{$role->create_date}}
                        </td>
                        <td>
                            {!! $systemPresenter->queryDictLabel('sys_data_scope',$role->data_scope) !!}
                        </td>
                        <td>
                            {!! $systemPresenter->queryDictLabel('yes_no',$role->is_sys) !!}
                        </td>
                        <td>
                            <span class="label label-success">有效</span>
                            <ul class="actions">
                                <li><a href="/backend/role/edit?id={{$role->id}}">编辑</a></li>
                                <li class="last"><a href="javascript:void(0)" onclick="javascript:delRole('{{$role->id}}')">删除</a></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {{$roles->render()}}
                <h6 style="float:left;display: inline">共{{$roles->lastPage()}}页/</h6>
                <h6 style="float:left;display: inline">{{$roles->total()}}条记录　</h6>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        function delRole(id) {
            var submit = function (v, h, f) {
                if (v == 'ok'){
                    $.ajax({
                        type:'post',
                        url:'/backend/role/delete?id='+id+'&_token={{ csrf_token() }}',
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
            $.jBox.confirm("确定要删除该角色吗？", "提示", submit);
        }

        $('input[name="mainCheckbox"]').click(function(){
            $('input[name="subCheckbox"]').each(function(){
                if($('input[name="mainCheckbox"]').is(':checked')){
                    $(this).prop('checked',true);
                    $(this).parent().addClass('checked');
                }else{
                    $(this).prop('checked',false);
                    $(this).parent().removeClass('checked');
                }
            });
        });

        $('input[name="subCheckbox"]').click(function(){
            //有一个为假总的就为假
            var checkbox = true;
            $('input[name="subCheckbox"]').each(function(){
                if(!$(this).prop('checked')){
                    checkbox = false;
                }
            });
            $('input[name="mainCheckbox"]').prop('checked',checkbox);
            if(checkbox){
                $('input[name="mainCheckbox"]').parent().addClass('checked');
            }else{
                $('input[name="mainCheckbox"]').parent().removeClass('checked');
            }
        });

        $('#dels').click(function(){
            var submit = function (v, h, f) {
                if (v == 'ok'){
                    var ids = '';
                    $('input[name="subCheckbox"]').each(function(){
                        if($(this).parent().hasClass('checked')){
                            ids += $(this).attr('roleId')+'|';
                        }
                    });

                    if(ids==''){
                        $.jBox.messager('请选择至少一项后才能删除', '提示');
                        return true;
                    }

                    $.ajax({
                        type:'post',
                        url:'/backend/role/delete?id='+ids+'&_token={{ csrf_token() }}',
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
            $.jBox.confirm("确定要删除选择的所有角色吗？", "提示", submit);
        });
    </script>
@endsection
