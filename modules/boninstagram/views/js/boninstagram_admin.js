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

$(document).ready(function () {
    $('.form-group.display').hide();
    $(document).on('click', '#BONINSTAGRAM_DISPLAY_CAROUSEL_off', function () {
        $('.form-group.display').hide();
    });

    $(document).on('click', '#BONINSTAGRAM_DISPLAY_CAROUSEL_on', function () {
        $('.form-group.display').show();
    });

    if ($('input[name="BONINSTAGRAM_DISPLAY_CAROUSEL"]:checked').val() == 1) {
        $('.form-group.display').show();
    }
});
function refreshToken(linkAjax) {
    $.ajax({
        url: linkAjax,
        type: 'POST',
        dataType: 'json',
        data: {
            bonRefreshToken: 1
        },
        beforeSend: function () {
            $(this).prop('disabled', true);
        },
        success: function (data) {
            if(data.success){
                $('#BONINSTAGRAM_ACCESS_TOKEN').val(data.token);
                showSuccessMessage(data.message || 'Success');
            }
            else
                showErrorMessage(data.message || 'Error');
        },
        complete: function () {
            $(this).prop('disabled', false);
        }
    });
    return false;
}