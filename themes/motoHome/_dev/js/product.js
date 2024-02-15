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

function miniatureSlider() {
    var swiper = new Swiper(".featured-products.featured-products-swiper", {
        speed: 1100,
        preloadImages: false,
        loop: false,
        grid: {
            rows: 2
        },
        pagination: {
            el: ".featured-products.bonswiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".featured-products .bonswiper-button-next",
            prevEl: ".featured-products .bonswiper-button-prev",
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
            },
            // when window width is >= 576px
            570: {
                slidesPerView: 2,
            },
            // when window width is >= 991px
            991: {
                slidesPerView: 4,
            },
        },
        on: {
            init: function () {
                $('.featured-products.featured-products-swiper').css({'opacity': '1', 'visibility': 'visible'});
            },
        },
    });
}
function productSlick() {
    $('#content-wrapper .js-qv-mask ul').slick({
        dots: false,
        arrows: true,
        vertical: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
    });
}

$('#content-wrapper .js-qv-mask ul').on('init', function(event, slick){
    $('#main .images-container .js-qv-mask').css('display', 'block');
});
$(window).resize(function () {
    if ($(window).width() >= 1200) {
        $('.slick-next').trigger("click");
        $('#product .product-cover').on('click', function () {
            if ($('.modal-gallery.js-product-images-modal').css('display') === 'block') {
                $('.modal-gallery .modal-content .modal-body #thumbnails .js-modal-mask ul').not('.slick-initialized').slick({
                    dots: false,
                    arrows: true,
                    vertical: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                });
            }
        });
    }
});

function createGalery() {
    if ($(window).width() >= 300) {

        $('#product .product-cover').on('click', function () {

            if ($('.modal-gallery.js-product-images-modal').css('display') == 'none') {

                $('.modal-gallery.js-product-images-modal').css('display', 'block');

                $('.modal-gallery .modal-content .modal-body #thumbnails .js-modal-mask ul').not('.slick-initialized').slick({
                    dots: false,
                    arrows: true,
                    vertical: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                });
            } else {
                $('.modal-gallery.js-product-images-modal').css('display', 'none');
            }
        });
    }
}

$(document).ready(function () {
    createProductSpin();
    createInputFile();
    updateCountdown();
    closeGallery();
    createGalery();
    coverImage();
    openReviewTab();
    miniatureSlider();
    productSlick();

    prestashop.on('updatedProduct', function (event) {
        createInputFile();
        createGalery();
        coverImage();
        productSlick();
        updateCountdown();
        applyElevateZoom();
        $('.thumb-container').click(function() {
            restartElevateZoom();
        });
        $('.color-boxes').parent().css('overflow', 'hidden');
        if (event && event.product_minimal_quantity) {
            const minimalProductQuantity = parseInt(event.product_minimal_quantity, 10);
            const quantityInputSelector = '#quantity_wanted';
            let quantityInput = $(quantityInputSelector);
            // @see http://www.virtuosoft.eu/code/bootstrap-touchspin/ about Bootstrap TouchSpin
            quantityInput.trigger('touchspin.updatesettings', { min: minimalProductQuantity });
        }

        $($('.tabs .nav-link.active').attr('href')).addClass('active').removeClass('fade');
        $('.js-product-images-modal').replaceWith(event.product_images_modal);
    });
});

function closeGallery() {
    $(document).mouseup(function (e) {
        let gallery = $(".modal-gallery");
        if (gallery.is(e.target)
            && gallery.has(e.target).length === 0) {
            gallery.hide();
        }
        $('.gallery-close').on('click', function () {
            gallery.hide();
        })
    });
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


function openReviewTab() {
    let tabs = $('.nav-item a');
    $('.bon-review-button').on('click', function () {
        if ($(tabs).hasClass('active')) {
            $(tabs).removeClass('active');
            $('.nav-item .reviewtab').trigger('click');
        } else {
            $('.nav-item .reviewtab').removeClass('active');
        }

    })
}

function coverImage() {
    $('.thumb-container').on(
        'click',
        (event) => {
            $('.js-modal-product-cover').attr('src', $(event.target).data('image-large-src'));
            $('.selected').removeClass('selected');
            $(event.target).addClass('selected');
            $('.js-qv-product-cover').attr('src', $(event.target).data('image-large-src'));
        }
    );
}

function createInputFile() {
    $('.js-file-input').on('change', (event) => {
        let target, file;

        if ((target = $(event.currentTarget)[0]) && (file = target.files[0])) {
            $(target).prev().text(file.name);
        }
    });
}

function createProductSpin() {
    const $quantityInput = $('#quantity_wanted');

    $quantityInput.TouchSpin({
        buttondown_class: 'btn btn-touchspin js-touchspin',
        buttonup_class: 'btn btn-touchspin js-touchspin',
        verticalbuttons: true,
        min: parseInt($quantityInput.attr('min'), 10),
        max: 1000000
    });
}