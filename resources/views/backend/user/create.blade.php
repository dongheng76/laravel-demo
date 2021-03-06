@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/user',request()) }}

@extends('layouts.backend')

@section('title', '新增用户')

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
                <h4 style="float:left;display: inline-block">新增用户</h4>
            </div>
        </div>
        @inject('systemPresenter', 'App\Presenters\SystemPresenter')
        <div class="row-fluid">
            <form name="create" action="/backend/user"
                @if(isset($user))
                    method="PUT"
                @else
                    method="post"
                @endif
            >
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                @if(isset($user))
                    <input type="hidden" name="id" value="{{$user->id}}"/>
                    <input type="hidden" name="_method" value="PUT"/>
                @endif
                <div class="row-fluid form-wrapper">
                    <!-- left column -->
                    <div class="span8 column">
                        <div class="field-box">
                            <label>用户头像:</label>
                            <input type="hidden" id="photo" name="photo" @if(isset($user)) value="{{$user->photo}}" @endif/>
                            {!! $systemPresenter->makeUpload("photo","images",false,0,"{width:200,height:200}","[{\@width\@:\@200\@,\@height\@:\@200\@},{\@width\@:\@300\@,\@height\@:\@300\@}]") !!}
                        </div>
                        <div class="field-box">
                            <label>归属机构:</label>
                            <select style="width:400px" class="select2" name="office_id">
                                <option />
                                @foreach($offices as $key=>$office)
                                    <option value="{{$office->id}}" @if(isset($user) && $user->office_id==$office->id) selected="" @endif/>{{$office->name}}
                                    @foreach($office->children as $childOffices)
                                        <option value="{{$childOffices->id}}" @if(isset($user) && $user->office_id==$childOffices->id) selected="" @endif/>{{$office->name}}>{{$childOffices->name}}
                                        @foreach($childOffices->children as $childChildOffices)
                                            <option value="{{$childChildOffices->id}}" @if(isset($user) && $user->office_id==$childChildOffices->id) selected="" @endif/>{{$office->name}}>{{$childOffices->name}}>{{$childChildOffices->name}}
                                            @foreach($childChildOffices->children as $childChildChildOffices)
                                                <option value="{{$childChildChildOffices->id}}" @if(isset($user) && $user->office_id==$childChildChildOffices->id) selected="" @endif/>{{$office->name}}>{{$childOffices->name}}>{{$childChildOffices->name}}>{{$childChildChildOffices->name}}
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="field-box">
                            <label>用户工号:</label>
                            <input style="width:400px" type="text" name="no" @if(isset($user)) value="{{$user->no}}" @endif/>
                        </div>
                        <div class="field-box">
                            <label>姓名:</label>
                            <input style="width:400px" type="text" name="name" @if(isset($user)) value="{{$user->name}}" @endif />
                        </div>
                        <div class="field-box">
                            <label>登录名:</label>
                            <input style="width:400px" type="text" name="login_name" @if(isset($user)) value="{{$user->login_name}}" disabled="disabled" @endif />
                        </div>
                        <div class="field-box">
                            <label>密码:</label>
                            <input style="width:400px" type="password" name="password"/>
                        </div>
                        <div class="field-box">
                            <label>确认密码:</label>
                            <input style="width:400px" type="password" name="confrim_password"/>
                        </div>
                        <div class="field-box">
                            <label>邮箱:</label>
                            <input style="width:400px" type="text" name="email" @if(isset($user)) value="{{$user->email}}" @endif />
                        </div>
                        <div class="field-box">
                            <label>电话:</label>
                            <input style="width:400px" type="text" name="phone" @if(isset($user)) value="{{$user->phone}}" @endif/>
                        </div>
                        <div class="field-box">
                            <label>手机:</label>
                            <input style="width:400px" type="text" name="mobile" @if(isset($user)) value="{{$user->mobile}}" @endif/>
                        </div>
                        <div class="field-box">
                            <label>是否允许登录:</label>
                            <div>
                                <label class="radio">
                                    <input type="radio" name="login_flag" id="optionsRadios1" value="1" @if(isset($user)) @if($user->login_flag==1) checked="" @endif  @else checked="" @endif  />是
                                </label>
                                <label class="radio">
                                    <input type="radio" name="login_flag" id="optionsRadios2" value="0" @if(isset($user) && $user->login_flag==0) checked="" @endif/>否
                                </label>
                            </div>
                            <div class="auto-height"></div>
                        </div>
                        <div class="field-box">
                            <label>用户类型:</label>
                            @if(isset($user))
                                {!! $systemPresenter->getDictLabel('sys_user_type','user_type',400,$user->user_type) !!}
                            @else
                                {!! $systemPresenter->getDictLabel('sys_user_type','user_type',400) !!}
                            @endif
                        </div>
                        <div class="field-box">
                            <label>用户角色:</label>
                            <div>
                                @foreach($roles as $key=>$role)
                                    <label class="checkbox">
                                        <input name="role[]" value="{{$role->id}}" type="checkbox"
                                            @if(isset($userRoles))
                                                @foreach($userRoles as $userRole)
                                                    @if($userRole->role_id == $role->id)
                                                        checked=""
                                                    @endif
                                                @endforeach
                                            @endif
                                        />{{$role->name}}
                                    </label>
                                @endforeach
                            </div>
                            <div class="auto-height"></div>
                        </div>
                        <div class="field-box">
                            <label>备注:</label>
                            <textarea style="width:400px" name="remarks" rows="4">@if(isset($user)){{$user->remarks}}@endif</textarea>
                        </div>
                    </div>
                </div>
                @if(isset($user))
                    <button type="button" class="btn-glow inverse" id="editUserBtn">确定修改</button>
                @else
                    <button type="button" class="btn-glow inverse" id="addUserBtn">确定添加</button>
                @endif
                <a class="btn-glow" href="/backend/user">返回</a>
            </form>
        </div>
    </div>
    <script type="application/javascript">
        $('#addUserBtn').click(function(){
            //上传之前检查两次输入的密码是否一致
            var pwd = $('input[name="password"]').val();
            if(pwd){
                if(pwd!=$('input[name="confrim_password"]').val()){
                    $.jBox.messager('您两次输入的密码不一致，请检查两次输入的密码是否一致。', '密码设置错误');
                    return false;
                }
            }

            $.post('/backend/user/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，创建成功。', '创建成功！');
                    window.location.href = '/backend/user';
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

        $('#editUserBtn').click(function(){
            //上传之前检查两次输入的密码是否一致
            var pwd = $('input[name="password"]').val();
            if(pwd){
                if(pwd!=$('input[name="confrim_password"]').val()){
                    $.jBox.messager('您两次输入的密码不一致，请检查两次输入的密码是否一致。', '密码设置错误');
                    return false;
                }
            }

            $.ajax({
                type:'post',
                url:'/backend/user/update?id=@if(isset($user)){{$user->id}}@endif&'+$('form[name="create"]').serialize(),
                dataType:'json',
                success:function(data){
                    if(data.result){
                        $.jBox.messager('感谢您的使用，修改成功。', '修改成功！');
                        window.location.href = '/backend/user';
                    }else{
                        $.jBox.messager('非常抱歉，系统或网络发生异常，请重试!', '修改失败！');
                    }
                },
                error:function(data){
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
                }
            });
        });

    </script>

@endsection
