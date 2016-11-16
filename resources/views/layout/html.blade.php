<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="keywords" content="小视频,搞笑视频,短视频,恶搞,爆笑,妹纸"/>
    <meta name="description" content="@yield('title')" />

    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css?t={{ time() }}">
    @yield('top-styles')
    @yield('top-scripts')
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?689a3ee181d16835d76122907a36636e";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body>
@yield('body')

@include('layout.side-bar')

<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
<script>
    var $$ = $.noConflict();
</script>
<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
{{--<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>--}}
<script type="text/javascript" src="/js/app.js?t={{ time() }}"></script>

@yield('bottom-scripts')

<script>
    var duoshuoQuery = {
        short_name: "jiangxianli",
        sso: {
            login: "{{ action('ApiController@getLogin') }}",//替换为你自己的回调地址
            logout: "{{ action('ApiController@getLogout') }}"//替换为你自己的回调地址
        }
    };
    (function () {
        var ds = document.createElement('script');
        ds.type = 'text/javascript';
        ds.async = true;
        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
        ds.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0]
        || document.getElementsByTagName('body')[0]).appendChild(ds);
    })();
</script>
</body>
</html>
