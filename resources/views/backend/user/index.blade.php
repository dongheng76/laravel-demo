@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/user',request()) }}

@extends('layouts.backend')

@section('title', '用户管理')

@section('header')
    <h1>
        Home
        <small>Moell Blog</small>
    </h1>
    @endsection

    @section('content')
    @include('backend.common')
            <!-- statistics chart built with jQuery Flot -->
    <div class="table-wrapper products-table section">
        <div class="row-fluid head">
            <div class="span12">
                <h4 style="float:left;display: inline-block">用户管理</h4>
            </div>
        </div>

        <div class="row-fluid filter-block">
            <form name="create" action="/backend/user" method="get">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="pull-right">
                    姓名：<input type="text" class="input-mini" name="name"/>
                    登录名：<input type="text" class="input-small" name="login_name"/>
                    注册日期：<input type="text" value="" class="input-medium datepicker" name="create_date_start"/>-&nbsp;<input type="text" value="" class="input-medium datepicker" name="create_date_end"/>
                    <button type="submit" class="btn-glow"><i class="icon-search"></i> 搜索</button>
                    <a href="/backend/user/create" ><div class="btn-glow"><i class="icon-plus"></i> 增加新用户</div></a>
                    <a href="javascript:void(0)" id="dels"><div class="btn-glow"><i class="icon-minus"></i> 删除所选</div></a>
                </div>
            </form>
        </div>

        <div class="row-fluid">
            <table class="table table-hover" >
                <thead>
                <tr>
                    <th class="span2">
                        <input type="checkbox" name="mainCheckbox">
                        用户ID
                    </th>
                    <th class="span1">
                        <span class="line"></span>姓名
                    </th>
                    <th class="span1">
                        <span class="line"></span>登录名
                    </th>
                    <th class="span1">
                        <span class="line"></span>用户email
                    </th>
                    <th class="span1">
                        <span class="line"></span>所属机构
                    </th>
                    <th class="span1 sort @if(isset($condition) && isset($condition['sortName']) && $condition['sortName']=='sys_user.create_date') datagrid-sort-{{$condition['sortOrder']}} @endif" sort="sys_user.create_date">
                        <span class="line"></span>注册日期
                        <span class="datagrid-sort-icon"></span>
                    </th>
                    <th class="span1">
                        <span class="line"></span>用户mobile
                    </th>
                    <th class="span1">
                        <span class="line"></span>用户类型
                    </th>
                    <th class="span1">
                        <span class="line"></span>状态
                    </th>
                </tr>
                </thead>
                <tbody>
                @inject('systemPresenter', 'App\Presenters\SystemPresenter')
                @foreach($users as $key=>$user)
                    <tr>
                        <td>
                            <input type="checkbox" name="subCheckbox" userId="{{$user->id}}">
                            <a href="/backend/user?type={{$user->id}}" class="id">{{$user->id}}</a>
                        </td>
                        <td class="description">
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->login_name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$user->office->name}}
                        </td>
                        <td>
                            {{$user->create_date}}
                        </td>
                        <td>
                            {{$user->mobile}}
                        </td>
                        <td>
                            {!! $systemPresenter->queryDictLabel('sys_user_type',$user->user_type) !!}
                        </td>
                        <td>
                            <span class="label label-success">有效</span>
                            <ul class="actions">
                                <li><a href="/backend/user/edit?id={{$user->id}}">编辑</a></li>
                                <li class="last"><a href="javascript:void(0)" onclick="javascript:delUser('{{$user->id}}')">删除</a></li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {{$users->render()}}
                <h6 style="float:left;display: inline;margin-top:4px;">共{{$users->lastPage()}}页/</h6>
                <h6 style="float:left;display: inline;margin-top:4px;">{{$users->total()}}条记录　</h6>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        function delUser(id) {
            var submit = function (v, h, f) {
                if (v == 'ok'){
                    $.ajax({
                        type:'post',
                        url:'/backend/user/delete?id='+id+'&_token={{ csrf_token() }}',
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
            $.jBox.confirm("确定要删除该用户吗？", "提示", submit);
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
                            ids += $(this).attr('userId')+'|';
                        }
                    });
                    if(ids==''){
                        $.jBox.messager('请选择至少一项后才能删除', '提示');
                        return true;
                    }

                    $.ajax({
                        type:'post',
                        url:'/backend/user/delete?id='+ids+'&_token={{ csrf_token() }}',
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
            $.jBox.confirm("确定要删除选择的所有用户吗？", "提示", submit);
        });

        $(window).load(function(){
            $('.table .sort').click(function(){
                var name = $(this).attr('sort');
                var order = '';
                if($(this).hasClass('datagrid-sort-asc')){
                    $('.table .sort').removeClass('datagrid-sort-desc').removeClass('datagrid-sort-asc');
                    $(this).addClass('datagrid-sort-desc').removeClass('datagrid-sort-asc');
                    order = 'desc';
                }else if($(this).hasClass('datagrid-sort-desc')){
                    $('.table .sort').removeClass('datagrid-sort-desc').removeClass('datagrid-sort-asc');
                    $(this).addClass('datagrid-sort-asc').removeClass('datagrid-sort-desc');
                    order = 'asc';
                }else{
                    $('.table .sort').removeClass('datagrid-sort-desc').removeClass('datagrid-sort-asc');
                    $(this).addClass('datagrid-sort-desc').removeClass('datagrid-sort-asc');
                    order = 'desc';
                }

                window.location.href = '?sortName='+name+'&sortOrder='+order;
            });
        });
    </script>
@endsection
