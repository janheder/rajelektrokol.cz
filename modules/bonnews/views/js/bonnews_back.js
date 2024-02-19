/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta News Manager with Videos and Comments
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
  $('.bootstrap .bonnews > tbody  tr  td.dragHandle').wrapInner(
    '<div class="positions"/>'
  );
  $('.bootstrap .bonnews > tbody  tr  td.dragHandle').wrapInner(
    '<div class="dragGroup"/>'
  );
  initAjaxTabs();

  $('.form-group.display-block-bonnews').addClass('hidden');
  $(document).on('click', '#BON_NEWS_DISPLAY_CAROUSEL_off', function () {
    $('.form-group.display-block-bonnews').addClass('hidden');
  });
  $(document).on('click', '#BON_NEWS_DISPLAY_CAROUSEL_on', function () {
    $('.form-group.display-block-bonnews').removeClass('hidden');
  });
  if ($('input[name="BON_NEWS_DISPLAY_CAROUSEL"]:checked').val() == 1) {
    $('.form-group.display-block-bonnews').removeClass('hidden');
  }

  if ($('.form-group.content_type select').val() !== 'video') {
    $('.form-group.files_lang_cover').addClass('hidden');
  }

  $('.form-group.content_type select').change(function () {
    if ($('.form-group.content_type select').val() == 'video') {
      $('.form-group.files_lang_cover').removeClass('hidden');
    } else {
      $('.form-group.files_lang_cover').addClass('hidden');
    }
  });
});

function initAjaxTabs() {
  $('.bonnews > tbody tr').each(function () {
    var id = $(this).find('td:first').text();
    $(this).attr('id', 'item_' + id.trim());
  });

  var $tabslides = $('.bonnews > tbody');

  $tabslides
    .sortable({
      cursor: 'move',
      items: '> tr',
      update: function (event, ui) {
        $('.bonnews > tbody > tr').each(function (index) {
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
        headers: {
          'cache-control': 'no-cache'
        },
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
