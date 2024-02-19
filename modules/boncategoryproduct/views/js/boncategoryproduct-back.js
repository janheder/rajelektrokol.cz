/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Category Products with Tabs and Carousel on Home Page
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

$(document).ready(function () {
  $('.bootstrap .boncategoryproduct > tbody  tr  td.dragHandle').wrapInner(
    '<div class="positions"/>'
  );
  $('.bootstrap .boncategoryproduct > tbody  tr  td.dragHandle').wrapInner(
    '<div class="dragGroup"/>'
  );
  initAjaxTabs();

  $('.form-group.display-block-tabcontent').addClass('hidden');
  $(document).on('click', '#custom_banner_off', function () {
    $('.form-group.display-block-tabcontent').addClass('hidden');
  });
  $(document).on('click', '#custom_banner_on', function () {
    $('.form-group.display-block-tabcontent').removeClass('hidden');
  });
  if ($('input[name="custom_banner"]:checked').val() == 1) {
    $('.form-group.display-block-tabcontent').removeClass('hidden');
  }
  
  $('.form-group.display-block-carousel-content').addClass('hidden');
  $(document).on('click', '#PRODUCT_CATEGORY_DISPLAY_CAROUCEL_off', function () {
    $('.form-group.display-block-carousel-content').addClass('hidden');
  });
  $(document).on('click', '#PRODUCT_CATEGORY_DISPLAY_CAROUCEL_on', function () {
    $('.form-group.display-block-carousel-content').removeClass('hidden');
  });
  if ($('input[name="PRODUCT_CATEGORY_DISPLAY_CAROUCEL"]:checked').val() == 1) {
    $('.form-group.display-block-carousel-content').removeClass('hidden');
  }

});

function initAjaxTabs() {
  $('.boncategoryproduct > tbody tr').each(function () {
    var id = $(this).find('td:first').text();
    $(this).attr('id', 'item_' + id.trim());
  });

  var $tabslides = $('.boncategoryproduct > tbody');

  $tabslides
    .sortable({
      cursor: 'move',
      items: '> tr',
      update: function (event, ui) {
        $('.boncategoryproduct > tbody > tr').each(function (index) {
          $(this)
            .find('.positions')
            .text(index + 1);
        });
      }
    })
    .bind('sortupdate', function () {
      var orders = $(this).sortable('toArray');
      $.ajax({
        type: 'POST',
        url: ajax_theme_url + '&ajax',
        headers: { 'cache-control': 'no-cache' },
        dataType: 'json',
        data: {
          action: 'updatepositionform',
          item: orders
        },
        success: function (msg) {
          if (msg.error) {
            showErrorMessage(msg.error);
            return;
          }
          showSuccessMessage(msg.success);
        }
      });
    });
}
