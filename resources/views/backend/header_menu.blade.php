<ul id="menu" class="nav" style="*white-space:nowrap;float:none;">
    @if (session('currentSubMenuId'))
        <script type="application/javascript">
            var currentSubMenuId = '{{session('currentSubMenuId')}}';
        </script>
    @endif
    @if (session('sysMenus'))
        @inject('userUtil', 'App\Presenters\UserPresenter')
        @foreach(session('sysMenus') as $key=>$sysMenu)
            <li class="menu @if($userUtil->isChildByParentIds($sysMenu->id,request())) active @endif" dataId="{{$sysMenu->id}}">
                <a class="menu" href="javascript:"><span>{{$sysMenu->name}}</span></a>
            </li>
            @if($userUtil->isChildByParentIds($sysMenu->id,request()))
                <script type="application/javascript">
                    var currentMenuId = '{{$sysMenu->id}}';
                </script>
            @endif
        @endforeach
    @endif
</ul>

<script src="{{ asset('frame/js/header_menu.js') }}"></script>