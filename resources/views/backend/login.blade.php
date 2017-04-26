<!DOCTYPE html>
<html class="login-bg">
<head>
    <meta charset="utf-8">
    <title>后台管理系统测试版 - 登录</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- bootstrap -->
    <link href="{{ asset('bootstrapui/css/bootstrap/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/bootstrap/bootstrap-responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/bootstrap/bootstrap-overrides.css') }}" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/layout.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/elements.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/icons.css') }}" />

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/lib/font-awesome.css') }}" />

    <!-- this page specific styles -->
    <link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/signin.css') }}" type="text/css" media="screen" />

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <![endif]-->
</head>
<body>
<!-- background switcher -->
<div class="bg-switch visible-desktop">
    <div class="bgs">
        <a href="#" data-img="landscape.jpg" class="bg active">
            <img src="{{ asset('bootstrapui/img/bgs/landscape.jpg') }}" />
        </a>
        <a href="#" data-img="blueish.jpg" class="bg">
            <img src="{{ asset('bootstrapui/img/bgs/blueish.jpg') }}" />
        </a>
        <a href="#" data-img="7.jpg" class="bg">
            <img src="{{ asset('bootstrapui/img/bgs/7.jpg') }}" />
        </a>
        <a href="#" data-img="8.jpg" class="bg">
            <img src="{{ asset('bootstrapui/img/bgs/8.jpg') }}" />
        </a>
        <a href="#" data-img="9.jpg" class="bg">
            <img src="{{ asset('bootstrapui/img/bgs/9.jpg') }}" />
        </a>
        <a href="#" data-img="10.jpg" class="bg">
            <img src="{{ asset('bootstrapui/img/bgs/10.jpg') }}" />
        </a>
        <a href="#" data-img="11.jpg" class="bg">
            <img src="{{ asset('bootstrapui/img/bgs/11.jpg') }}" />
        </a>
    </div>
</div>


<div class="row-fluid login-wrapper">
    <a href="index.html">
        <img class="logo" src="{{ asset('bootstrapui/img/logo-white.png') }}" />
    </a>

    <div class="span4 box">
        <form action="{{ url('backend/login') }}"  method="post">
            {{ csrf_field() }}
            <div class="content-wrap">
                <h6>登录系统</h6>
                <input class="span12" type="text" name="login_name" class="form-control" value="{{ old('email') }}"/>
                <input class="span12" type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}"/>
                <a href="#" class="forgot">忘记密码?</a>
                <div class="remember">
                    <input id="remember-me" name="remember" type="checkbox" />
                    <label for="remember-me">记住我</label>
                </div>
                <button class="btn-glow primary login" >登录</button>
            </div>
        </form>
    </div>

    <div class="span4 no-account">
        <p>没有账户吗？</p>
        <a href="signup.html">立即注册</a>
    </div>
</div>

<!-- scripts -->
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="{{ asset('bootstrapui/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrapui/js/theme.js') }}"></script>

<!-- pre load bg imgs -->
<script type="text/javascript">
    $(function () {
        // bg switcher
        var $btns = $(".bg-switch .bg");
        $btns.click(function (e) {
            e.preventDefault();
            $btns.removeClass("active");
            $(this).addClass("active");
            var bg = $(this).data("img");
            $("html").css("background-image", "url('"+'{{ asset('bootstrapui/img/bgs') }}/'+ bg+"')");
        });
    });
</script>
</body>
</html>