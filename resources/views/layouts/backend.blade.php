<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- bootstrap -->
    <link href="{{ asset('bootstrapui/css/bootstrap/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/bootstrap/bootstrap-responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/bootstrap/bootstrap-overrides.css') }}" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="{{ asset('bootstrapui/css/lib/jquery-ui-1.10.2.custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('bootstrapui/css/lib/font-awesome.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/lib/bootstrap-wysihtml5.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/lib/uniform.default.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/lib/select2.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/lib/bootstrap.datepicker.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('bootstrapui/css/lib/font-awesome.css') }}" type="text/css" rel="stylesheet" />

    <!-- this page specific styles -->
    <link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/form-showcase.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/tables.css') }}" type="text/css" media="screen" />


    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/layout.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/elements.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrapui/css/icons.css') }}" />

    <!-- jstree -->
    <link href="{{ asset('ztree/3.5.12/css/zTreeStyle/zTreeStyle.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- this page specific styles -->
    <link rel="stylesheet" href="{{ asset('bootstrapui/css/compiled/index.css') }}" type="text/css" media="screen" />

    {{--<!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />--}}

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- scripts -->
    <script src="{{ asset('bootstrapui/js/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/jquery-1.8.3.min.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/bootstrap-wysihtml5-0.0.2.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/jquery-ui-1.10.2.custom.min.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/common.js') }}"></script>

    <script src="{{ asset('bootstrapui/js/bootstrap.datepicker.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/jquery.uniform.min.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/select2.min.js') }}"></script>
    <!-- knob -->
    <script src="{{ asset('bootstrapui/js/jquery.knob.js') }}"></script>
    <!-- flot charts -->
    <script src="{{ asset('bootstrapui/js/jquery.flot.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('bootstrapui/js/theme.js') }}"></script>

    <script src="{{ asset('bootstrapui/js/json2.js') }}"></script>

    <!-- jstree -->
    <script src="{{ asset('ztree/3.5.12/js/jquery.ztree.all-3.5.min.js') }}" type="text/javascript"></script>

    <!-- Generic page styles -->
    <link rel="stylesheet" href="{{ asset('jqueryFileUpload/css/jquery.fileupload.css') }}">
    <script src="{{ asset('jqueryFileUpload/js/vendor/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('jqueryFileUpload/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('jqueryFileUpload/js/jquery.fileupload.js') }}"></script>

    <!-- 相册管理器 -->
    <link href="{{ asset('imagesManage/css/jquery.imageManage.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('imagesManage/css/jquery.contextMenu.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('imagesManage/css/viewer.css') }}" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="{{ asset('imagesManage/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('imagesManage/js/viewer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('imagesManage/js/jquery.ui.position.js') }}"></script>
    <script type="text/javascript" src="{{ asset('imagesManage/js/jquery.contextMenu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('imagesManage/js/jquery.imagesManage.js') }}"></script>

    <!-- 编辑器 -->
    <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.config.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.all.js') }}"> </script>
    <!-- H5编辑器 -->
    <link href="{{ asset('squire/css/color.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('squire/css/squire.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('squire/css/stylesheet.css') }}" type="text/css" rel="stylesheet" />
    <script type="text/javascript" charset="utf-8" src="{{ asset('squire/js/colorpicker.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('squire/js/squire-raw.js') }}"></script>
    <!-- 编辑器 -->
    <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.config.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.all.js') }}"> </script>

    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/lang/zh-cn/zh-cn.js') }}"></script>

    <link href="{{ asset('jquery-jbox/2.3/Skins/Bootstrap/jbox.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('jquery-jbox/2.3/jquery.jBox-2.3.min.js') }}" type="text/javascript"></script>

</head>
<body>

<!-- end navbar -->
@include('backend.header')
<!-- sidebar -->
<div id="sidebar-nav">
    @include('backend.left_menu')
</div>
<!-- end sidebar -->


