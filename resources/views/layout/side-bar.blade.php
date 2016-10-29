<!-- Left Panel with Reveal effect -->
<div class="panel panel-left panel-reveal">
    <div class="content-block">

        <div class="login-user">
            @if(\Auth::check())
                <img src="{{ \Auth::user()->image_url ? \Auth::user()->image_url : '/images/missing_face.png' }}"/>
                <b>{{ \Auth::user()->nick_name }}</b>
            @else
                <a data-no-cache="true"
                   class="close-panel"
                   href="{{ action('UserController@getLoginPage') }}">
                    <img src="/images/missing_face.png"/>
                    <b>请登陆</b>
                </a>
            @endif
        </div>

        <ul class="side-bar-link">
            <li>
                <a data-no-cache="true"
                   class="close-panel"
                   href="/">热门推荐</a>
            </li>
            <li>
                <a data-no-cache="true"
                   class="close-panel"
                   href="{{ action('TagController@getTagPage') }}">标签库</a>
            </li>
            <li>
                <a data-no-cache="true"
                   class="close-panel"
                   href="{{ action('UserController@getWatchHistoryPage') }}">历史观看</a>
            </li>
            <li>
                <a data-no-cache="true"
                   class="close-panel"
                   href="{{ action('UserController@getLoginPage') }}">
                    更换账号
                </a>
            </li>
        </ul>

        <!-- Click on link with "close-panel" class will close panel -->
        {{--<p><a href="#" class="close-panel">关闭</a></p>--}}
    </div>
</div>
