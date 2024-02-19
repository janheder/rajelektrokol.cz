/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Free Shipping Notice
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
    $("[data-countdown]").each(function () {
        var $this = $(this),
            finalDate = $(this).data("countdown");
        $this.countdown(finalDate, function (event) {
            $this.html(event.strftime('<span class="first_span"><span>%D</span><span class="style_countdown">' +
                notice_countdown_days + '</span></span><span class="first_span"><span>%H</span><span class="style_countdown">' +
                notice_countdown_hr + '</span></span><span class="first_span"><span>%M</span><span class="style_countdown">' +
                notice_countdown_min + '</span></span><span class="first_span"><span>%S</span><span class="style_countdown">' +
                notice_countdown_sec + '</span></span>'));
        });
    });
    BonNotise();
});




function BonNotise() {
    let BonLocalNitice = JSON.parse(localStorage.getItem("BonLocalNitice"))
    if ($('#bon_ship').hasClass('active')) {
        $('#bon_ship').removeClass('active').scrollTop(0);

    }
    if (BonLocalNitice === 'close') {
        $('#bon_ship').addClass('active');
    }
    $('.bon-shipping-close').on('click', function () {
        localStorage.setItem("BonLocalNitice", JSON.stringify("close"));
        $('#bon_ship').addClass('active')
    });
}