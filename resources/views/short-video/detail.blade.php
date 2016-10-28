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
                <h1 class="title">详情</h1>
            </header>

            <!-- 这里是页面内容区 -->
            <div class="content">
                <div class="card demo-card-header-pic card-new" render-html="true">
                    <div valign="bottom" class="card-header color-white no-border no-padding">

                        <div class="video-card"
                             id="{{ $item->id }}"
                             data-poster="{{  $item->poster }}"
                             data-src="{{$item->url }}"
                             data-title="{{$item->title }}"
                                >
                        </div>
                    </div>
                    <div class="card-content video-title">
                        <div class="card-content-inner">
                                {{ $item->title }}
                        </div>
                    </div>
                    <div class="card-footer card-bottom">
                        @foreach($item->tags as $tag)
                            <a class="tag-item">{{ $tag->name }}</a>
                        @endforeach

                        {{--<a href="#" class="link">--}}
                            {{--<span class="icon icon-message"></span>--}}
                            {{--12--}}
                        {{--</a>--}}
                        {{--<a href="#" class="link">--}}
                            {{--<span class="icon icon-star"></span>--}}
                            {{--12--}}
                        </a>
                    </div>
                </div>

                <div style="width:95%;margin:0 auto;">
                    <div class="ds-thread" data-thread-key="{{ $item->id }}" data-title="{{ $item->title }}" data-url="{{ action('ShortVideoController@getDetail',['id'=>$item->id]) }}"></div>
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
            var svs = $$.svs();
            svs.renderHtml();
        })
    </script>
@stop