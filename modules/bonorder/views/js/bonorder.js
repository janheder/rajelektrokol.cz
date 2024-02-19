/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta One Click Order
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

$(function () {

    $('.bon_order_errors').hide();
    $('.bon_order_success').hide();
    $('.bon_order_validate_phone').hide();
    $('.bon_order_validate_mail').hide();
    $('.bon_order_validate_name').hide();

    $('.bonorder_form').on('submit', function () {
        $('.bon_order_success').hide();
        $('.bon_order_validate_phone').hide();
        $('.bon_order_validate_name').hide();
        $('.bon_order_validate_mail').hide();
        $('.bon_order_errors').hide();
        $('.bon_order_errors').empty();
        $('.bon_order_success').empty();
        $('.bon_order_validate_phone').empty();
        $('.bon_order_validate_mail').empty();
        $('.bon_order_validate_name').empty();
       $.ajax({
           type: 'POST',
           url: bon_order_url + '?ajax=1&static_token_bon_order='+static_token_bon_order,
           async: true,
           dataType : "json",
           data: $(this).serialize(),
            success: function(data) {
                if(data['success'] == 0) {
                    $('.bon_order_success').hide();
                    $('.bon_order_errors').show();
                    $('.bon_order_errors').append(data.error);
                }
                if (data['success'] == 1) {
                    $('.bon_order_box').hide();
                    $('.bonorder_send').hide();
                    $('.bon_order_errors').hide();
                    $('.bon_order_errors_phone').hide();
                    $('.bon_order_validate_mail').hide();
                    $('.image-sticky-order').hide();
                    $('.bon_order_success').show();
                    $('.bon_order_success').append(data.alert);
                }
                if(data['success'] == 2) {
                    $('.bon_order_success').hide();
                    $('.bon_order_validate_phone').show();
                    $('.bon_order_validate_phone').append(data.error);
                }
                if(data['success'] == 4) {
                    $('.bon_order_success').hide();
                    $('.bon_order_validate_mail').show();
                    $('.bon_order_validate_mail').append(data.error);
                }
                if(data['success'] == 3) {
                    $('.bon_order_success').hide();
                    $('.bon_order_validate_name').show();
                    $('.bon_order_validate_name').append(data.error);
                }
            }
        });

        return false;
    });
});
