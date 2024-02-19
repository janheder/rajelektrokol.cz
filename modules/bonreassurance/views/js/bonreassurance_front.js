/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Customer Reassurance With Icons
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
  if (BON_REAS_CAROUSEL_DOTS == 1) {
    var BON_REAS_CAROUSEL_DOTS_SCRIPT = true;
  } else {
    var BON_REAS_CAROUSEL_DOTS_SCRIPT = false;
  }
  if (BON_REAS_CAROUSEL_NAV == 1) {
    var BON_REAS_CAROUSEL_NAV_SCRIPT = true;
  } else {
    var BON_REAS_CAROUSEL_NAV_SCRIPT = false;
  }
  if (BON_REAS_CAROUSEL_LOOP == 1) {
    var BON_REAS_CAROUSEL_LOOP_SCRIPT = true;
  } else {
    var BON_REAS_CAROUSEL_LOOP_SCRIPT = false;
  }

  $('.slick-carousel-bonreassurance.horizontal').slick({
    infinite: BON_REAS_CAROUSEL_LOOP_SCRIPT,
    autoplaySpeed: 5000,
    draggable: true,
    dots: BON_REAS_CAROUSEL_DOTS_SCRIPT,
    arrows: BON_REAS_CAROUSEL_NAV_SCRIPT,
    autoplay: true,
    slidesToShow: BON_REAS_CAROUSEL_NB,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 320,
        settings: {
          slidesToShow: 2,
          arrows: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          arrows: false
        }
      },
      {
        breakpoint: 1000,
        settings: {
          slidesToShow: 3,
        }
      }
    ]
  });
});
