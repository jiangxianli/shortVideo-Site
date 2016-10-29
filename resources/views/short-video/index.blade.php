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
                <a class="icon icon-app pull-right" href="{{ action('TagController@getTagPage') }}" external></a>
            </header>


            <!-- 这里是页面内容区 -->
            <div class="content infinite-scroll infinite-scroll-bottom pull-to-refresh-content" data-distance="100" data-ptr-distance="55">

                <!-- 默认的下拉刷新层 -->
                <div class="pull-to-refresh-layer">
                    <div class="preloader"></div>
                    <div class="pull-to-refresh-arrow"></div>
                </div>

                <div class="content-block card-items-block">
                    <div class="card-items">

                    </div>

                </div>

                <!-- 加载提示符 -->
                <div class="infinite-scroll-preloader">
                    <div class="preloader"></div>
                </div>
            </div>

        </div>

    </div>

    <!-- popup, panel 等放在这里 -->
    <div class="panel-overlay"></div>

@stop

@section('bottom-scripts')
    <script>
        $(function () {
            var url = "{{ action('ShortVideoController@postNormalList') }}";
            var svs = $$.svs();
            var params = {_token:"{{ csrf_token() }}",page: svs.getDefault().curPage, not_in_item: svs.getDefault().notInItem}
            svs.getNormalList(url, 'POST', params);
            svs.initScroll(function () {
                params = {_token:"{{ csrf_token() }}",page: svs.getDefault().curPage, not_in_item: svs.getDefault().notInItem}
                svs.getNormalList(url, 'POST', params);
            });
            svs.pullToRefresh(function(){
                params = {_token:"{{ csrf_token() }}",page: svs.getDefault().curPage, not_in_item: svs.getDefault().notInItem}
                svs.getNormalList(url, 'POST', params,'before');
            })

        })
    </script>
@stop