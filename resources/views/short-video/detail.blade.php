@extends('layout.html')

@section('title')
    {{ $item->title }}
@stop
@section('body')
    <!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
    <div class="page-group">
        <!-- 单个page ,第一个.page默认被展示-->
        <div class="page page-current">
            <!-- 标题栏 -->
            <header class="bar bar-nav page-title">
                <a class="icon icon-me pull-left open-panel"></a>
                <h1 class="title">{{ $item->title }}</h1>
            </header>


            <!-- 这里是页面内容区 -->
            <div class="content">
                <div class="card-new">
                    <div class="video-card"
                         id="{{ $item->id }}"
                         data-poster="{{  $item->poster }}"
                         data-src="{{$item->url }}"
                    >
                    </div>
                </div>
                <p class="">
                    {{ $item->title }}
                </p>

                <div class="ds-thread" data-thread-key="{{ $item->id }}" data-title="{{ $item->title }}" data-url="{{ action('ShortVideoController@getDetail',['id'=>$item->id]) }}"></div>
            </div>

        </div>
    </div>

    <!-- popup, panel 等放在这里 -->
    <div class="panel-overlay"></div>
    <!-- Left Panel with Reveal effect -->
    <div class="panel panel-left panel-reveal">
        <div class="content-block">
            <p>这是一个侧栏</p>

            @if(\Auth::check())
                {{ \Auth::user()->nick_name }}
            @else

                <p>
                <div class="ds-login"></div>
                </p>
            @endif
            <!-- Click on link with "close-panel" class will close panel -->
            <p><a href="#" class="close-panel">关闭</a></p>
        </div>
    </div>




@stop

@section('bottom-scripts')
    <script>

    </script>
@stop