@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/dict',request()) }}

@extends('layouts.backend')

@section('title', '字典管理')

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
                <h4 style="float:left;display: inline-block">字典管理</h4>
            </div>
        </div>

        <div class="row-fluid filter-block">
            <form name="create" action="/backend/dict" method="get">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="pull-right">
                    字典类型：
                    <div class="ui-select">
                        <select style="width:250px" class="select2" name="type">
                            <option />
                            @foreach($dictsGroup as $key=>$dictGroup)
                                <option value="{{$dictGroup->type}}" @if(request()->get('type')==$dictGroup->type) selected="" @endif/>{{$dictGroup->type}}
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-glow"><i class="icon-search"></i> 搜索</button>
                    <a href="/backend/dict/create" ><div class="btn-glow"><i class="icon-plus"></i> 增加新字典</div></a>
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
                        字典type
                    </th>
                    <th class="span1">
                        <span class="line"></span>字典value
                    </th>
                    <th class="span1">
                        <span class="line"></span>字典label
                    </th>
                    <th class="span1">
                        <span class="line"></span>字典排序
                    </th>
                    <th class="span1">
                        <span class="line"></span>状态
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($dicts as $key=>$dict)
                    <tr>
                        <td>
                            <input type="checkbox" name="subCheckbox" dictId="{{$dict->id}}">
                            <a href="/backend/dict?type={{$dict->type}}" class="name">{{$dict->type}}</a>
                        </td>
                        <td class="description">
                            {{$dict->value}}
                        </td>
                        <td>
                            {{$dict->label}}
                        </td>
                        <td>
                            {{$dict->sort}}
                        </td>
                        <td>
                            <span class="label label-success">有效</span>
                            <ul class="actions">
                                <li><a href="/backend/dict/create?type={{$dict->type}}">添加</a></li>
                                <li><a href="/backend/dict/edit?id={{$dict->id}}">编辑</a></li>
                                <li class="last"><a href="javascript:void(0)" onclick="javascript:delDict('{{$dict->id}}')">删除</a></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                <!-- row -->
                </tbody>
            </table>
            <div class="pagination">
                {{$dicts->render()}}
                <h6 style="float:left;display: inline">共{{$dicts->lastPage()}}页/</h6>
                <h6 style="float:left;display: inline">{{$dicts->total()}}条记录　</h6>
            </div>

        </div>
    </div>

    <script type="application/javascript">
        function delDict(id) {
            var submit = function (v, h, f) {
                if (v == 'ok'){
                    $.ajax({
                        type:'post',
                        url:'/backend/dict/delete?id='+id+'&_token={{ csrf_token() }}',
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
            $.jBox.confirm("确定要删除该字典选项吗？", "提示", submit);
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
                            ids += $(this).attr('dictId')+'|';
                        }
                    });

                    if(ids==''){
                        $.jBox.messager('请选择至少一项后才能删除', '提示');
                        return true;
                    }

                    $.ajax({
                        type:'post',
                        url:'/backend/dict/delete?id='+ids+'&_token={{ csrf_token() }}',
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
            $.jBox.confirm("确定要删除选择的所有字典数据吗？", "提示", submit);
        });
    </script>
@endsection
