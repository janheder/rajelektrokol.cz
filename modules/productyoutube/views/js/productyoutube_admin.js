/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Video Youtube
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

$(document).ready(function () {
    $('.bootstrap .productyoutube > tbody  tr  td.dragHandle').wrapInner('<div class="positions"/>');
    $('.bootstrap .productyoutube > tbody  tr  td.dragHandle').wrapInner('<div class="dragGroup"/>');
    initAjaxTabs();
    initAutocomplite();
});

function initAjaxTabs() {

    $('.productyoutube > tbody tr').each(function () {
        var id = $(this).find('td:first').text();
        $(this).attr('id', 'item_' + id.trim());
    });

    var $tabslides = $('.productyoutube > tbody');

    $tabslides.sortable({
        cursor: 'move',
        items: '> tr',
        update: function (event, ui) {
            $('.productyoutube > tbody > tr').each(function (index) {
                $(this).find('.positions').text(index + 1);
            });
        }
    }).bind('sortupdate', function () {
        var orders = $(this).sortable('toArray');
        $.ajax({
            type: 'POST',
            url: ajax_theme_url + '&ajax',
            headers: {
                "cache-control": "no-cache"
            },
            dataType: 'json',
            data: {
                action: 'updatepositionform',
                item: orders,
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
};


function initAutocomplite() {
    $('#product_autocomplete_input').autocomplete(file_theme_url + 'bon_ajax_products_list.php', {
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
    $('#module_form .form-wrapper .form-group.display-block-product').next().removeClass('hidden');

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

$(window).load(function () {
    if ($('div').is('.form-control-static')) {
        $('#ajax_choose_product').hide();
    };
});