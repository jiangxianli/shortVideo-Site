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
            <div class="content " >

                <div class="oauth2-login">
                    <span>请选择一种方式登陆</span>
                    <div class="ds-login"></div>
                </div>
            </div>


        </div>
    </div>

    <!-- popup, panel 等放在这里 -->
    <div class="panel-overlay"></div>

@stop

@section('bottom-scripts')
    <script>

    </script>
@stop