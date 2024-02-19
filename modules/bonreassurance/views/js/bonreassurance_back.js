/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Customer Reassurance With Icons
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
  $('.bon_modules_icons option').each(function () {
    $(this).addClass($(this).val());
  });

  var iconFamily = $('.bon_modules_icons_type select').val();
  selectFamilyIcon();

  function selectFamilyIcon() {
    var iconFamily = $('.bon_modules_icons_type select').val();
    var selectIcon = $('.bon_modules_icons select');
    if (iconFamily == 'material_icons') {
      selectIcon
        .addClass('material_icons')
        .removeClass('outicons')
        .removeClass('thin')
        .removeClass('puppets');
      $('.bon_modules_icons .material-icons').show();
      $('.bon_modules_icons .fl-outicons').hide();
      $('.bon_modules_icons .puppets').hide();
      $('.bon_modules_icons .thin').hide();
    } else if (iconFamily == 'outicons') {
      selectIcon
        .addClass('outicons')
        .removeClass('material_icons')
        .removeClass('thin')
        .removeClass('puppets');
      $('.bon_modules_icons .fl-outicons').show();
      $('.bon_modules_icons .material-icons').hide();
      $('.bon_modules_icons .puppets').hide();
      $('.bon_modules_icons .thin').hide();
    } else if (iconFamily == 'puppets') {
      selectIcon
        .addClass('puppets')
        .removeClass('material_icons')
        .removeClass('outicons')
        .removeClass('thin');
      $('.bon_modules_icons .puppets').show();
      $('.bon_modules_icons .fl-outicons').hide();
      $('.bon_modules_icons .material-icons').hide();
      $('.bon_modules_icons .thin').hide();
    } else if (iconFamily == 'thin') {
      selectIcon
        .addClass('thin')
        .removeClass('material_icons')
        .removeClass('outicons')
        .removeClass('puppets');
      $('.bon_modules_icons .thin').show();
      $('.bon_modules_icons .fl-outicons').hide();
      $('.bon_modules_icons .material-icons').hide();
      $('.bon_modules_icons .puppets').hide();
    }
  }

  $('.bon_modules_icons_type #type_icon').change(function () {
    $('.bon_modules_icons select').prop('selectedIndex', 0);
    selectFamilyIcon();
  });

  $('.bootstrap .bonreassurance > tbody  tr  td.dragHandle').wrapInner(
    '<div class="positions"/>'
  );
  $('.bootstrap .bonreassurance > tbody  tr  td.dragHandle').wrapInner(
    '<div class="dragGroup"/>'
  );
  initAjaxTabs();

  $('.form-group.display-block-bonreassurance').addClass('hidden');
  $(document).on('click', '#BON_REAS_DISPLAY_CAROUSEL_off', function () {
    $('.form-group.display-block-bonreassurance').addClass('hidden');
  });
  $(document).on('click', '#BON_REAS_DISPLAY_CAROUSEL_on', function () {
    $('.form-group.display-block-bonreassurance').removeClass('hidden');
  });
  if ($('input[name="BON_REAS_DISPLAY_CAROUSEL"]:checked').val() == 1) {
    $('.form-group.display-block-bonreassurance').removeClass('hidden');
  }
});

function initAjaxTabs() {
  $('.bonreassurance > tbody tr').each(function () {
    var id = $(this).find('td:first').text();
    $(this).attr('id', 'item_' + id.trim());
  });

  var $tabslides = $('.bonreassurance > tbody');

  $tabslides
    .sortable({
      cursor: 'move',
      items: '> tr',
      update: function (event, ui) {
        $('.bonreassurance > tbody > tr').each(function (index) {
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
