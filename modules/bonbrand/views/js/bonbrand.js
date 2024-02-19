/*
 * 2015-2020 Bonpresta
 *
 * Bonpresta Brand Manager
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
 *  @copyright 2015-2020 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

$(document).ready(function () {
  if (typeof m_display_caroucel != 'undefined' && m_display_caroucel) {
    if (m_caroucel_dots == 1) {
      var BON_BRAND_CAROUSEL_DOTS_SCRIPT = true;
    } else {
      var BON_BRAND_CAROUSEL_DOTS_SCRIPT = false;
    }
    if (m_caroucel_nav == 1) {
      var BON_BRAND_CAROUSEL_NAV_SCRIPT = true;
    } else {
      var BON_BRAND_CAROUSEL_NAV_SCRIPT = false;
    }
    if (m_caroucel_loop == 1) {
      var BON_BRAND_CAROUSEL_LOOP_SCRIPT = true;
    } else {
      var BON_BRAND_CAROUSEL_LOOP_SCRIPT = false;
    }

    $('.bonbrand-slider').slick({
      slidesToShow: m_caroucel_nb,
      slidesToScroll: 1,
      infinite: BON_BRAND_CAROUSEL_LOOP_SCRIPT,
      dots: BON_BRAND_CAROUSEL_DOTS_SCRIPT,
      arrows: BON_BRAND_CAROUSEL_NAV_SCRIPT,
      autoplay: true,
      speed: 1100,
      responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow: 6,
            arrows: false
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 4,
            arrows: false
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 3,
            arrows: false
          }
        }
      ]
    });
  }
});
