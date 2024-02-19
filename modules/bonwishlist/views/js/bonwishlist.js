/*
 * 2015-2021 Bonpresta
 *
 * Bonpresta Wishlist
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

let localStorageItemWishlist = 'wishlist_' + btoa(static_token_bon_wishlist),
  stored_wishlist = localStorage.getItem(localStorageItemWishlist),
  wishlist = stored_wishlist ? JSON.parse(stored_wishlist) : [];

 
$(document).ready(function () {
  bonWishList();
  counterWishlist(wishlist);
  addClassWishlist(wishlist);

  prestashop.on('updateProductList', (data) => {
    updateProductListDOM(data);
    bonWishList();
    counterWishlist(wishlist);
  });

  prestashop.on('updatedProduct', () => {
    bonWishList();
    counterWishlist(wishlist);
  });
});

function updateProductListDOM(data) {
  bonWishList();
  counterWishlist(wishlist);
}

function bonWishList() {
  ajaxRequestWishlist();
  addToWishlist();
}

function addClassWishlist(wishlist) {
  $('.bonwishlist-hook-wrapper').each(function (index) {
    if (wishlist.indexOf($(this).attr('data-id-product')) != -1) {
      $(this).children('.wish-button').addClass('active');
    } else {
      $(this).children('.wish-button').removeClass('active');
    }
  });
}

function deleteFromWishlist() {
  $('.wishlist-button-delete').on('click', function () {
    let productId = $(this).parent().attr('data-id-product');
    $('.wishlist-item').each(function (index) {
      let dataId = $(this).attr('data-id-product');
      if (dataId == productId) {
        $(this).remove();
      }
    });

    $(this).parent().remove();

    function prodIndex(value) {
      return value == productId;
    }
    let index = wishlist.findIndex(prodIndex);
    wishlist.splice(index, 1);

    localStorage.setItem(localStorageItemWishlist, JSON.stringify(wishlist));

    if (wishlist.length == 0) {
      $('.wishlist-list').remove();
      $('.no-items-js').css('display', 'block');
    }
    addClassWishlist(wishlist);
    counterWishlist(wishlist);
  });
}

function addToWishlist() {
  $('.bonwishlist-hook-wrapper').on('click', function (event) {
    event.preventDefault();
    event.stopPropagation();
    let productId = $(this).attr('data-id-product');
    function prodIndex(value) {
      return value == productId;
    }
    let index = wishlist.findIndex(prodIndex);

    if (wishlist.indexOf(productId) == -1) {
      wishlist.push(productId);
      pushToStorageWishlist(wishlist);
      $(this).addClass('active');
    } else {
      wishlist.splice(index, 1);
      pushToStorageWishlist(wishlist);
      $(this).removeClass('active');
    }
    ajaxRequestWishlist();
    counterWishlist(wishlist);
  });
}

function pushToStorageWishlist(arr) {
  localStorage.setItem(localStorageItemWishlist, JSON.stringify(arr));
}

function ajaxRequestWishlist() {
  $.ajax({
    type: 'POST',
    url: bon_wishlist_url +
    '?ajax=1&static_token_bon_wishlist=' +
    static_token_bon_wishlist,
    async: true,
    data: 'wishlist_key=' + wishlist,
    success: function (data) {
      $('#wishlist-popup').html(data);
    }
  }).done(function () {
    deleteFromWishlist();
    addClassWishlist(wishlist);
    counterWishlist(wishlist);
  });
}

function counterWishlist(wishlist) {
  let stored_wishlist = localStorage.getItem(localStorageItemWishlist);
  let wishlistLength = wishlist.length;
  let counter = $('#wishlist-count');
  if (!stored_wishlist || wishlistLength <= 0) {
    counter.text('0');
  } else {
    counter.text(wishlistLength);
  }
}

 