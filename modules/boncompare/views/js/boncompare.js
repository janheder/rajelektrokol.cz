/*
 * 2015-2021 Bonpresta
 *
 * Bonpresta Product Compare
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

let localStorageItemCompare = 'compare_' + btoa(static_token_bon_compare),
  stored_compare = localStorage.getItem(localStorageItemCompare),
  compare = stored_compare ? JSON.parse(stored_compare) : [];

$(document).ready(function () {
  bonCompare();
  counterCompare(compare);
  addClassCompare(compare);

  prestashop.on('updateProductList', (data) => {
    updateProductListDOM(data);
    bonCompare();
    counterCompare(compare);
  });

  prestashop.on('updatedProduct', () => {
    bonCompare();
    counterCompare(compare);
  });
});

function updateProductListDOM(data) {
  bonCompare();
  counterCompare(compare);
}

function bonCompare() {
  ajaxRequestCompare();
  addToCompare();
}

function addToCompare() {
  $('.boncompare-hook-wrapper').on('click', function (event) {
    event.preventDefault();
    event.stopPropagation();
    let productId = $(this).attr('data-id-compare');

    function prodIndex(value) {
      return value == productId;
    }
    let index = compare.findIndex(prodIndex);

    if (compare.indexOf(productId) == -1) {
      compare.push(productId);
      pushToStorage(compare);
      $(this).addClass('active');
    } else {
      compare.splice(index, 1);
      pushToStorage(compare);
      $(this).removeClass('active');
    }
    ajaxRequestCompare();
    counterCompare(compare);
  });
}

function pushToStorage(arr) {
  localStorage.setItem(localStorageItemCompare, JSON.stringify(arr));
}

function ajaxRequestCompare() {
  $.ajax({
    type: 'POST',
    url:
      bon_compare_url +
      '?ajax=1&static_token_bon_compare=' +
      static_token_bon_compare,
    async: true,
    data: 'compare_key=' + compare,
    success: function (data) {
      $('#boncompare-popup').html(data);
    }
  }).done(function () {
     deleteFromCompare();
    addClassCompare(compare);
    counterCompare(compare);
  });
}

function deleteFromCompare() {
  $('.compare-button-delete').on('click', function () {
    let productId = $(this).parent().attr('data-id-compare');
    $('.div-table-col').each(function (index) {
      let dataId = $(this).attr('data-id-compare');
      if (dataId == productId) {
        $(this).remove();
      }
    });

    $(this).parent().remove();

    function prodIndex(value) {
      return value == productId;
    }
    let index = compare.findIndex(prodIndex);
    compare.splice(index, 1);

    localStorage.setItem(localStorageItemCompare, JSON.stringify(compare));

    if (compare.length == 0) {
      $('.boncompare-list').remove();
      $('.no-compare-js').css('display', 'block');
    }
    addClassCompare(compare);
    counterCompare(compare);
  });
}

function counterCompare(compareList) {
  let stored_compare_count = localStorage.getItem(localStorageItemCompare);
  let compareLength = compareList.length;
  let counter = $('.compare-count');
  if (!stored_compare_count || compareLength <= 0) {
    counter.text('0');
  } else {
    counter.text(compareLength);
  }
}

function addClassCompare(compareList) {
  $('.boncompare-hook-wrapper').each(function (index) {
    if (compareList.indexOf($(this).attr('data-id-compare')) != -1) {
      $(this).children('.compare-button').addClass('active');
    } else {
      $(this).children('.compare-button').removeClass('active');
    }
  });
}

function closeBoncompare() {
  $('#boncompare-popup .popup-close').trigger('click');
}