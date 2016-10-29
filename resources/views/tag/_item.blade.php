@foreach($tags as $tag)
<li>
    <a class="tag-item" external href="{{ action('TagController@getTagDetail',['id'=>$tag->id]) }}">
        {{ $tag->name }}( {{ $tag->shortVideoCount() }})
    </a>
</li>
@endforeach