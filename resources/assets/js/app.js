/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

//Vue.component('example', require('./components/Example.vue'));
//
//const app = new Vue({
//    el: '#app'
//});


$(function () {

    var curPage = 1;
    var notInItem = Array();
    var cardItems = $('.card-items');
    var hasMore = true;
    var curPlayVideo = null;

    function getNormalList(page, notInItem) {

        $.ajax({
            url: '/normal-list',
            method: 'GET',
            data: {page: page, not_in_item: notInItem},
            success: function (response) {
                cardItems.append(response.view)
                renderVideo();
                curPage++;
                if(response.current_page == response.last_page){
                    hasMore = false;
                }
            }
        })
    }
    renderVideo();
    //渲染视频
    function renderVideo() {
        $('.card-new').each(function (i, item) {
            var _this = $(item);
            console.info(_this.find('video').length)
            if(_this.find('video').length == 0){
                var card = _this.find('.video-card')
                _this.removeAttr('render-html');
                notInItem.push(card.attr('id'))
                card.css({'width': _this.outerWidth()});
                var video = new ZdVideo({
                    container: card.attr('id'),
                    //source: card.attr('data-src'),
                    poster: card.attr('data-poster'),
                    title: card.attr('data-title'),
                    width: parseInt(_this.outerWidth()),
                    height: 200,
                    clickFun: function () {
                        if (!video.video.src) {
                            video.video.src = card.attr('data-src');
                            video.video.load();
                        }
                    },
                    playingFun: function () {

                        if(curPlayVideo && curPlayVideo != video.video){
                            curPlayVideo.pause();
                        }
                        curPlayVideo = video.video;
                    }
                });
            }

        });

    }

    getNormalList(1, notInItem);


    // 加载flag
    var loading = false;

    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom', function () {

        // 如果正在加载，则退出
        if (loading) return;

        // 设置flag
        loading = true;

        // 模拟1s的加载过程
        setTimeout(function () {
            // 重置加载flag
            loading = false;

            if (hasMore == false) {
                // 加载完毕，则注销无限加载事件，以防不必要的加载
                $.detachInfiniteScroll($('.infinite-scroll'));
                // 删除加载提示符
                $('.infinite-scroll-preloader').remove();
                return;
            }

            // 添加新条目
            getNormalList(curPage, notInItem);
            // 更新最后加载的序号
            //lastIndex = $('.list-container li').length;
            //容器发生改变,如果是js滚动，需要刷新滚动
            $.refreshScroller();
        }, 1000);

    });

    $(document).on('click','a.card-detail',function(){
        $.router.load($(this).attr('data-href'));
    })


    $.init();


});
