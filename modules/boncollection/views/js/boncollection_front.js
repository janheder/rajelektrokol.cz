/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Collection Manager with Photos and Videos
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

window.onload = function () {
  setTimeout(() => {
    collectionWrapperHeight();
  }, 500);
};

$(document).ready(function () {
  window.addEventListener('resize', function () {
    let idPage = $('#module-boncollection-collection');
    if (idPage != 'undefind' && idPage.length == 1) {
      let boncollectionItemsHeight = Math.ceil(
        ($('.boncollection-item').outerHeight() + 100) *
          $('.boncollection-item').length
      );
      $('.boncollection-items').css({
        height: boncollectionItemsHeight
      });
    }
    collectionWrapperHeight();
  });

  if (
    typeof BON_COLLECTION_DISPLAY_CAROUSEL != 'undefined' &&
    BON_COLLECTION_DISPLAY_CAROUSEL
  ) {
    if (BON_COLLECTION_CAROUSEL_DOTS == 1) {
      var BON_COLLECTION_CAROUSEL_DOTS_SCRIPT = true;
    } else {
      var BON_COLLECTION_CAROUSEL_DOTS_SCRIPT = false;
    }
    if (BON_COLLECTION_CAROUSEL_NAV == 1) {
      var BON_COLLECTION_CAROUSEL_NAV_SCRIPT = true;
    } else {
      var BON_COLLECTION_CAROUSEL_NAV_SCRIPT = false;
    }
    if (BON_COLLECTION_CAROUSEL_LOOP == 1) {
      var BON_COLLECTION_CAROUSEL_LOOP_SCRIPT = true;
    } else {
      var BON_COLLECTION_CAROUSEL_LOOP_SCRIPT = false;
    }
    // $('#boncollection .boncollection-slider.home').slick({
    //   infinite: BON_COLLECTION_CAROUSEL_LOOP_SCRIPT,
    //   dots: BON_COLLECTION_CAROUSEL_DOTS_SCRIPT,
    //   arrows: BON_COLLECTION_CAROUSEL_NAV_SCRIPT,
    //   autoplay: false,
    //   slidesToShow: BON_COLLECTION_CAROUSEL_NB,
    //   slidesToScroll: 1,
    //   draggable: false,
    //   responsive: [
    //     {
    //       breakpoint: 575,
    //       settings: {
    //         slidesToShow: 1,
    //         slidesToScroll: 1,
    //         arrows: false
    //       }
    //     },
    //     {
    //       breakpoint: 768,
    //       settings: {
    //         slidesToShow: 2,
    //         slidesToScroll: 1,
    //         arrows: false
    //       }
    //     },
    //     {
    //       breakpoint: 1024,
    //       settings: {
    //         slidesToScroll: 1,
    //         slidesToShow: 3,
    //         arrows: false
    //       }
    //     }
    //   ]
    // });
  }

  let video_collection = $('#boncollection-video-element');

  function playVideo() {
    video_collection.get(0).play();
  }

  function pauseVideo() {
    video_collection.get(0).pause();
  }

  $('#boncollection-video').on('shown.bs.modal', function () {
    playVideo();
  });
  $('#boncollection-video').on('hide.bs.modal', function () {
    pauseVideo();
  });
});

function collectionWrapperHeight() {
  let idPage = $('#module-boncollection-collection');
  if (idPage != 'undefind' && idPage.length == 1) {
    let boncollectionItemsHeight = Math.ceil(
      $('.boncollection-items').outerHeight() / 2 + 30
    );
    $('.boncollection-items').css({
      height: boncollectionItemsHeight
    });
  }
}
