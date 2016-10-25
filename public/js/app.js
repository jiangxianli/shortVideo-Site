$(function () {
    var root = this
    // init video object
    function ZdVideo(opts) {
        opts = opts || {};
        if (!opts.container || !$('#' + opts.container)) {
            throw new Error('video container not found!')
        }
        //if (!opts.source || opts.source.length == 0) {
        //    throw new Error('no video source found!')
        //}
        this.opts = opts;
        this.container = $('#' + this.opts.container); //jquery obj
        this.tpl = null;
        this.init();
    }

    function _getVideoType(source) {
        var texts = source.split('.');
        var type = texts[texts.length - 1];
        switch (type) {
            case "mp4":
                return 'video/mp4';
            case 'wbbm':
                return 'video/webm';
            default:
                return ''
        }
    }

    function launchFullScreen(elem) {
        var requestFullScreen = elem.requestFullscreen || elem.msRequestFullscreen || elem.mozRequestFullScreen || elem.webkitRequestFullscreen;
        requestFullScreen.call(elem);
    }

    ZdVideo.prototype.setTpl = function () {

        var width = this.opts.width ? this.opts.width : 640;
        var height = this.opts.height ? this.opts.height : 320;
        var tpl = '\n<div class="zd-video">\n<div class="zd-video-control zd-video-big-play"></div>\n<video width="' + width + '" height="' + height + '"';
        if (this.opts.autoplay) {
            tpl += ' autoplay'
        }
        if (this.opts.loop) {
            tpl += ' loop'
        }
        if (this.opts.poster) {
            tpl += ' poster=' + this.opts.poster;
        }
        if (this.opts.source && typeof this.opts.source === 'string') {
            tpl += ' src=' + this.opts.source;
        }

        tpl += '>\n';

        if (this.opts.source && Array.isArray(this.opts.source) && this.opts.source.length > 0) {
            this.opts.source.forEach(function (item) {
                tpl += '<source src=' + item + ' type=' + _getVideoType(item) + '/>\n';
            });
        }
        tpl += '</video>\n';

        //add controls
        tpl += '<div class="zd-video-controls">\
                <div class="zd-video-progress">\
                  <div class="zd-video-progress-bar"></div>\
                </div>\
                <div class="zd-controls-body">\
                  <div class="zd-controls-left">\
                    <span class="zd-video-play zd-video-control"></span>\
                    <span class="zd-video-pause zd-video-control"></span>\
                    <span class="zd-video-time">00:00</span>\
                  </div>\
                  <div class="zd-controls-right">\
                    <span class="zd-video-control zd-video-mute"></span>\
                    <div class="zd-video-volume">\
                      <div class="zd-video-volume-bar"></div>\
                    </div>\
                    <span class="zd-video-control zd-video-fullscreen"></span>\
                  </div>\
                </div>\
              </div>';
        tpl += '</div>';

        this.container.append($(tpl));
    };

    ZdVideo.prototype.setVideotDimensions = function () {
        if (!this.video) {
            this.video = this.container.find('video')[0];
        }
        var width = this.video.width;
        var height = this.video.height;
        this.container.css('width', width);

        if (!this.controls) {
            this.controls = this.container.find('.zd-video-controls');
        }

        //this.controls.css('width', width - 0);

    };

    ZdVideo.prototype.setFullScreenStyle = function () {
        if (!this.video) {
            this.video = this.container.find('video')[0];
        }
        this.container.css({width: '100%', height: '100%'});
        this.video.setAttribute('width', '100%');
        this.video.setAttribute('height', '100%');
        this.controls.css('width', '90%');
    };

    ZdVideo.prototype.addEvents = function () {
        var self = this;

        var hoverTimeout = null;

        var obj = {};
        obj.video = this.container.find('video')[0];
        this.video = obj.video;

        obj.controls = this.container.find('.zd-video-controls');

        this.controls = obj.controls;
        obj.bigPlayBtn = this.container.find('.zd-video-big-play');
        obj.playBtn = obj.controls.find('.zd-video-play');
        obj.pauseBtn = obj.controls.find('.zd-video-pause');
        obj.progressBar = obj.controls.find('.zd-video-progress-bar');
        obj.volumeCon = obj.controls.find('.zd-video-volume');
        obj.volumeBar = obj.controls.find('.zd-video-volume-bar');
        obj.fullScreenBtn = obj.controls.find('.zd-video-fullscreen');
        obj.videoTime = obj.controls.find('.zd-video-time');
        //play
        var playHandle = function (e) {
            if(self.opts.clickFun){
                self.opts.clickFun(true)
            }
            obj.video.play();
            obj.playBtn.addClass('hide');
            obj.pauseBtn.removeClass('hide');
            obj.bigPlayBtn.addClass('hide');
        }
        obj.playBtn.on('click', playHandle);
        obj.bigPlayBtn.on('click', playHandle);
        //pause
        obj.pauseBtn.on('click', function (e) {
            obj.video.pause();
            obj.playBtn.removeClass('hide');
            obj.pauseBtn.addClass('hide');
            obj.bigPlayBtn.addClass('hide');
        });

        obj.video.addEventListener('timeupdate', function () {
            //time change
            obj.secs = parseInt(obj.video.currentTime % 60, 10);
            obj.mins = parseInt((obj.video.currentTime / 60) % 60, 10);
            obj.secs = ('0' + obj.secs).slice(-2);
            obj.mins = ('0' + obj.mins).slice(-2);
            obj.videoTime.text(obj.mins + ':' + obj.secs);

            //progress bar change
            obj.percent = (100 / obj.video.duration) * obj.video.currentTime;
            if (obj.percent > 0) {
                obj.progressBar.width(obj.percent + '%');
            }
        }, false);


        obj.video.addEventListener('playing', function () {
            self.container.removeClass('zd-video-ispause');
            obj.playBtn.css('display', 'none');
            obj.pauseBtn.css('display', 'inline-block');
            obj.bigPlayBtn.addClass('hide');
            if(self.opts.playingFun){
                self.opts.playingFun(true);
            }
        }, false);

        obj.video.addEventListener('pause', function () {
            self.container.addClass('zd-video-ispause');
            obj.controls.addClass('show');
            obj.pauseBtn.css('display', 'none');
            obj.playBtn.css('display', 'inline-block');
            obj.bigPlayBtn.removeClass('hide');
        }, false);

        obj.video.addEventListener('click', function () {
            if(self.opts.clickFun){
                self.opts.clickFun(true)
            }
            if (obj.video.paused) {
                obj.video.play();
            } else {
                obj.video.pause();
            }
        }, false);

        obj.video.addEventListener('mouseover', function () {
            obj.controls.addClass('show');
        }, false);

        obj.video.addEventListener('mouseout', function () {
            if (!obj.video.paused) {
                hoverTimeout = setTimeout(function () {
                    obj.controls.removeClass('show');
                }, 1500);
            }
        }, false);

        obj.controls.on('mouseover', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (hoverTimeout) {
                clearTimeout(hoverTimeout);
            }
            if (!obj.controls.hasClass('show')) {
                obj.controls.addClass('show');
            }
        });

        //volume set
        //
        obj.volumeCon.on('click', function (e) {
            var x = e.clientX;
            var offset = obj.volumeCon.offset();
            var width = obj.volumeCon.width();
            var ratio = (x - offset.left) / width;
            obj.video.volume = ratio;
            obj.volumeBar.css('width', (ratio * 100) + '%');
        });

        //full screen
        obj.fullScreenBtn.on('click', function (e) {
            launchFullScreen(self.video);
        });
    };

    ZdVideo.prototype.init = function () {
        this.setTpl();
        this.addEvents();
        this.setVideotDimensions();
    }

    ZdVideo.VERSION = '0.0.1';

    root.ZdVideo = ZdVideo;

})

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

    //渲染视频
    function renderVideo() {

        $('.card-new[render-html=false]').each(function (i, item) {
            var _this = $(item);
            if(_this.attr('render-html') == false){
                return ;
            }
            var card = _this.find('.video-card')
            _this.removeAttr('render-html');
            notInItem.push(card.attr('id'))
            card.css({'width': _this.outerWidth()});
            var video = new ZdVideo({
                container: card.attr('id'),
                //source: card.attr('data-src'),
                poster: card.attr('data-poster'),
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


    $.init();


});

//# sourceMappingURL=app.js.map
