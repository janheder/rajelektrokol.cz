/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
import $ from 'jquery';
import prestashop from 'prestashop';
import 'velocity-animate';
import ProductMinitature from './components/product-miniature';

function quickviewSlick() {

  $('.quickview .product-images').slick({
    dots: false,
    arrows: true,
    vertical: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: false,
  });

  $('.quickview .slick-list').wrap('<div class="slick-list-wrap"></div>');
}

$(document).ready(() => {
  prestashop.on('clickQuickView', function (elm) {
    let data = {
      'action': 'quickview',
      'id_product': elm.dataset.idProduct,
      'id_product_attribute': elm.dataset.idProductAttribute,
    };
    $.post(prestashop.urls.pages.product, data, null, 'json').then(function (resp) {
      $('body').append(resp.quickview_html);
      let productModal = $(`#quickview-modal-${resp.product.id}-${resp.product.id_product_attribute}`);
      productModal.modal('show');
      coverImage();
      quickviewSlick();
      updateCountdown()
      productConfig(productModal);
      productModal.on('hidden.bs.modal', function () {
        productModal.remove();
      });
    }).fail((resp) => {
      prestashop.emit('handleError', { eventType: 'clickQuickView', resp: resp });
    });
  });

  prestashop.on('updatedProduct', function (event) {
    quickviewSlick();
    coverImage();
    $('.quickview .slick-prev').trigger('click');
  });

  var productConfig = (qv) => {
    const MAX_THUMBS = 4;
    var $arrows = $('.js-arrows');
    var $thumbnails = qv.find('.js-qv-product-images');
    $('.js-thumb').on('click', (event) => {
      if ($('.js-thumb').hasClass('selected')) {
        $('.js-thumb').removeClass('selected');
      }
      $(event.currentTarget).addClass('selected');
      $('.js-qv-product-cover').attr('src', $(event.target).data('image-large-src'));
    });
    if ($thumbnails.find('li').length <= MAX_THUMBS) {
      $arrows.hide();
    } else {
      $arrows.on('click', (event) => {
        if ($(event.target).hasClass('arrow-up') && $('.js-qv-product-images').position().top < 0) {
          move('up');
          $('.arrow-down').css('opacity', '1');
        } else if ($(event.target).hasClass('arrow-down') && $thumbnails.position().top + $thumbnails.height() > $('.js-qv-mask').height()) {
          move('down');
          $('.arrow-up').css('opacity', '1');
        }
      });
    }
    qv.find('#quantity_wanted').TouchSpin({
      verticalbuttons: true,
      verticalupclass: 'material-icons touchspin-up',
      verticaldownclass: 'material-icons touchspin-down',
      buttondown_class: 'btn btn-touchspin js-touchspin',
      buttonup_class: 'btn btn-touchspin js-touchspin',
      min: 1,
      max: 1000000
    });
  };

  var move = (direction) => {
    const THUMB_MARGIN = 20;
    var $thumbnails = $('.js-qv-product-images');
    var thumbHeight = $('.js-qv-product-images li img').height() + THUMB_MARGIN;
    var currentPosition = $thumbnails.position().top;
    $thumbnails.velocity({
      translateY: (direction === 'up') ? currentPosition + thumbHeight : currentPosition - thumbHeight
    }, function () {
      if ($thumbnails.position().top >= 0) {
        $('.arrow-up').css('opacity', '.2');
      } else if ($thumbnails.position().top + $thumbnails.height() <= $('.js-qv-mask').height()) {
        $('.arrow-down').css('opacity', '.2');
      }
    });
  };

  $('body').on('click', '#search_filter_toggler', function () {
    $('#search_filters_wrapper').removeClass('d-none d-md-block');
    $('#js-product-list, #js-product-list-top, #js-active-search-filters').addClass('d-none d-md-block');
    $('#footer').addClass('d-none d-md-block');
  });
  $('#search_filter_controls .clear').on('click', function () {
    $('#search_filters_wrapper').addClass('d-none d-md-block');
    $('#content-wrapper').removeClass('d-none d-md-block');
    $('#footer').removeClass('d-none d-md-block');
  });
  $('#search_filter_controls .ok').on('click', function () {
    $('#search_filters_wrapper').addClass('d-none d-md-block');
    $('#js-product-list, #js-product-list-top, #js-active-search-filters').removeClass('d-none d-md-block');
    $('#footer').removeClass('d-none d-md-block');
  });

  function coverImage() {
    $('.thumb-container').on(
      'click',
      (event) => {
        $('.js-modal-thumb').attr('src', $(event.target).data('image-large-src'));
        $('.selected').removeClass('selected');
        $(event.target).addClass('selected');
        $('.js-qv-product-cover').attr('src', $(event.target).data('image-large-src'));
      }
    );
  }

  const parseSearchUrl = function (event) {
    if (event.target.dataset.searchUrl !== undefined) {
      return event.target.dataset.searchUrl;
    }

    if ($(event.target).parent()[0].dataset.searchUrl === undefined) {
      throw new Error('Can not parse search URL');
    }

    return $(event.target).parent()[0].dataset.searchUrl;
  };

  $('body').on('change', '#search_filters input[data-search-url]', function (event) {
    prestashop.emit('updateFacets', parseSearchUrl(event));
  });

  $('body').on('click', '.js-search-filters-clear-all', function (event) {
    prestashop.emit('updateFacets', parseSearchUrl(event));
  });

  $('body').on('click', '.js-search-link', function (event) {
    event.preventDefault();
    prestashop.emit('updateFacets', $(event.target).closest('a').get(0).href);
  });

  $('body').on('change', '#search_filters select', function (event) {
    const form = $(event.target).closest('form');
    prestashop.emit('updateFacets', '?' + form.serialize());
  });
  prestashop.on('updateProductList', (data) => {
    updateProductListDOM(data);
    hideFilterMobile();
    $('#search_filters_wrapper .color').parent().parent().parent().addClass('color-boxes');
    $('.color-boxes').parent().css('overflow', 'hidden');
      });
});

