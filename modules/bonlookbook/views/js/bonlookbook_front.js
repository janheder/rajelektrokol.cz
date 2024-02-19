/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Lookbook gallery with products and slider
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
 *  @copyright 2015-2022 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */



$(document).ready(function () {
    $('#bonlookbook .bonlookbook_point').click(function() {
        $( this ).toggleClass('active');
    });
    // slider settings
    if (BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL == 1 || BON_LOOKBOOK_PAGE_SLIDER_DISPLAY_CAROUSEL == 1) {
        if (BON_LOOKBOOK_SLIDER_AUTOPLAY == 1) {
            var BON_CAROUSEL_TIME = BON_LOOKBOOK_SLIDER_AUTOPLAYTIME;
        } else {
            var BON_CAROUSEL_TIME = 9999999999999999;
        }
        if (BON_LOOKBOOK_SLIDER_LOOP == 1) {
            var BON_CAROUSEL_LOOP_SCRIPT = true;
        } else {
            var BON_CAROUSEL_LOOP_SCRIPT = false;
        }
        if (BON_LOOKBOOK_SLIDER_DRAG == 1) {
            var BON_CAROUSEL_DRAG_MODE = true;
        } else {
            var BON_CAROUSEL_DRAG_MODE = false;
        }

        const swiper = new Swiper("#bonlookbook.swiper", {
            speed: parseInt(BON_LOOKBOOK_SLIDER_SPEED),
            preloadImages: false,
            loop: BON_CAROUSEL_LOOP_SCRIPT,
            centeredSlides: true,
            simulateTouch: BON_CAROUSEL_DRAG_MODE,
            loopAdditionalSlides: 30,
            roundLengths: true,
            spaceBetween: 1,
            autoplay: {
                delay: BON_CAROUSEL_TIME,
            },
            navigation: {
                nextEl: "#bonlookbook .bonlookbook-button-next",
                prevEl: "#bonlookbook .bonlookbook-button-prev",
            },
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 5
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 1.95,
                    spaceBetween: 10
                }
            }
        });
    }
})