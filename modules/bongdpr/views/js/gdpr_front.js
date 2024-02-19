/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta GDPR EU Cookie Law Banner
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

    setTimeout(function () {
        $('#bongdpr').fadeIn(10);

    }, 10);

    var gdpr = $.cookie('bongdpr');
    if (gdpr == 'client') {
        $('#bongdpr').remove();
    }

    $('#button_gdpr').click(function () {
        $('#bongdpr').remove();
        $.cookie('bongdpr', 'client', {
            expires: 30
        });
    });

});