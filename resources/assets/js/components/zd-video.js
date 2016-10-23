(function($, root) {
  // init video object
  function ZdVideo(opts) {
    opts = opts || {};
    if (!opts.container || !$('#' + opts.container)) {
      throw new Error('video container not found!')
    }
    if (!opts.source || opts.source.length == 0) {
      throw new Error('no video source found!')
    }
    this.opts = opts;
    this.container = $('#' + this.opts.container); //jquery obj
    this.tpl = null;
    this.init();
  }

  function _getVideoType(source) {
    var texts = source.split('.');
    var type = texts[texts.length -1];
    switch(type) {
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

  ZdVideo.prototype.setTpl = function() {
    var tpl = '\n<div class="zd-video">\n<div class="zd-video-control zd-video-big-play hide"></div>\n<video width="940" height="520"';
    if (this.opts.autoplay) {
      tpl += ' autoplay'
    }
    if (this.opts.loop) {
      tpl += ' loop'
    }
    if (this.opts.poster) {
      tpl += ' poster=' + this.opts.poster;
    }
    if (typeof this.opts.source === 'string') {
      tpl += ' src=' + this.opts.source;
    }

    tpl += '>\n';

    if (Array.isArray(this.opts.source) && this.opts.source.length > 0) {
      this.opts.source.forEach(function(item) {
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

  ZdVideo.prototype.setVideotDimensions = function() {
    if (!this.video) {
      this.video = this.container.find('video')[0];
    }
    var width = this.video.width;
    var height = this.video.height;
    this.container.css('width', width);

    if (!this.controls) {
      this.controls = this.container.find('.zd-video-controls');
    }

    this.controls.css('width', width - 0);

  };

  ZdVideo.prototype.setFullScreenStyle = function() {
    if (!this.video) {
      this.video = this.container.find('video')[0];
    }
    this.container.css({width: '100%', height: '100%'});
    this.video.setAttribute('width', '100%');
    this.video.setAttribute('height', '100%');
    this.controls.css('width', '90%');
  };

  ZdVideo.prototype.addEvents = function() {
    var self = this;

    var hoverTimeout = null;

    var obj = {};
    obj.video = this.container.find('video')[0];
    this.video = obj.video;

    obj.controls = this.container.find('.zd-video-controls');

    this.controls = obj.controls;
    obj.bigPlayBtn = this.container.find('.zd-video-big-play');
    obj.playBtn =  obj.controls.find('.zd-video-play');
    obj.pauseBtn = obj.controls.find('.zd-video-pause');
    obj.progressBar = obj.controls.find('.zd-video-progress-bar');
    obj.volumeCon = obj.controls.find('.zd-video-volume');
    obj.volumeBar = obj.controls.find('.zd-video-volume-bar');
    obj.fullScreenBtn = obj.controls.find('.zd-video-fullscreen');
    obj.videoTime = obj.controls.find('.zd-video-time');
    //play
    var playHandle = function(e) {
      obj.video.play();
      obj.playBtn.addClass('hide');
      obj.pauseBtn.removeClass('hide');
    }
    obj.playBtn.on('click', playHandle);
    obj.bigPlayBtn.on('click', playHandle);
    //pause
    obj.pauseBtn.on('click', function(e) {
      obj.video.pause();
      obj.playBtn.removeClass('hide');
      obj.pauseBtn.addClass('hide');
    });

    obj.video.addEventListener('timeupdate', function() {
      //time change
      obj.secs = parseInt(obj.video.currentTime % 60, 10);
      obj.mins = parseInt((obj.video.currentTime/60) % 60, 10);
      obj.secs = ('0' + obj.secs).slice(-2);
      obj.mins = ('0' + obj.mins).slice(-2);
      obj.videoTime.text(obj.mins + ':' + obj.secs);

      //progress bar change
      obj.percent = (100 / obj.video.duration) * obj.video.currentTime;
      if (obj.percent > 0) {
        obj.progressBar.width(obj.percent + '%');
      }
    }, false);


    obj.video.addEventListener('playing', function() {
      self.container.removeClass('zd-video-ispause');
      obj.playBtn.css('display', 'none');
      obj.pauseBtn.css('display', 'inline-block');
    }, false);

    obj.video.addEventListener('pause', function() {
      self.container.addClass('zd-video-ispause');
      obj.controls.addClass('show');
      obj.pauseBtn.css('display', 'none');
      obj.playBtn.css('display', 'inline-block');
    }, false);

    obj.video.addEventListener('click', function() {
      if (obj.video.paused) {
        obj.video.play();
      } else {
        obj.video.pause();
      }
    }, false);

    obj.video.addEventListener('mouseover', function() {
      obj.controls.addClass('show');
    }, false);

    obj.video.addEventListener('mouseout', function() {
      if (!obj.video.paused) {
      hoverTimeout = setTimeout(function() {
          obj.controls.removeClass('show');
        }, 1500);
      }
    }, false);

    obj.controls.on('mouseover', function(e) {
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
    obj.volumeCon.on('click', function(e) {
      var x = e.clientX;
      var offset = obj.volumeCon.offset();
      var width = obj.volumeCon.width();
      var ratio = (x-offset.left)/width;
      obj.video.volume = ratio;
      obj.volumeBar.css('width', (ratio * 100) + '%');
    });

    //full screen
    obj.fullScreenBtn.on('click', function(e) {
      launchFullScreen(self.video);
    });
  };

  ZdVideo.prototype.init = function() {
    this.setTpl();
    this.addEvents();
    this.setVideotDimensions();
  }

  ZdVideo.VERSION = '0.0.1';

  root.ZdVideo = ZdVideo;

})(jQuery, this);
