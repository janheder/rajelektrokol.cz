/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Category Products with Tabs and Carousel on Home Page
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
  $('.img-content span.loading').removeClass('loading');
  if (
    typeof PRODUCT_CATEGORY_DISPLAY_CAROUCEL != "undefined" &&
    PRODUCT_CATEGORY_DISPLAY_CAROUCEL
  ) {
    if (PRODUCT_CATEGORY_CAROUSEL_AUTOPLAY == 1) {
      var PRODUCT_CATEGORY_TIME = PRODUCT_CATEGORY_CAROUSEL_TIME;
    } else {
      var PRODUCT_CATEGORY_TIME = 9999999999999999;
    }
    if (PRODUCT_CATEGORY_CAROUCEL_LOOP == 1) {
      var PRODUCT_CATEGORY_CAROUCEL_LOOP_SCRIPT = true;
    } else {
      var PRODUCT_CATEGORY_CAROUCEL_LOOP_SCRIPT = false;
    }
    if (PRODUCT_CATEGORY_CAROUSEL_DRAG == 1) {
      var PRODUCT_CATEGORY_CAROUSEL_DRAG_SCRIPT = false;
    } else {
      var PRODUCT_CATEGORY_CAROUSEL_DRAG_SCRIPT = true;
    }

    $(".boncategoryproduct-swiper").each(function (index) {
      let prevBut = $(this).find(".swiper-button-prev").attr("data-nav");
      let nextBut = $(this).find(".swiper-button-next").attr("data-nav");

      var swiper = new Swiper(this, {
        speed: 1100,
        preloadImages: false,
        loop: false,
        cssMode: PRODUCT_CATEGORY_CAROUSEL_DRAG_SCRIPT,
        spaceBetween: 20,
        autoplay: {
          delay: PRODUCT_CATEGORY_TIME,
        },
        navigation: {
          nextEl: `[data-nav=${nextBut}]`,
          prevEl: `[data-nav=${prevBut}]`,
        },
        breakpoints: {
          320: {
            slidesPerView: 1,
          },
        },
      });
    });
  }

  $('.boncategoruproduct .tabs').css('opacity', '1');

  $(".tabs-wrapper").each(function () {
    let choiceTab = $(this);
    choiceTab.find(".tab-item").not(":first").hide();
    choiceTab
      .find(".tab")
      .click(function () {
        choiceTab
          .find(".tab")
          .removeClass("active")
          .eq($(this).index())
          .addClass("active");
        choiceTab.find(".tab-item").hide().eq($(this).index()).fadeIn();
      })
      .eq(0)
      .addClass("active");
  });
});