@extends('layout.html')

@section('title')
    标签
@stop
@section('body')
    <!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
    <div class="page-group">
        <!-- 单个page ,第一个.page默认被展示-->
        <div class="page page-current">
            <!-- 标题栏 -->
            <header class="bar bar-nav page-title">
                <a class="icon icon-left pull-left back"></a>
                <h1 class="title">标签</h1>
            </header>

            <!-- 这里是页面内容区 -->
            <div class="content infinite-scroll infinite-scroll-bottom" data-distance="100" style="background: #fff">

                <ul class="tag-items">

                </ul>

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
        $(function(){
            var url = "{{ action('TagController@postTagList') }}";
            var svs = $$.svs({
                cardItemsWrapper: '.tag-items'
            });
            var params = {_token:"{{ csrf_token() }}",page: 1, not_in_items: svs.getDefault().notInItem}
            svs.getNormalList(url, 'POST', params);
            svs.initScroll(function () {
                params = {_token:"{{ csrf_token() }}",page: 1, not_in_items: svs.getDefault().notInItem}
                svs.getNormalList(url, 'POST', params);
            });
        })
    </script>
@stop