/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Whatsapp Chat
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
document.addEventListener("DOMContentLoaded", function () {
    openWhatsappMenu();
    colorWhatsapp();
    backgroundWhatsapp();
    clickWhatsapp();
});

function openWhatsappMenu() {
    $('#bonwhatsappchat-open').on('click', function () {
        $('.whatsappchat-wrapper').toggleClass('active');
        $('#bonwhatsappchat-open').toggleClass('active');
    });
}

function colorWhatsapp() {
    $('#bonwhatsappchat .whatsappchat-description p').css('color', bonwhatsapp_color);
}

function backgroundWhatsapp() {
    $('#bonwhatsappchat .whatsappchat-description').css('background-color', bonwhatsapp_background);
}

function clickWhatsapp() {
    jQuery(function ($) {
        $(document).mouseup(function (e) {
            var div = $("#bonwhatsappchat");
            if (!div.is(e.target) &&
                div.has(e.target).length === 0) {
                $('.whatsappchat-wrapper').removeClass('active');
                $('#bonwhatsappchat-open').removeClass('active');
            }
        });
    });
}