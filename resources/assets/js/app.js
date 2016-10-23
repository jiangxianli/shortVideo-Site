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
    function getNormalList(curPage,notInItem){

        $.ajax({
            url:'/normal-list',
            method:'GET',
            data:{ page : curPage , not_in_item : notInItem},
            success:function(response){
                cardItems.append(response)
                renderVideo();
                curPage++;
            }
        })
    }

    function renderVideo(){

        $('.card-new').each(function (i, item) {
            var _this = $(item);
            var card = _this.find('.video-card')
            //if(_this.find('video')){
            //    return ;
            //}
            _this.removeClass('card-new');
            notInItem.push(card.attr('id'))
            console.info(card.attr('id'))
            card.css({'width':_this.outerWidth()});
            //console.info(cardHeadr.width())
            //console.info(_this.attr('data-id'))
            var video = new ZdVideo({
                container: card.attr('id'),
                source: card.attr('data-src'),
                poster: card.attr('data-poster'),
                width : parseInt(_this.outerWidth()),
                height:200,
                //preload : true,
                clickFun: function () {
                    console.info(video.video.src)
                    if (!video.video.src) {
                        video.video.src = url;
                        video.video.load();
                    }
                },
                playingFun: function () {
                    //playingFun(video)
                }
            });
        });

    }

    getNormalList(1,notInItem);


    // 加载flag
    var loading = false;
    // 最多可加载的条目
    var maxItems = 100;

    // 每次加载添加多少条目
    var itemsPerLoad = 20;


    // 上次加载的序号

    var lastIndex = 20;

    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom',function() {

        // 如果正在加载，则退出
        if (loading) return;

        // 设置flag
        loading = true;

        // 模拟1s的加载过程
        setTimeout(function () {
            // 重置加载flag
            loading = false;

            //if (lastIndex >= maxItems) {
            //    // 加载完毕，则注销无限加载事件，以防不必要的加载
            //    $.detachInfiniteScroll($('.infinite-scroll'));
            //    // 删除加载提示符
            //    $('.infinite-scroll-preloader').remove();
            //    return;
            //}

            // 添加新条目
            getNormalList(curPage, notInItem);
            // 更新最后加载的序号
            //lastIndex = $('.list-container li').length;
            //容器发生改变,如果是js滚动，需要刷新滚动
            $.refreshScroller();
        }, 1000);

    })


});