<!-- main container -->
<div class="content">

    <!-- settings changer -->
    <div class="skins-nav">
        <a href="#" class="skin first_nav selected">
            <span class="icon"></span><span class="text">Default skin</span>
        </a>
        <a href="#" class="skin second_nav" data-file="css/skins/dark.css">
            <span class="icon"></span><span class="text">Dark skin</span>
        </a>
    </div>

    <div class="container-fluid">

        <!-- upper main stats -->
        {{--<div id="main-stats">
            <div class="row-fluid stats-row">
                <div class="span3 stat">
                    <div class="data">
                        <span class="number">2457</span>
                        visits
                    </div>
                    <span class="date">Today</span>
                </div>
                <div class="span3 stat">
                    <div class="data">
                        <span class="number">3240</span>
                        users
                    </div>
                    <span class="date">February 2013</span>
                </div>
                <div class="span3 stat">
                    <div class="data">
                        <span class="number">322</span>
                        orders
                    </div>
                    <span class="date">This week</span>
                </div>
                <div class="span3 stat last">
                    <div class="data">
                        <span class="number">$2,340</span>
                        sales
                    </div>
                    <span class="date">last 30 days</span>
                </div>
            </div>
        </div>--}}
        <!-- end upper main stats -->

        <div id="pad-wrapper">
            @yield('content')
        </div>
    </div>
</div>


<!-- call this page plugins -->
<script type="text/javascript">
    $(function () {

        // add uniform plugin styles to html elements
        $("input:checkbox, input:radio").uniform();

        // select2 plugin for select elements
        $(".select2").select2({
            placeholder: "请选择一个选项"
        });

        // datepicker plugin
        $('.datepicker').datepicker({
            language: "cn",
            autoclose: true,//选中之后自动隐藏日期选择框
            clearBtn: true,//清除按钮
            todayBtn: true,//今日按钮
            format: "yyyy-mm-dd"//日期格式
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });

        // wysihtml5 plugin on textarea
        $(".wysihtml5").wysihtml5({
            "font-styles": false
        });
    });
</script>

<script type="text/javascript">
    $(function () {

        // jQuery Knobs
        $(".knob").knob();



        // jQuery UI Sliders
        $(".slider-sample1").slider({
            value: 100,
            min: 1,
            max: 500
        });
        $(".slider-sample2").slider({
            range: "min",
            value: 130,
            min: 1,
            max: 500
        });
        $(".slider-sample3").slider({
            range: true,
            min: 0,
            max: 500,
            values: [ 40, 170 ],
        });



        // jQuery Flot Chart
        var visits = [[1, 50], [2, 40], [3, 45], [4, 23],[5, 55],[6, 65],[7, 61],[8, 70],[9, 65],[10, 75],[11, 57],[12, 59]];
        var visitors = [[1, 25], [2, 50], [3, 23], [4, 48],[5, 38],[6, 40],[7, 47],[8, 55],[9, 43],[10,50],[11,47],[12, 39]];

        var plot = $.plot($("#statsChart"),
                [ { data: visits, label: "Signups"},
                    { data: visitors, label: "Visits" }], {
                    series: {
                        lines: { show: true,
                            lineWidth: 1,
                            fill: true,
                            fillColor: { colors: [ { opacity: 0.1 }, { opacity: 0.13 } ] }
                        },
                        points: { show: true,
                            lineWidth: 2,
                            radius: 3
                        },
                        shadowSize: 0,
                        stack: true
                    },
                    grid: { hoverable: true,
                        clickable: true,
                        tickColor: "#f9f9f9",
                        borderWidth: 0
                    },
                    legend: {
                        // show: false
                        labelBoxBorderColor: "#fff"
                    },
                    colors: ["#a7b5c5", "#30a0eb"],
                    xaxis: {
                        ticks: [[1, "JAN"], [2, "FEB"], [3, "MAR"], [4,"APR"], [5,"MAY"], [6,"JUN"],
                            [7,"JUL"], [8,"AUG"], [9,"SEP"], [10,"OCT"], [11,"NOV"], [12,"DEC"]],
                        font: {
                            size: 12,
                            family: "Open Sans, Arial",
                            variant: "small-caps",
                            color: "#697695"
                        }
                    },
                    yaxis: {
                        ticks:3,
                        tickDecimals: 0,
                        font: {size:12, color: "#9da3a9"}
                    }
                });

        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css( {
                position: 'absolute',
                display: 'none',
                top: y - 30,
                left: x - 50,
                color: "#fff",
                padding: '2px 5px',
                'border-radius': '6px',
                'background-color': '#000',
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }

        var previousPoint = null;
        $("#statsChart").bind("plothover", function (event, pos, item) {
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                            y = item.datapoint[1].toFixed(0);

                    var month = item.series.xaxis.ticks[item.dataIndex].label;

                    showTooltip(item.pageX, item.pageY,
                            item.series.label + " of " + month + ": " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
    });
</script>
</body>
</html>