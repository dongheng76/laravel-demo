@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/area',request()) }}

@extends('layouts.backend')

@section('title', '新增区域管理')

@section('header')
    <h1>
        Home
        <small>Moell Blog</small>
    </h1>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/web-app-icons.css') }}" type="text/css" media="screen" />
    <!-- statistics chart built with jQuery Flot -->
    <div class="table-wrapper products-table section">
        <div class="row-fluid head">
            <div class="span12">
                <h4 style="float:left;display: inline-block">新增区域管理</h4>
            </div>
        </div>

        @inject('systemPresenter', 'App\Presenters\SystemPresenter')
        <div class="row-fluid">
            <form name="create" action="/backend/area" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                @if(isset($area))
                    <input type="hidden" name="id" value="{{ $area->id }}"/>
                @endif
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span8 column">
                    <div class="field-box">
                        <label>所属上级区域:{{$parentSysArea->name}} <input type="hidden" name="parent_id" value="{{$parentSysArea->id}}"/><input type="hidden" name="parent_ids" value="{{$parentSysArea->parent_ids}}"/> </label>
                    </div>
                    <div class="field-box">
                        <label>区域名:</label>
                        <input style="width:400px" class="span8" type="text" name="name" @if(isset($area)) value="{{$area->name}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>排序号:</label>
                        <input style="width:400px" class="span8" type="text" name="sort" @if(isset($area)) value="{{$area->sort}}" @endif  @if(isset($sort)) value="{{$sort}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>邮政编码:</label>
                        <input style="width:400px" class="span8" type="text" name="code" @if(isset($area)) value="{{$area->code}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>区域类型:</label>
                        @if(isset($area))
                            {!! $systemPresenter->getDictLabel('sys_area_type','type',400,$area->type) !!}
                        @else
                            {!! $systemPresenter->getDictLabel('sys_area_type','type',400) !!}
                        @endif
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>备注:</label>
                        <textarea style="width:400px" name="remarks" rows="4">@if(isset($area)){{$area->remarks}}@endif</textarea>
                    </div>
                </div>
            </div>
                @if(isset($area))
                    <button type="button" class="btn-glow inverse" id="editBtn">确定修改</button>
                @else
                    <button type="button" class="btn-glow inverse" id="addBtn">确定添加</button>
                @endif
                <a class="btn-glow" href="/backend/area">返回</a>
            </form>
        </div>
    </div>
    <script type="application/javascript">
        $('#addBtn').click(function(){
            $.post('/backend/area/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，创建成功。', '创建成功！');
                    window.location.href = '/backend/area';
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
            $.post('/backend/area/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，修改成功。', '修改成功！');
                    window.location.href = '/backend/area';
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

        $('#selectIcon').click(function(){
            $.jBox.prompt($('#select-icon').html(), '请选择一个图标', { closed: function () { alert('prompt is closed.'); } },{ width: 800,height:600 });

            $('.icons-wrapper ul li').unbind('click').bind('click',function(){
                $('.icons-wrapper ul li').removeClass('selected');
                $(this).addClass('selected');

                var iconClass = $(this).find('i').attr('class');
                $('#currentIcon').attr('class',iconClass)
                $('input[name="icon"]').val(iconClass);
            });
        });

    </script>
@endsection