function hideFilterMobile() {
  if ($(window).width() < 768) {
    $('#search_filters_wrapper').addClass('d-none d-md-block');
    $('#js-product-list, #js-product-list-top, #js-active-search-filters').removeClass('d-none d-md-block');
    $('#footer').removeClass('d-none d-md-block');
  }
}

function updateProductListDOM(data) {
  $('.quickview .slick-list').wrap('<div class="slick-list-wrap"></div>');
  $('#search_filters').replaceWith(data.rendered_facets);
  $('#js-active-search-filters').replaceWith(data.rendered_active_filters);
  $('#js-product-list-top').replaceWith(data.rendered_products_top);
  $('#js-product-list').replaceWith(data.rendered_products);
  $('#js-product-list-bottom').replaceWith(data.rendered_products_bottom);
  if (data.rendered_products_header) {
    $('#js-product-list-header').replaceWith(data.rendered_products_header);
  }
  let productMinitature = new ProductMinitature();
  productMinitature.init();
}

function updateCountdown() {

  $('#bon-stick-cart .bon-stock-countdown').remove();
  let maxQuantity = parseInt($('.bon-stock-countdown').attr("data-max"));
  let quantityProduct = parseInt($('.bon-stock-countdown-counter').attr('data-value'));
  let progressBar = $('.bon-stock-countdown-progress');

  if (quantityProduct < maxQuantity) {
    if (quantityProduct > 0) {
      $(progressBar).css('width', (quantityProduct * 100) / maxQuantity + '%');
    }
  }

  if (quantityProduct > maxQuantity) {
    $(progressBar).css('width', '100%');
  }

  if (quantityProduct <= 0) {
    $('.bon-stock-countdown-title').html('<span>No product available!</span>');
    $(progressBar).css('width', '0');
  }
}
