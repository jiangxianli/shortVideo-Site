@extends('layout.html')

@section('title')
    #{{ $tag->name }}#
@stop
@section('body')
    <!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
    <div class="page-group">
        <!-- 单个page ,第一个.page默认被展示-->
        <div class="page page-current">
            <!-- 标题栏 -->
            <header class="bar bar-nav page-title">
                <a class="icon icon-me pull-left open-panel"></a>
                <h1 class="title">#{{ $tag->name }}#</h1>
                <a class="icon icon-app pull-right" href="{{ action('TagController@getTagPage') }}" external></a>
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

        </div>

    </div>

    <!-- popup, panel 等放在这里 -->
    <div class="panel-overlay"></div>

@stop

@section('bottom-scripts')
    <script>
        $(function () {
            var url = "{{ action('TagController@postTagVideoList',['id'=>$tag->id]) }}";
            var svs = $$.svs();
            var params = {_token:"{{ csrf_token() }}",tag_id: "{{ $tag->id }}" ,page: svs.getDefault().curPage, not_in_item: svs.getDefault().notInItem}
            svs.getNormalList(url, 'POST', params);
            svs.initScroll(function () {
                params = {_token:"{{ csrf_token() }}",tag_id: "{{ $tag->id }}",page: svs.getDefault().curPage, not_in_item: svs.getDefault().notInItem}
                svs.getNormalList(url, 'POST', params);
            });

        })
    </script>
@stop