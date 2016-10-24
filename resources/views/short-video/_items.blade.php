@foreach($items as $item)
<div class="card demo-card-header-pic card-new">
    <div valign="bottom" class="card-header color-white no-border no-padding">

        <div class="video-card"
             id="{{ $item->id }}"
             data-poster="{{  $item->poster }}"
             data-src="{{$item->url }}"
                >
        </div>
    </div>
    <div class="card-content video-title">
        <div class="card-content-inner">
            <p class="">
                {{ $item->title }}
            </p>
        </div>
    </div>
    <div class="card-footer card-bottom">
        @foreach($item->tags as $tag)
        <a class="tag-item">{{ $tag->name }}</a>
        @endforeach

        <a href="#" class="link">
            <span class="icon icon-message"></span>
            12
        </a>
        <a href="#" class="link">
            <span class="icon icon-star"></span>
            12
        </a>
    </div>
</div>
@endforeach