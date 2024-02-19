/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Portfolio with Masonry Effect
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
  $('.bootstrap .bonportfolio > tbody  tr  td.dragHandle').wrapInner(
    '<div class="positions"/>'
  );
  $('.bootstrap .bonportfolio > tbody  tr  td.dragHandle').wrapInner(
    '<div class="dragGroup"/>'
  );
  $('.bootstrap .bonportfolio_sub > tbody  tr  td.dragHandle').wrapInner(
    '<div class="positions"/>'
  );
  $('.bootstrap .bonportfolio_sub > tbody  tr  td.dragHandle').wrapInner(
    '<div class="dragGroup"/>'
  );
  initAjaxTabs();
  initAjaxSub();

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
  $('.bonportfolio > tbody tr').each(function () {
    var id = $(this).find('td:first').text();
    $(this).attr('id', 'item_' + id.trim());
  });

  var $tabslides = $('.bonportfolio > tbody');

  $tabslides
    .sortable({
      cursor: 'move',
      items: '> tr',
      update: function (event, ui) {
        $('.bonportfolio > tbody > tr').each(function (index) {
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

function initAjaxSub() {
  $('.bonportfolio_sub > tbody tr').each(function () {
    var id = $(this).find('td:first').text();
    $(this).attr('id', 'item_' + id.trim());
  });

  var $tabslides = $('.bonportfolio_sub > tbody');

  $tabslides
    .sortable({
      cursor: 'move',
      items: '> tr',
      update: function (event, ui) {
        $('.bonportfolio_sub > tbody > tr').each(function (index) {
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
          action: 'updatepositionsubform',
          item: orders,
          id_tab: $('table td.id_tab').text().trim()
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
