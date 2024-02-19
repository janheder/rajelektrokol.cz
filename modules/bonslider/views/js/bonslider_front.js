/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Slider Manager with Photos and Videos
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */
$( window ).load(function() {
  var player = document.getElementById('video-element');
  let numberSlides = $('#bonslider .swiper-slide').length;

  if (BON_SLIDER_CAROUSEL_AUTOPLAY == 1) {
    var BON_CAROUSEL_TIME = BON_SLIDER_CAROUSEL_AUTOPLAYTIME;
  } else {
    var BON_CAROUSEL_TIME = 9999999999999999;
  }
  if (BON_SLIDER_CAROUSEL_LOOP == 1) {
    var BON_SLIDER_CAROUSEL_LOOP_SCRIPT = true;
  } else {
    var BON_SLIDER_CAROUSEL_LOOP_SCRIPT = false;
  }
  if (BON_SLIDER_CAROUSEL_DRAG == 1) {
    var BON_SLIDER_CAROUSEL_DRAG_MODE = true;
  } else {
    var BON_SLIDER_CAROUSEL_DRAG_MODE = false;
  }
  var swiper = new Swiper("#bonslider", {
    speed: 500,
    preloadImages: false,
    loop: BON_SLIDER_CAROUSEL_LOOP_SCRIPT,
    simulateTouch: BON_SLIDER_CAROUSEL_DRAG_MODE,
    parallax: true,
    effect: BON_SLIDER_CAROUSEL_ANIMATION,
    fadeEffect: {
      crossFade: true
    },
    creativeEffect: {
      prev: {
        translate: [0, 0, -400],
      },
      next: {
        translate: ['100%', 0, 0],
      },
    },
    autoplay: {
      delay: BON_CAROUSEL_TIME,
    },

    navigation: {
      nextEl: "#bonslider .bonslider-button-next",
      prevEl: "#bonslider .bonslider-button-prev",
    },

    pagination: {
      el: "#bonslider .bonslider-pagination",
      clickable: true,
      renderBullet: function (index, className) {
        return "<span class=\"swiper-pagination-bullet swiper-pagination-bullet-active\" tabindex=\"0\" role=\"button\"><svg viewBox=\"0 0 36 36\" class=\"circular-chart\"><path class=\"circle\" stroke-dasharray=\"100, 100\" d=\"M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831\"/</svg></span>";
      },
    },

    on: {
      init: function () {
        $('.bonslider-item-description').css('opacity', '1');
      },
      activeIndexChange: function () {
        if (player != null) {
          btnMute.removeAttribute('title');
          btnPlayPause.removeAttribute('title');

          var slideActive = $('.swiper-slide-active');
          var realIndex = slideActive.data('swiper-slide-index') + 1;
          if (typeof realIndex === 'undefined') {
            realIndex = slideActive.index() + 1;
          }
          let vid = this.slides[this.activeIndex];


          if ($(vid).children('#video-container').hasClass('video-container')) {
            if ($('#btnPlayPause').hasClass('play') || $('#btnPlayPause').hasClass('pause')) {
              $('#btnPlayPause').trigger('click');
            } else {
              $('.pause').trigger('click');
            }
            $('.bonslider-button-prev').addClass('white-arrow');
            $('.bonslider-button-next').addClass('white-arrow');
          } else {
            $('.pause').trigger('click');
            $('.bonslider-button-prev').removeClass('white-arrow');
            $('.bonslider-button-next').removeClass('white-arrow');
          }
        }
      }
    },
  });
  removeVideoMobile(swiper);
  $(window).resize(function () {
    removeVideoMobile(swiper);
  });
});

var player = document.getElementById('video-element');
var btnPlayPause = document.getElementById('btnPlayPause');
var btnMute = document.getElementById('btnMute');

if (player != null) {
  playVideo();
}

function playVideo() {
  player.addEventListener('play', function() {
    changeButtonType(btnPlayPause, 'pause');
  }, false);

  player.addEventListener('pause', function() {
    changeButtonType(btnPlayPause, 'play');
  }, false);


  player.addEventListener('ended', function() {
    this.pause();
  }, false);
}

function playPauseVideo() {
  if (player.paused || player.ended) {
    changeButtonType(btnPlayPause, 'pause');
    player.play();
  } else {
    changeButtonType(btnPlayPause, 'play');
    player.pause();
  }
}

function stopVideo() {
  player.pause();
  if (player.currentTime) player.currentTime = 0;
}

function muteVolume() {
  if (player.muted) {
    // Change the button to a mute button
    changeButtonType(btnMute, 'mute');
    player.muted = false;
  } else {
    // Change the button to an unmute button
    changeButtonType(btnMute, 'unmute');
    player.muted = true;
  }
}

function changeButtonType(btn, value) {
  btn.innerHTML = value;
  btn.className = value;
}

function removeVideoMobile(swiper) {
  if ($(window).width() <= '575') {
    for (let i = 0; i < $('#bonslider .swiper-slide').length; i++) {
      let videoMobile = $('#video-container').parent();
      let index = videoMobile.attr('data-swiper-slide-index');
      swiper.removeSlide(index);
    }
  }
}