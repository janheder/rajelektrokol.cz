/**
 * 2015-2017 Bonpresta
 *
 * Bonpresta Banner Manager
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
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */


$(document).ready(function () {
    if (typeof (BON_INFOBAN_DISPLAY_CAROUSEL) != 'undefined' && BON_INFOBAN_DISPLAY_CAROUSEL) {
        if (BON_INFOBAN_CAROUSEL_DOTS == 1) {
            var BON_INFOBAN_CAROUSEL_DOTS_SCRIPT = true;
        } else {
            var BON_INFOBAN_CAROUSEL_DOTS_SCRIPT = false;
        }
        if (BON_INFOBAN_CAROUSEL_AUTOPLAY == 1) {
            var BON_INFOBAN_CAROUSEL_AUTOPLAY_SCRIPT = true;
        } else {
            var BON_INFOBAN_CAROUSEL_AUTOPLAY_SCRIPT = false
        }
        if (BON_INFOBAN_CAROUSEL_LOOP == 1) {
            var BON_INFOBAN_CAROUSEL_LOOP_SCRIPT = true;
        } else {
            var BON_INFOBAN_CAROUSEL_LOOP_SCRIPT = false;
        }



        $('#boninfoban .new-slider').slick({
            infinite: BON_INFOBAN_CAROUSEL_LOOP_SCRIPT,
            dots: BON_INFOBAN_CAROUSEL_DOTS_SCRIPT,
            arrows: false,
            autoplay: BON_INFOBAN_CAROUSEL_AUTOPLAY_SCRIPT,
            autoplaySpeed: BON_INFOBAN_CAROUSEL_AUTOPLAY_SPEED,
            slidesToShow: BON_INFOBAN_CAROUSEL_NB,
            slidesToScroll: 1,
            vertical: true,
            verticalSwiping: true,
            draggable: true,
            dotsClass: "vertical-dots",
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToScroll: 1,
                        slidesToShow: 1,
                        arrows: false,
                    }
                },
            ]
        });
    };
});



let banInfoVideo = document.getElementById("boninfoban-video-element");

function playVideo() {
    banInfoVideo.play();
}

function pauseVideo() {
    banInfoVideo.pause();
}

$('#boninfoban-video').on('shown.bs.modal', function () {
    playVideo()
});
$('#boninfoban-video').on('hide.bs.modal', function () {
    pauseVideo()
})