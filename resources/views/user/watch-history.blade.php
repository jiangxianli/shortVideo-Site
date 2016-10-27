@extends('layout.html')

@section('title')
    小视频
@stop
@section('body')
    <!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
    <div class="page-group">
        <!-- 单个page ,第一个.page默认被展示-->
        <div class="page page-current">
            <!-- 标题栏 -->
            <header class="bar bar-nav page-title">
                <a class="icon icon-me pull-left open-panel"></a>
                <h1 class="title">小视频</h1>
            </header>

            <!-- 这里是页面内容区 -->
            <div class="content infinite-scroll infinite-scroll-bottom" data-distance="100">
                <div class="content-block card-items-block">
                    <div class="card-items">

                    </div>

                </div>

                <!-- 加载提示符 -->
                <div class="infinite-scroll-preloader">
                    <div class="preloader"></div>
                </div>
            </div>


            <!-- 工具栏 -->
            {{--<nav class="bar bar-tab">--}}
                {{--<a class="tab-item external active" href="#">--}}
                    {{--<span class="icon icon-home"></span>--}}
                    {{--<span class="tab-label">首页</span>--}}
                {{--</a>--}}
                {{--<a class="tab-item external" href="#">--}}
                    {{--<span class="icon icon-star"></span>--}}
                    {{--<span class="tab-label">收藏</span>--}}
                {{--</a>--}}
                {{--<a class="tab-item external" href="#">--}}
                    {{--<span class="icon icon-settings"></span>--}}
                    {{--<span class="tab-label">设置</span>--}}
                {{--</a>--}}
            {{--</nav>--}}
        </div>

        <!-- 其他的单个page内联页（如果有） -->
        <div class="page">...</div>
    </div>

    <!-- popup, panel 等放在这里 -->
    <div class="panel-overlay"></div>

@stop

@section('bottom-scripts')
    <script>

    </script>
@stop