/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Lookbook gallery with products and slider
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
let SCALE = 1;

$(document).ready(function () {
  $("input#top").attr("value", $('.bonpoint').attr('data-top'));
  $("input#left").attr("value", $('.bonpoint').attr('data-left'));

  SCALE = $(".bonimage-container").parent().width() / $('.bonimage-container').attr('data-width');
  let ratio = SCALE,
      height = ratio * $('.bonimage-container').attr('data-height');

  $(".bonimage-container").css('height', height + 'px');
  $(".bonpoint-wrapper").css('transform', 'scale(' + ratio + ')');

  pointDrag('.bonpoint');

  $('.bootstrap .bonlookbook > tbody  tr  td.dragHandle').wrapInner(
    '<div class="positions"/>'
  );
  $('.bootstrap .bonlookbook > tbody  tr  td.dragHandle').wrapInner(
    '<div class="dragGroup"/>'
  );
  $('.bootstrap .bonlookbook_point > tbody  tr  td.dragHandle').wrapInner(
    '<div class="positions"/>'
  );
  $('.bootstrap .bonlookbook_point > tbody  tr  td.dragHandle').wrapInner(
    '<div class="dragGroup"/>'
  );

  initAutocomplite();
  initAjaxTabs();
  initAjaxSub();

});



function initAjaxTabs() {
  $('.bonlookbook > tbody tr').each(function () {
    var id = $(this).find('td:first').text();
    $(this).attr('id', 'item_' + id.trim());
  });

  var $tabslides = $('.bonlookbook > tbody');

  $tabslides
    .sortable({
      cursor: 'move',
      items: '> tr',
      update: function (event, ui) {
        $('.bonlookbook > tbody > tr').each(function (index) {
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
function initAutocomplite() {
  $('#product_autocomplete_input').autocomplete(file_theme_url + "controllers/admin/AdminAjaxBonlookbookProdutsSearch.php", {
    minChars: 1,
    autoFill: true,
    max: 200,
    matchContains: true,
    mustMatch: false,
    scroll: true,
    cacheLength: 0,
    parse: function (data) {
      if (data == '[]') {
        $('.ac_results').addClass('act');
      } else {
        $('.ac_results').removeClass('act');
      }
    },
    formatItem: function (item) {
      return item[1] + ' - ' + item[0];
    }
  }).result(addProduct);
  $('#product_autocomplete_input').setOptions({
    extraParams: {
      excludeIds: getProductds()
    }
  });
  $('#divProduct').delegate('.delProduct', 'click', function () {
    delProduct($(this).attr('name'));
  });
}
function getProductds() {
  var id_product = true;

  if ($('#id_product').val() === undefined) {
    return id_product;
  }

  return id_product + ',' + $('#id_product').val().replace(/\-/g, ',');
}
function addProduct(event, data, formatted) {
  if (data == null) {
    return false;
  }
  var productId = data[1];
  var productName = data[0];
  var $divProduct = $('#divProduct');
  var $id_product = $('#id_product');
  var $product_name = $('#product_name');
  $divProduct.html($divProduct.html() + '<div class="form-control-static"><button type="button" class="delProduct btn btn-default" name="' + productId + '"><i class="icon-remove text-danger"></i></button>&nbsp;' + productName + '</div>');
  $product_name.val($product_name.val() + productName + '¤');
  $id_product.val($id_product.val() + productId);
  $('#product_autocomplete_input').val('');
  $('#product_autocomplete_input').setOptions({
    extraParams: {
      excludeIds: getProductds()
    }
  });
  $('#ajax_choose_product').hide();
  $('#module_form .form-wrapper .form-group').next().removeClass('hidden');
};
function delProduct(id) {
  var div = getE('divProduct');
  var input = getE('id_product');
  var name = getE('product_name');
  var inputCut = input.value.split('-');
  var nameCut = name.value.split('¤');
  if (inputCut.length != nameCut.length) {
    //  return jAlert('Bad size');
  }
  input.value = '';
  name.value = '';
  div.innerHTML = '';
  for (i in inputCut) {
    if (!inputCut[i] || !nameCut[i]) {
      continue;
    }
    if (inputCut[i] != id) {
      input.value += inputCut[i];
      name.value += nameCut[i] + '¤';
      div.innerHTML += '<div class="form-control-static"><button type="button" class="delProduct btn btn-default" name="' + inputCut[i] + '"><i class="icon-remove text-danger"></i></button>&nbsp;' + nameCut[i] + '</div>';
    } else {
      $('#selectProduct').append('<option selected="selected" value="' + inputCut[i] + '-' + nameCut[i] + '">' + inputCut[i] + ' - ' + nameCut[i] + '</option>');
    }
  }
  $('#product_autocomplete_input').setOptions({
    extraParams: {
      excludeIds: getProductds()
    }
  });
  $('#ajax_choose_product').show();
  $('.daydeal-prices').remove();
};
function initAjaxSub() {
  $('.bonlookbook_point > tbody tr').each(function () {
    var id = $(this).find('td:first').text();
    $(this).attr('id', 'item_' + id.trim());
  });

  var $tabslides = $('.bonlookbook_point > tbody');

  $tabslides
    .sortable({
      cursor: 'move',
      items: '> tr',
      update: function (event, ui) {
        $('.bonlookbook_point > tbody > tr').each(function (index) {
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

function pointDrag(selector) {
  let element = $(selector);
  let click = {
    x: 0,
    y: 0
  };

  element.draggable({
    cursor: "grab",
    start: function (event, ui){
      click.x = event.clientX;
      click.y = event.clientY;
      if (!ui.helper.hasClass('active')) {
        element.removeClass('active');
        ui.helper.addClass('active');
      }
    },
    stop: function (event, ui){
      $("input#top").attr("value", Math.trunc(ui.position.top));
      $("input#left").attr("value", Math.trunc(ui.position.left));
      element.removeClass('active');
    },
    drag: function (event, ui){
      let original = ui.originalPosition;
      ui.position = {
        left: leftPoint(event, click, original),
        top: topPoint(event, click, original)
      };
    },
  });
}
function leftPoint(event, click, original) {
  let result = (event.clientX - click.x + original.left) / SCALE,
      maxValue = $('.bonimage-container').attr('data-width') - 20;

  if (result > 0 && result < maxValue) return result;

  if (result >= maxValue) return maxValue;

  return 0;
}


function topPoint(event, click, original) {
  let result = (event.clientY - click.y + original.top) / SCALE,
      maxValue = $('.bonimage-container').attr('data-height') - 20;

  if (result > 0 && result < maxValue) return result;

  if (result >= maxValue) return maxValue;

  return 0;
}
