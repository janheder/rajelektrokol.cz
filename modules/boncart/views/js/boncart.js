/*
 * 2015-2020 Bonpresta
 *
 * Bonpresta Cart
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

$(document).ready(()=>{
    // desktopStickyCart();
    prestashop.on('updateCart', function (event) {
        event.resp = 'object'
    });
})
// $(window).resize(desktopStickyCart);

function desktopStickyCart() {
    let header = document.getElementById("header");
    let headerHeight = $('#header').height();
    let sticky = header.offsetTop + headerHeight;

    $(window).on("scroll", function () {
        if ($(window).width() >= 992) {
            if ($(window).scrollTop() > sticky) {
                $('#_desktop_cart').addClass('bon-desktop-sticky-cart');
            } else {
                $('#_desktop_cart').removeClass('bon-desktop-sticky-cart');
            }
        } else {
            $('#_desktop_cart').removeClass('bon-desktop-sticky-cart');
        }
    });
}