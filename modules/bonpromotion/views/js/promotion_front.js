/**
 * 2015-2019 Bonpresta
 *
 * Promotion Discount Countdown Banner & Slider
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
 *  @copyright 2015-2019 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*/

$(document).ready(function(){
    if (typeof image_baseurl !== 'undefined' && typeof image !== 'undefined') {
        const backgroundVideo = new BackgroundVideo('.bonpromotion-video', {
          src: [`${image_baseurl}${image}`]             
        });
      }
    if(typeof(BON_PROMOTION_DISPLAY_CAROUSEL) != 'undefined' && BON_PROMOTION_DISPLAY_CAROUSEL) {

        if(BON_PROMOTION_CAROUSEL_DOTS == 1) {
            var BON_PROMOTION_CAROUSEL_DOTS_SCRIPT = true;
        } else {
            var BON_PROMOTION_CAROUSEL_DOTS_SCRIPT = false;
        }
        if(BON_PROMOTION_CAROUSEL_NAV == 1) {
            var BON_PROMOTION_CAROUSEL_NAV_SCRIPT = true;
        } else {
            var BON_PROMOTION_CAROUSEL_NAV_SCRIPT = false;
        }
        if(BON_PROMOTION_CAROUSEL_LOOP == 1) {
            var BON_PROMOTION_CAROUSEL_LOOP_SCRIPT = true;
        } else {
            var BON_PROMOTION_CAROUSEL_LOOP_SCRIPT = false;
        }
        if(BON_PROMOTION_CAROUSEL_AUTOPLAY == 1) {
            var BON_PROMOTION_CAROUSEL_AUTOPLAY_SCRIPT = true;
        } else {
            var BON_PROMOTION_CAROUSEL_AUTOPLAY_SCRIPT = false;
        }

        $('.slick-carousel-bonpromotion').slick({
                slidesToShow: BON_PROMOTION_CAROUSEL_NB,
                infinite: BON_PROMOTION_CAROUSEL_LOOP_SCRIPT,
                autoplaySpeed: BON_PROMOTION_CAROUSEL_MARGIN,
                draggable: true,
                dots: BON_PROMOTION_CAROUSEL_DOTS_SCRIPT,
                arrows: BON_PROMOTION_CAROUSEL_NAV_SCRIPT,
                autoplay: BON_PROMOTION_CAROUSEL_AUTOPLAY_SCRIPT,
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: BON_PROMOTION_CAROUSEL_NB,
                    }

                }, {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 3,
                    }


                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                    }
                }]
            }
        );
        $('#bonpromotion .slick-list').wrap('<div class="slick-list-wrap"></div>');
    }
    if ($("[data-promotioncountdown]")) {
        $("[data-promotioncountdown]").each(function() {
            var $this = $(this), finalDate = $(this).data("promotioncountdown");
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('<span><span>%D</span>'+boncountdown_days+'</span><div class="promo-dots">:</div><span><span>%H</span>'+boncountdown_hr+'</span><div class="promo-dots">:</div><span><span>%M</span>'+boncountdown_min+'</span><div class="promo-dots">:</div><span><span>%S</span>'+boncountdown_sec+'</span>'));
            });
        });
    }
});



