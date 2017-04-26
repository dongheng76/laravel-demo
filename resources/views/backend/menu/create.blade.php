@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend/menu',request()) }}

@extends('layouts.backend')

@section('title', '新增菜单管理')

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
                <h4 style="float:left;display: inline-block">新增菜单管理</h4>
            </div>
        </div>

        @inject('systemPresenter', 'App\Presenters\SystemPresenter')
        <div class="row-fluid">
            <form name="create" action="/backend/role" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                @if(isset($menu))
                    <input type="hidden" name="id" value="{{ $menu->id }}"/>
                @endif
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span8 column">
                    <div class="field-box">
                        <label>所属上级菜单:</label>
                        <select style="width:400px" class="select2" name="parent_id">
                            <option />
                            <option value="1"/>根目录菜单
                            @foreach($sysMenus as $key=>$sysMenu)
                                <option value="{{$sysMenu->id}}" @if(isset($menu) && $menu->parent_id==$sysMenu->id) selected="" @endif @if(isset($parentId) && $parentId==$sysMenu->id) selected="" @endif/>{{$sysMenu->name}}
                                @foreach($sysMenu->children as $childMenus)
                                    <option value="{{$childMenus->id}}" @if(isset($menu) && $menu->parent_id==$childMenus->id) selected="" @endif @if(isset($parentId) && $parentId==$childMenus->id) selected="" @endif/>{{$sysMenu->name}}>{{$childMenus->name}}
                                    @foreach($childMenus->children as $childChildMenus)
                                        <option value="{{$childChildMenus->id}}" @if(isset($menu) && $menu->parent_id==$childChildMenus->id) selected="" @endif @if(isset($parentId) && $parentId==$childChildMenus->id) selected="" @endif/>{{$sysMenu->name}}>{{$childMenus->name}}>{{$childChildMenus->name}}
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="field-box">
                        <label>菜单名:</label>
                        <input style="width:400px" class="span8" type="text" name="name" @if(isset($menu)) value="{{$menu->name}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>排序号:</label>
                        <input style="width:400px" class="span8" type="text" name="sort" @if(isset($menu)) value="{{$menu->sort}}" @endif  @if(isset($sort)) value="{{$sort}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>href:</label>
                        <input style="width:400px" class="span8" type="text" name="href" @if(isset($menu)) value="{{$menu->href}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>选择图标:</label>
                        <div class="btn-glow" id="selectIcon"><i class="icon-plus"></i>请选择一个图标</div>
                        <li style="display: inline-block;"><i id="currentIcon" class="@if(isset($menu)) {{$menu->icon}}@endif"></i></li>
                        <input type="hidden" name="icon" @if(isset($menu)) value="{{$menu->icon}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>菜单权限:</label>
                        <input style="width:400px" class="span8" type="text" name="permission" @if(isset($menu)) value="{{$menu->permission}}" @endif/>
                        <div class="auto-height"></div>
                    </div>
                    <div class="field-box">
                        <label>备注:</label>
                        <textarea style="width:400px" name="remarks" rows="4">@if(isset($menu)){{$menu->remarks}}@endif</textarea>
                    </div>
                </div>
            </div>
                @if(isset($menu))
                    <button type="button" class="btn-glow inverse" id="editBtn">确定修改</button>
                @else
                    <button type="button" class="btn-glow inverse" id="addBtn">确定添加</button>
                @endif
                <a class="btn-glow" href="/backend/menu">返回</a>
            </form>
        </div>
    </div>
    <div id="select-icon" style="display: none;">
        <!-- Web Applications Icons -->
        <div class="icons-wrapper">
            <div class="row-fluid head">
                <div class="span12">
                    <h4>web应用常用图标 <small>字体类型 Awesome</small></h4>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">
                    <ul>
                        <li><i class="icon-adjust"></i>icon-adjust</li>
                        <li><i class="icon-asterisk"></i>icon-asterisk</li>
                        <li><i class="icon-ban-circle"></i>icon-ban-circle</li>
                        <li><i class="icon-bar-chart"></i>icon-bar-chart</li>
                        <li><i class=" icon-barcode"></i> icon-barcode</li>
                        <li><i class="icon-beaker"></i>icon-beaker</li>
                        <li><i class="icon-beer"></i>icon-beer</li>
                        <li><i class="icon-bell"></i>icon-bell</li>
                        <li><i class="icon-bell-alt"></i>icon-bell-alt</li>
                        <li><i class="icon-bolt"></i>icon-bolt</li>
                        <li><i class="icon-book"></i>icon-book</li>
                        <li><i class="icon-bookmark"></i>icon-bookmark</li>
                        <li><i class="icon-bookmark-empty"></i>icon-bookmark-empty</li>
                        <li><i class="icon-briefcase"></i>icon-briefcase</li>
                        <li><i class="icon-bullhorn"></i>icon-bullhorn</li>
                        <li><i class="icon-calendar"></i>icon-calendar</li>
                        <li><i class="icon-camera"></i>icon-camera</li>
                        <li><i class="icon-camera-retro"></i>icon-camera-retro</li>
                        <li><i class="icon-certificate"></i>icon-certificate</li>
                        <li><i class="icon-check"></i>icon-check</li>
                        <li><i class="icon-check-empty"></i>icon-check-empty</li>
                        <li><i class="icon-circle"></i>icon-circle</li>
                        <li><i class="icon-circle-blank"></i>icon-circle-blank</li>
                        <li><i class="icon-cloud"></i>icon-cloud</li>
                        <li><i class="icon-cloud-download"></i>icon-cloud-download</li>
                        <li><i class="icon-cloud-upload"></i>icon-cloud-upload</li>
                        <li><i class="icon-coffee"></i>icon-coffee</li>
                        <li><i class="icon-cog"></i>icon-cog</li>
                        <li><i class="icon-cogs"></i>icon-cogs</li>
                        <li><i class="icon-comment"></i>icon-comment</li>
                        <li><i class="icon-comment-alt"></i>icon-comment-alt</li>
                        <li><i class="icon-comments"></i>icon-comments</li>
                        <li><i class="icon-comments-alt"></i>icon-comments-alt</li>
                        <li><i class="icon-credit-card"></i>icon-credit-card</li>
                        <li><i class="icon-dashboard"></i>icon-dashboard</li>
                        <li><i class="icon-desktop"></i>icon-desktop</li>
                        <li><i class="icon-download"></i>icon-download</li>
                        <li><i class="icon-download-alt"></i>icon-download-alt</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-edit"></i>icon-edit</li>
                        <li><i class="icon-envelope"></i>icon-envelope</li>
                        <li><i class="icon-envelope-alt"></i>icon-envelope-alt</li>
                        <li><i class="icon-exchange"></i>icon-exchange</li>
                        <li><i class="icon-exclamation-sign"></i>icon-exclamation-sign</li>
                        <li><i class="icon-external-link"></i>icon-external-link</li>
                        <li><i class="icon-eye-close"></i>icon-eye-close</li>
                        <li><i class="icon-eye-open"></i>icon-eye-open</li>
                        <li><i class="icon-facetime-video"></i>icon-facetime-video</li>
                        <li><i class="icon-fighter-jet"></i>icon-fighter-jet</li>
                        <li><i class="icon-film"></i>icon-film</li>
                        <li><i class="icon-filter"></i>icon-filter</li>
                        <li><i class="icon-fire"></i>icon-fire</li>
                        <li><i class="icon-flag"></i>icon-flag</li>
                        <li><i class="icon-folder-close"></i>icon-folder-close</li>
                        <li><i class="icon-folder-open"></i>icon-folder-open</li>
                        <li><i class="icon-folder-close-alt"></i>icon-folder-close-alt</li>
                        <li><i class="icon-folder-open-alt"></i>icon-folder-open-alt</li>
                        <li><i class="icon-food"></i>icon-food</li>
                        <li><i class="icon-gift"></i>icon-gift</li>
                        <li><i class="icon-glass"></i>icon-glass</li>
                        <li><i class="icon-globe"></i>icon-globe</li>
                        <li><i class="icon-group"></i>icon-group</li>
                        <li><i class="icon-hdd"></i>icon-hdd</li>
                        <li><i class="icon-headphones"></i>icon-headphones</li>
                        <li><i class="icon-heart"></i>icon-heart</li>
                        <li><i class="icon-heart-empty"></i>icon-heart-empty</li>
                        <li><i class="icon-home"></i>icon-home</li>
                        <li><i class="icon-inbox"></i>icon-inbox</li>
                        <li><i class="icon-info-sign"></i>icon-info-sign</li>
                        <li><i class="icon-key"></i>icon-key</li>
                        <li><i class="icon-leaf"></i>icon-leaf</li>
                        <li><i class="icon-laptop"></i>icon-laptop</li>
                        <li><i class="icon-legal"></i>icon-legal</li>
                        <li><i class="icon-lemon"></i>icon-lemon</li>
                        <li><i class="icon-lightbulb"></i>icon-lightbulb</li>
                        <li><i class="icon-lock"></i>icon-lock</li>
                        <li><i class="icon-unlock"></i>icon-unlock</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-magic"></i>icon-magic</li>
                        <li><i class="icon-magnet"></i>icon-magnet</li>
                        <li><i class="icon-map-marker"></i>icon-map-marker</li>
                        <li><i class="icon-minus"></i>icon-minus</li>
                        <li><i class="icon-minus-sign"></i>icon-minus-sign</li>
                        <li><i class="icon-mobile-phone"></i>icon-mobile-phone</li>
                        <li><i class="icon-money"></i>icon-money</li>
                        <li><i class="icon-move"></i>icon-move</li>
                        <li><i class="icon-music"></i>icon-music</li>
                        <li><i class="icon-off"></i>icon-off</li>
                        <li><i class="icon-ok"></i>icon-ok</li>
                        <li><i class="icon-ok-circle"></i>icon-ok-circle</li>
                        <li><i class="icon-ok-sign"></i>icon-ok-sign</li>
                        <li><i class="icon-pencil"></i>icon-pencil</li>
                        <li><i class="icon-picture"></i>icon-picture</li>
                        <li><i class="icon-plane"></i>icon-plane</li>
                        <li><i class="icon-plus"></i>icon-plus</li>
                        <li><i class="icon-plus-sign"></i>icon-plus-sign</li>
                        <li><i class="icon-print"></i>icon-print</li>
                        <li><i class="icon-pushpin"></i>icon-pushpin</li>
                        <li><i class="icon-qrcode"></i>icon-qrcode</li>
                        <li><i class="icon-question-sign"></i>icon-question-sign</li>
                        <li><i class="icon-quote-left"></i>icon-quote-left</li>
                        <li><i class="icon-quote-right"></i>icon-quote-right</li>
                        <li><i class="icon-random"></i>icon-random</li>
                        <li><i class="icon-refresh"></i>icon-refresh</li>
                        <li><i class="icon-remove"></i>icon-remove</li>
                        <li><i class="icon-remove-circle"></i>icon-remove-circle</li>
                        <li><i class="icon-remove-sign"></i>icon-remove-sign</li>
                        <li><i class="icon-reorder"></i>icon-reorder</li>
                        <li><i class="icon-reply"></i>icon-reply</li>
                        <li><i class="icon-resize-horizontal"></i>icon-resize-horizontal</li>
                        <li><i class="icon-resize-vertical"></i>icon-resize-vertical</li>
                        <li><i class="icon-retweet"></i>icon-retweet</li>
                        <li><i class="icon-road"></i>icon-road</li>
                        <li><i class="icon-rss"></i>icon-rss</li>
                        <li><i class="icon-screenshot"></i>icon-screenshot</li>
                        <li><i class="icon-search"></i>icon-search</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-share"></i>icon-share</li>
                        <li><i class="icon-share-alt"></i>icon-share-alt</li>
                        <li><i class="icon-shopping-cart"></i>icon-shopping-cart</li>
                        <li><i class="icon-signal"></i>icon-signal</li>
                        <li><i class="icon-signin"></i>icon-signin</li>
                        <li><i class="icon-signout"></i>icon-signout</li>
                        <li><i class="icon-sitemap"></i>icon-sitemap</li>
                        <li><i class="icon-sort"></i>icon-sort</li>
                        <li><i class="icon-sort-down"></i>icon-sort-down</li>
                        <li><i class="icon-sort-up"></i>icon-sort-up</li>
                        <li><i class="icon-spinner"></i>icon-spinner</li>
                        <li><i class="icon-star"></i>icon-star</li>
                        <li><i class="icon-star-empty"></i>icon-star-empty</li>
                        <li><i class="icon-star-half"></i>icon-star-half</li>
                        <li><i class="icon-tablet"></i>icon-tablet</li>
                        <li><i class="icon-tag"></i>icon-tag</li>
                        <li><i class="icon-tags"></i>icon-tags</li>
                        <li><i class="icon-tasks"></i>icon-tasks</li>
                        <li><i class="icon-thumbs-down"></i>icon-thumbs-down</li>
                        <li><i class="icon-thumbs-up"></i>icon-thumbs-up</li>
                        <li><i class="icon-time"></i>icon-time</li>
                        <li><i class="icon-tint"></i>icon-tint</li>
                        <li><i class="icon-trash"></i>icon-trash</li>
                        <li><i class="icon-trophy"></i>icon-trophy</li>
                        <li><i class="icon-truck"></i>icon-truck</li>
                        <li><i class="icon-umbrella"></i>icon-umbrella</li>
                        <li><i class="icon-upload"></i>icon-upload</li>
                        <li><i class="icon-upload-alt"></i>icon-upload-alt</li>
                        <li><i class="icon-user"></i>icon-user</li>
                        <li><i class="icon-user-md"></i>icon-user-md</li>
                        <li><i class="icon-volume-off"></i>icon-volume-off</li>
                        <li><i class="icon-volume-up"></i>icon-volume-up</li>
                        <li><i class="icon-warning-sign"></i>icon-warning-sign</li>
                        <li><i class="icon-wrench"></i>icon-wrench</li>
                        <li><i class="icon-zoom-in"></i>icon-zoom-in</li>
                        <li><i class="icon-zoom-out"></i>icon-zoom-out</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Video Player Icons -->
        <div class="icons-wrapper icons-wrapper-border">
            <div class="row-fluid head">
                <div class="span12">
                    <h4>视频相关图标</h4>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">
                    <ul>
                        <li><i class="icon-play-circle"></i> icon-play-circle</li>
                        <li><i class="icon-play"></i> icon-play</li>
                        <li><i class="icon-pause"></i> icon-pause</li>
                        <li><i class="icon-stop"></i> icon-stop</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-step-backward"></i> icon-step-backward</li>
                        <li><i class="icon-fast-backward"></i> icon-fast-backward</li>
                        <li><i class="icon-backward"></i> icon-backward</li>
                        <li><i class="icon-forward"></i> icon-forward</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-fast-forward"></i> icon-fast-forward</li>
                        <li><i class="icon-step-forward"></i> icon-step-forward</li>
                        <li><i class="icon-eject"></i> icon-eject</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-fullscreen"></i> icon-fullscreen</li>
                        <li><i class="icon-resize-full"></i> icon-resize-full</li>
                        <li><i class="icon-resize-small"></i> icon-resize-small</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Social Icons -->
        <div class="icons-wrapper icons-wrapper-border">
            <div class="row-fluid head">
                <div class="span12">
                    <h4>社交图标</h4>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span3">
                    <ul>
                        <li><i class="icon-html5"></i>icon-html5</li>
                        <li><i class="icon-phone-sign"></i>icon-phone-sign</li>
                        <li><i class="icon-facebook"></i>icon-facebook</li>
                        <li><i class="icon-facebook-sign"></i>icon-facebook-sign</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-twitter"></i>icon-twitter</li>
                        <li><i class="icon-twitter-sign"></i>icon-twitter-sign</li>
                        <li><i class="icon-github"></i>icon-github</li>
                        <li><i class="icon-css3"></i>icon-css3</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-github-sign"></i>icon-github-sign</li>
                        <li><i class="icon-linkedin"></i>icon-linkedin</li>
                        <li><i class="icon-linkedin-sign"></i>icon-linkedin-sign</li>
                        <li><i class="icon-pinterest"></i>icon-pinterest</li>
                    </ul>
                </div>
                <div class="span3">
                    <ul>
                        <li><i class="icon-pinterest-sign"></i>icon-pinterest-sign</li>
                        <li><i class="icon-google-plus"></i>icon-google-plus</li>
                        <li><i class="icon-google-plus-sign"></i>icon-google-plus-sign</li>
                        <li><i class="icon-sign-blank"></i>icon-sign-blank</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        $('#addBtn').click(function(){
            $.post('/backend/menu/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，创建成功。', '创建成功！');
                    window.location.href = '/backend/menu';
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
            $.post('/backend/menu/store',$('form[name="create"]').serialize(),function(data){
                if(data.result){
                    $.jBox.messager('感谢您的使用，修改成功。', '修改成功！');
                    window.location.href = '/backend/menu';
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
            $.jBox.prompt($('#select-icon').html(), '请选择一个图标', { closed: function () {  } },{ width: 800,height:600 });

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