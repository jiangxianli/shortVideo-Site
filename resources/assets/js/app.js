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


    $$.extend({

        svs: function (_opt) {
            var _this = this;
            var _default = {
                curPage: 1, //当前页码
                notInItem: Array(), //排除项ID
                cardItemsWrapper: '.card-items', //视频项外层DIV
                hasMore: true, //是否加载完
                curPlayVideo: null, //当前播放视频
                cardItem: '.card-new', //新增视频项
                infiniteScroll: '.infinite-scroll-bottom', //无限滚动
                watchItems: Array(), //观看历史项
                pullToRefresh: '.pull-to-refresh-content', //下拉刷新

            };
            _default = $$.extend(_default, _opt);

            //设置默认参数
            _this.setDefault = function (_opt) {
                _default = $$.extend(_default, _opt);
            };
            //获取默认参数
            _this.getDefault = function () {
                return _default;
            };
            //观看历史
            _this.getWatchCache = function () {
                if (window.localStorage) {
                    var items = localStorage.getItem('watch-record')
                    if (items) {
                        items = JSON.parse(items);
                    } else {
                        items = [];
                    }
                    return items;
                }
            };
            //加入观看历史列表
            _this.watchRecord = function (id) {
                if (window.localStorage) {
                    _default.watchItems = localStorage.getItem('watch-record')
                    if (_default.watchItems) {
                        _default.watchItems = JSON.parse(_default.watchItems);
                    } else {
                        _default.watchItems = [];
                    }

                    _default.watchItems.push(id)
                    localStorage.setItem('watch-record', JSON.stringify(_default.watchItems))
                }
            };
            //获取视频列表
            _this.getNormalList = function getNormalList(url, method, prams, appendPosition) {
                $.ajax({
                    url: url,
                    type: method,
                    data: prams,
                    success: function (response) {
                        if (appendPosition == 'before') {
                            $(_default.cardItemsWrapper).prepend(response.view)
                        } else {
                            $(_default.cardItemsWrapper).append(response.view)
                        }

                        _this.renderHtml();
                        _default.curPage++;
                        if (response.current_page >= response.last_page) {
                            _default.hasMore = false;
                            $(_default.infiniteScroll).trigger('infinite')
                        }
                    }
                })
            };
            //增加视频播放次数
            _this.incrementClickCount = function (url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {},
                    success: function (response) {

                    }
                })
            };
            //渲染视频列表HTML
            _this.renderHtml = function () {
                $(_default.cardItem).each(function (i, item) {
                    var _item = $(item);
                    if (_item.find('video').length == 0) {
                        var card = _item.find('.video-card')
                        _item.removeAttr('render-html');
                        _default.notInItem.push(card.attr('id'))
                        card.css({'width': _item.outerWidth()});
                        var video = new ZdVideo({
                            container: card.attr('id'),
                            //source: card.attr('data-src'),
                            poster: card.attr('data-poster'),
                            title: card.attr('data-title'),
                            width: parseInt(_item.outerWidth()),
                            height: 200,
                            clickFun: function () {
                                if (!video.video.src) {
                                    video.video.src = card.attr('data-src');
                                    video.video.load();
                                    _this.incrementClickCount(card.attr('data-click-count-url'))
                                }
                            },
                            playingFun: function () {

                                if (_default.curPlayVideo && _default.curPlayVideo != video.video) {
                                    _default.curPlayVideo.pause();
                                }
                                _default.curPlayVideo = video.video;
                                _this.watchRecord(card.attr('id'))
                            }
                        });
                    }

                });

            };
            //无限滚动
            _this.initScroll = function (callback) {

                // 注册'infinite'事件处理函数
                $(document).on('infinite', _default.infiniteScroll, function () {

                    // 如果正在加载，则退出
                    if (_default.loading) return;

                    // 设置flag
                    _default.loading = true;

                    // 模拟1s的加载过程
                    setTimeout(function () {
                        // 重置加载flag
                        _default.loading = false;

                        if (_default.hasMore == false) {
                            // 加载完毕，则注销无限加载事件，以防不必要的加载
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            // 删除加载提示符
                            $('.infinite-scroll-preloader').remove();
                            return;
                        }

                        callback();
                        // 添加新条目
                        // getNormalList(curPage, notInItem);
                        // 更新最后加载的序号
                        //lastIndex = $('.list-container li').length;
                        //容器发生改变,如果是js滚动，需要刷新滚动
                        $.refreshScroller();
                    }, 1000);

                });
            };
            //下拉刷新
            _this.pullToRefresh = function (callback) {
                // 添加'refresh'监听器
                $(document).on('refresh', _default.pullToRefresh, function (e) {
                    // 模拟2s的加载过程
                    setTimeout(function () {
                        callback();
                        // 加载完毕需要重置
                        $.pullToRefreshDone(_default.pullToRefresh);
                    }, 2000);
                });
            }

            return _this;
        }

    });

    $.init();
    //$(document).on('click', 'a.card-detail', function () {
    //    $.router.load($(this).attr('data-href'),true);
    //})

});
