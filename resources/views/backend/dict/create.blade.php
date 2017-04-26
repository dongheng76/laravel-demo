@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/dict',request()) }}

@extends('layouts.backend')

@section('title', '新增字典管理')

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
                <h4 style="float:left;display: inline-block">新增字典信息</h4>
            </div>
        </div>

        <div class="row-fluid">
            <form name="create" action="/backend/dict" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                @if(isset($id))
                    <input type="hidden" name="id" value="{{ $id }}"/>
                @endif
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span8 column">
                    <div class="field-box">
                        <label>字典key:</label>
                        <input class="span8" type="text" name="value" @if(isset($dict)) value="{{$dict->value}}" @endif/>
                    </div>
                    <div class="field-box">
                        <label>字典label:</label>
                        <input class="span8" type="text" name="label" @if(isset($dict)) value="{{$dict->label}}" @endif/>
                    </div>
                    <div class="field-box">
                        <label>字典类型:</label>
                        <input class="span8" type="text" name="type" @if(isset($dict)) value="{{$dict->type}}" @endif @if(isset($type)) value="{{$type}}" @endif/>
                    </div>
                    <div class="field-box">
                        <label>字典排序:</label>
                        <input class="span8" type="text" name="sort" @if(isset($dict)) value="{{$dict->sort}}" @endif @if(isset($maxSort)) value="{{$maxSort}}" @endif/>
                    </div>
                </div>
            </div>
                @if(isset($dict))
                    <button type="button" class="btn-glow inverse" id="editDictBtn">确定修改</button>
                @else
                    <button type="button" class="btn-glow inverse" id="addDictBtn">确定添加</button>
                @endif
                <a class="btn-glow" href="/backend/dict">返回</a>
            </form>
        </div>
    </div>
    <script type="application/javascript">
        $('#addDictBtn').click(function(){
            $.post('/backend/dict/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，创建成功。', '创建成功！');
                    window.location.href = '/backend/dict?type='+$('input[name="type"]').val();
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

        $('#editDictBtn').click(function(){
            $.post('/backend/dict/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，修改成功。', '修改成功！');
                    window.location.href = '/backend/dict?type='+$('input[name="type"]').val();
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

                $.jBox.messager(props, '修改失败！');
            });
        });

    </script>

@endsection
