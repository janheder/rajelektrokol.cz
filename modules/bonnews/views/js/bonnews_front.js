/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta News Manager with Videos and Comments
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

$(document).ready(function () {
  if (
    typeof BON_NEWS_DISPLAY_CAROUSEL != 'undefined' &&
    BON_NEWS_DISPLAY_CAROUSEL
  ) {
    if (BON_NEWS_CAROUSEL_DOTS == 1) {
      var BON_NEWS_CAROUSEL_DOTS_SCRIPT = true;
    } else {
      var BON_NEWS_CAROUSEL_DOTS_SCRIPT = false;
    }
    if (BON_NEWS_CAROUSEL_NAV == 1) {
      var BON_NEWS_CAROUSEL_NAV_SCRIPT = true;
    } else {
      var BON_NEWS_CAROUSEL_NAV_SCRIPT = false;
    }
    if (BON_NEWS_CAROUSEL_LOOP == 1) {
      var BON_NEWS_CAROUSEL_LOOP_SCRIPT = true;
    } else {
      var BON_NEWS_CAROUSEL_LOOP_SCRIPT = false;
    }
    $('#bonnews .news-slider.home').slick({
      infinite: BON_NEWS_CAROUSEL_LOOP_SCRIPT,
      dots: BON_NEWS_CAROUSEL_DOTS_SCRIPT,
      arrows: BON_NEWS_CAROUSEL_NAV_SCRIPT,
      autoplay: false,
      slidesToShow: BON_NEWS_CAROUSEL_NB,
      slidesToScroll: 1,
      draggable: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false
          }
        },
        {
          breakpoint: 1024,
          settings: {
            slidesToScroll: 1,
            slidesToShow: 2,
            arrows: false
          }
        }
      ]
    });
  }
});

let videoBonnews = $('#bonnews-video-element');

function playVideo() {
  $(videoBonnews).get(0).play();
}

function pauseVideo() {
  $(videoBonnews).get(0).pause();
}

$('#bonnews-video').on('shown.bs.modal', function () {
  playVideo();
});
$('#bonnews-video').on('hide.bs.modal', function () {
  pauseVideo();
});
