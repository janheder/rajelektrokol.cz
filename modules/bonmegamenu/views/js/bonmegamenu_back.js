/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */


$(document).ready(function () {

  /* drag-and-drop */
  let dragDropClass = [
    '.bootstrap .bonmegamenu > tbody  tr  td.dragHandle',
    '.bootstrap .bonmegamenu_sub > tbody  tr  td.dragHandle',
    '.bootstrap .bonmegamenu_sub_view > tbody  tr  td.dragHandle',
    '.bootstrap .bonmegamenu_sub_prod > tbody  tr  td.dragHandle',
    '.bootstrap .bonmegamenu_sub_label > tbody  tr  td.dragHandle'
  ];

  dragDropClass.forEach((element) => {
    dragWrapperAdd(element);
  });

  /* categories icons */

  $('.bon_modules_icons option').each(function () {
    $(this).addClass($(this).val());
  });

  function dragWrapperAdd(classElem) {
    $(classElem).wrapInner('<div class="positions"/>');
    $(classElem).wrapInner('<div class="dragGroup"/>');
  }

  /* icons */
  var iconFamily = $('.bon_modules_icons_type select').val();
  selectFamilyIcon();

  $('.bon_modules_icons_type #type_icon').change(function () {
    $('.bon_modules_icons select').prop('selectedIndex', 0);
    selectFamilyIcon();
  });

  initAjaxBonMM('.bonmegamenu_sub > tbody tr', '.bonmegamenu_sub > tbody', '.bonmegamenu_sub > tbody > tr', 'updatepositionsubform');
  initAjaxBonMM('.bonmegamenu > tbody tr', '.bonmegamenu > tbody', '.bonmegamenu > tbody > tr', 'updatepositionform');
  initAjaxBonMM('.bonmegamenu > tbody tr', '.bonmegamenu > tbody', '.bonmegamenu > tbody > tr', 'updatepositionform');
  initAjaxBonMM('.bonmegamenu_sub_prod > tbody tr', '.bonmegamenu_sub_prod > tbody', '.bonmegamenu_sub_prod > tbody > tr', 'updatepositionsubproductform');
  initAjaxBonMM('.bonmegamenu_sub_label > tbody tr', '.bonmegamenu_sub_label > tbody', '.bonmegamenu_sub_label > tbody > tr', 'updatepositionsublabelform');
  initAjaxBonMM('.bonmegamenu_sub_view > tbody tr', '.bonmegamenu_sub_view > tbody', '.bonmegamenu_sub_view > tbody > tr', 'updatepositionsubviewform');
  initAutocomplite();
  menuItemsMoving();
});

function selectFamilyIcon() {
  var iconFamily = $('.bon_modules_icons_type select').val();
  var selectIcon = $('.bon_modules_icons select');
  if (iconFamily == 'material_icons') {
    selectIcon.addClass('material_icons').removeClass('outicons');
    $('.bon_modules_icons .material-icons').show();
    $('.bon_modules_icons .fl-outicons').hide();
  } else if (iconFamily == 'outicons') {
    selectIcon.addClass('outicons').removeClass('material_icons');
    $('.bon_modules_icons .fl-outicons').show();
    $('.bon_modules_icons .material-icons').hide();
  }
}


 /* menu items moving */
function menuItemsMoving() {
  $('#menuOrderUp').click(function (e) {
    e.preventDefault();
    move(true);
  });
  $('#menuOrderDown').click(function (e) {
    e.preventDefault();
    move();
  });
  $('#menu_items')
    .closest('form')
    .on('submit', function (e) {
      $('#menu_items option').prop('selected', true);
    });
  $('#addItem').click(add);
  $('#availableItems').dblclick(add);
  $('#removeItem').click(remove);
  $('#menu_items').dblclick(remove);
  function add() {
    $('#availableItems option:selected').each(function (i) {
      var val = $(this).val();
      var text = $(this).text();
      text = text.replace(/(^\s*)|(\s*$)/gi, '');
      if (val == 'PRODUCT') {
        val = prompt('Indicate the ID number for the product');
        if (val == null || val == '' || isNaN(val)) return;
        text = 'Product ID #' + val;
        val = 'PRD' + val;
      }
      $('#menu_items').append(
        '<option value="' + val + '" selected="selected">' + text + '</option>'
      );
    });
    serialize();
    return false;
  }
  function remove() {
    $('#menu_items option:selected').each(function (i) {
      $(this).remove();
    });
    serialize();
    return false;
  }
  function serialize() {
    var options = '';
    $('#menu_items option').each(function (i) {
      options += $(this).val() + ',';
    });
    $('#menu_itemsInput').val(options.substr(0, options.length - 1));
  }
  function move(up) {
    var tomove = $('#menu_items option:selected');
    if (tomove.length > 1) {
      alert('Please select just one item');
      return false;
    }
    if (up) tomove.prev().insertAfter(tomove);
    else tomove.next().insertBefore(tomove);
    serialize();
    return false;
  }
}

function initAjaxBonMM(class1, class2, class3, action) {
  $(class1).each(function () {
    var id = $(this).find('td:first').text();
    $(this).attr('id', 'item_' + id.trim());
  });

  var $tabslides = $(class2);

  $tabslides
    .sortable({
      cursor: 'move',
      items: '> tr',
      update: function (event, ui) {
        $(class3).each(function (index) {
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
          action: action,
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

// Autocomplite Product

function initAutocomplite() {
  $('#product_autocomplete_input')
    .autocomplete(
      file_theme_url + 'controllers/admin/bon_ajax_products_list.php',
      {
        minChars: 1,
        autoFill: true,
        max: 20,
        matchContains: true,
        mustMatch: false,
        scroll: false,
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
      }
    )
    .result(addProduct);
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
  $divProduct.html(
    $divProduct.html() +
      '<div class="form-control-static"><button type="button" class="delProduct btn btn-default" name="' +
      productId +
      '"><i class="icon-remove text-danger"></i></button>&nbsp;' +
      productName +
      '</div>'
  );
  $product_name.val($product_name.val() + productName + '¤');
  $id_product.val($id_product.val() + productId);
  $('#product_autocomplete_input').val('');
  $('#product_autocomplete_input').setOptions({
    extraParams: {
      excludeIds: getProductds()
    }
  });
  $('#ajax_choose_product').hide();
  $('#module_form .form-wrapper .form-group.display-block-product')
    .next()
    .removeClass('hidden');
}

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
      div.innerHTML +=
        '<div class="form-control-static"><button type="button" class="delProduct btn btn-default" name="' +
        inputCut[i] +
        '"><i class="icon-remove text-danger"></i></button>&nbsp;' +
        nameCut[i] +
        '</div>';
    } else {
      $('#selectProduct').append(
        '<option selected="selected" value="' +
          inputCut[i] +
          '-' +
          nameCut[i] +
          '">' +
          inputCut[i] +
          ' - ' +
          nameCut[i] +
          '</option>'
      );
    }
  }
  $('#product_autocomplete_input').setOptions({
    extraParams: {
      excludeIds: getProductds()
    }
  });
  $('#ajax_choose_product').show();
  $('.daydeal-prices').remove();
}

$(window).load(function () {
  if ($('div').is('.form-control-static')) {
    $('#ajax_choose_product').hide();
  }
});
