/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Trends
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


document.addEventListener("DOMContentLoaded", productPurchase);

function productPurchase() {

    let customList = $('.product-purchase-list');
    if (customList.length) {
        let listItems = $('li', customList);
        if (listItems.length) {
            $('.product-purchase-item:first-child').addClass('active-item');
            let index = 1;
            let interval = setInterval(function () {
                if (index < listItems.length) {
                    listItems.removeClass('active-item');
                    $('.product-purchase-container').removeClass('active-list');
                }
                if (index == listItems.length) {
                    index = 0;
                    $('.product-purchase-container').removeClass('active-list');
                    listItems.removeClass('active-item');
                }
                setTimeout(showProduct, PURCHASE_TIME_SHOW);

                function showProduct() {
                    $('.product-purchase-container').addClass('active-list');
                    listItems.eq(index).addClass('active-item');
                    index++;
                }
            }, PURCHASE_TIME_ACTIVE);
            $('.product-purchase-container .close-popup').on('click', function () {
                clearInterval(interval);
                $('.product-purchase-container').removeClass('active-list');
            })
        }
    }
}