@foreach($items as $item)
<div class="card demo-card-header-pic card-new" render-html="true">
    <div valign="bottom" class="card-header color-white no-border no-padding">

        <img src="{{ $item->poster }}" style="position: absolute;top:0;left:0;width: 100%;height:100%;z-index: 99;" />
        <div class="video-card" style="z-index: 5"
             id="{{ $item->id }}"
             data-poster="{{  $item->poster }}"
             data-src="{{$item->url }}"
             data-title="{{$item->title }}"
             data-click-count-url="{{ action('ShortVideoController@postClickCount',['id'=>$item->id]) }}"
                >
        </div>
    </div>
    <div class="card-content video-title">
        <div class="card-content-inner">
            <a
               {{--href="javascript:void(0)" --}}
               class="card-detail"
               external
               href="{{ action('ShortVideoController@getDetail',['id' => $item->id ]) }}"  >
                {{ $item->title }}
            </a>
        </div>
    </div>
    <div class="card-footer card-bottom">

        <div class="tags">
            @foreach($item->tags as $tag)
                <a class="tag-item" external href="{{ action('TagController@getTagDetail',['id'=>$tag->id]) }}">{{ $tag->name }}</a>
            @endforeach
        </div>

        <div class="link-item">
            <a  class="link "
                data-no-cache="true"
                external
                href="{{ action('ShortVideoController@getDetail',['id' => $item->id ]) }}">
                <span class="fa fa-comment-o"></span>
                12
            </a>
            <a href="#" class="link">
                <span class=" fa fa-eye"></span>
                {{ $item->click_count }}
            </a>
        </div>
    </div>
</div>
@endforeach

@section('bottom-scripts')
    <script>
        $$(function(){
            $$(document).on('click','.card-new img',function(){
                console.info('te')
                $$(this).hide();
            })
        })
    </script>

@stop