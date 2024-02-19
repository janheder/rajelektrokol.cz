/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Instagram Gallery Feed Photos & Videos User
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
function getPageWidth() {
    let pageWidth = window.innerWidth;

    if (typeof pageWidth != "number") {
        // if browser work in standard mode
        if (document.compatMode == "CSS1Compat") {
            pageWidth = document.documentElement.clientWidth;
        } else {
            pageWidth = document.body.clientWidth;
        }
    }

    return pageWidth;
}
function heightSlide() {
    let slides = $('#boninstagram .instagram-item:not(.slick-current)');
    let slidesWithCurrent = $('#boninstagram .instagram-item');
    let currentSlides = $('#boninstagram .instagram-item.slick-current');
    let slideHeight = slides.width();

    if (getPageWidth() > 1200) {
        slides.css({
            'min-height': slideHeight + 'px',
            'min-width': slideHeight + 'px',
            'width': slideHeight + 'px',
            'height': slideHeight + 'px',
        });
    } else {
        slidesWithCurrent.css({
            'min-height': slideHeight + 'px',
            'min-width': slideHeight + 'px',
            'width': slideHeight + 'px',
            'height': slideHeight + 'px',
        });
    }

    if (getPageWidth() > 1200) {
        currentSlides.css({
            'min-width': slideHeight * 1.2 + 'px',
            'min-height': slideHeight * 1.7 + 'px',
            'height': slideHeight * 1.7 + 'px',
            'width': slideHeight * 1.2 + 'px',
        });
    }
    $('#boninstagram').addClass('readyOnChange')
}
$(document).ready(function () {
    if (BONINSTAGRAM_DOTS == 1) {
        var BONINSTAGRAM_DOTS_SCRIPT = true;
    } else {
        var BONINSTAGRAM_DOTS_SCRIPT = false;
    }
    if (BONINSTAGRAM_NAV == 1) {
        var BONINSTAGRAM_NAV_SCRIPT = true;
    } else {
        var BONINSTAGRAM_NAV_SCRIPT = false;
    }
    if (BONINSTAGRAM_LOOP == 1) {
        var BONINSTAGRAM_LOOP_SCRIPT = true;
    } else {
        var BONINSTAGRAM_LOOP_SCRIPT = false;
    }
    if (BONINSTAGRAM_MARGIN) {
        $('#boninstagram ul li').css('margin', '0 ' + BONINSTAGRAM_MARGIN / 2 + 'px');
    }
    $('.slick-carousel-instagram').bonslick({
        slidesToShow: BONINSTAGRAM_NB,
        infinite: BONINSTAGRAM_LOOP_SCRIPT,
        autoplaySpeed: BONINSTAGRAM_SPEED,
        draggable: true,
        transformEnabled: false,
        dots: BONINSTAGRAM_DOTS_SCRIPT,
        arrows: BONINSTAGRAM_NAV_SCRIPT,
        autoplay: true,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,
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
    });
    setTimeout(function() {
        heightSlide();
    }, 400);
    $('.slick-carousel-instagram').on('afterChange', function(event, slick, currentSlide, nextSlide){
        heightSlide();
    });

    window.addEventListener('resize', function(event) {
        heightSlide();
    });
});