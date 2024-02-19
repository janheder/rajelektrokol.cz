/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Google Pay
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

window.onload = function () {
  if ($('#BONSHIPPING_ADDRESS_ENABLE_on').attr("checked") == 'checked') {
    $('.form-group.display-block').show();
  } else {
    $('.form-group.display-block').hide();
  }
  $(document).on('click', '#BONSHIPPING_ADDRESS_ENABLE_off', function () {
    $('.form-group.display-block').hide();
  });
  $(document).on('click', '#BONSHIPPING_ADDRESS_ENABLE_on', function () {
    $('.form-group.display-block').show();
  });
}