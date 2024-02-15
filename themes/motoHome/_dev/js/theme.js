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
// import './components/swiper-bundle.min';
import './components/slick';
import 'expose-loader?Tether!tether';
import 'bootstrap/dist/js/bootstrap.min';
import 'flexibility';
import 'bootstrap-touchspin';
import './responsive';
import './checkout';
import './customer';
import './listing';
import './product';
import './cart';
import DropDown from './components/drop-down';
import Form from './components/form';
import ProductMinitature from './components/product-miniature';
import ProductSelect from './components/product-select';
import TopMenu from './components/top-menu';
import prestashop from 'prestashop';
import EventEmitter from 'events';
import './lib/bootstrap-filestyle.min';
import './lib/jquery.scrollbox.min';
import './components/block-cart';
import './components/about-us';
import $ from "jquery";
import Picker from 'vanilla-picker';
// "inherit" EventEmitter
for (var i in EventEmitter.prototype) {
    prestashop[i] = EventEmitter.prototype[i];
}
$(document).ready(() => {
    let dropDownEl = $('.js-dropdown');
    const form = new Form();
    let topMenuEl = $('.js-top-menu ul[data-depth="0"]');
    let dropDown = new DropDown(dropDownEl);
    let topMenu = new TopMenu(topMenuEl);
    let productMinitature = new ProductMinitature();
    let productSelect = new ProductSelect();
    dropDown.init();
    form.init();
    addAnimationCustom();
    topMenu.init();
    productMinitature.init();
    productSelect.init();
    bondropDown();
    addIconMenu();
    animateSite();
    addToCartAnimation();
    prestashop.on('updateCart', function(event) {
        $("#_desktop_cart .icon-text > span").text(this.cart.totals.total.value)
    });
});

function addToCartAnimation() {
    $('.ajax_add_to_cart_button').on('click', function () {
        $(this).addClass("active");
        const btnAnimation = document.querySelector('.ajax_add_to_cart_button.active');
        btnAnimation.onanimationend = () => {
            $(this).removeClass("active");
        };
    });
    $('.quick-view').on('click', function () {
        $(this).addClass("active");
        const btnAnimation = document.querySelector('.quick-view.active');
        btnAnimation.onanimationend = () => {
            $(this).removeClass("active");
        };
    });
}

function addIconMenu() {
    let windowHeight = parseInt($(window).width());
    if (windowHeight > 767) {
        $('<i class="material-icons current">keyboard_arrow_down</i>').appendTo('#top-menu > li.nav-arrows > a');
    }
}
// $('.block-social').appendTo('.block_newsletter');
$("#top-menu li").find('div').parent().addClass('nav-arrows');
$(".footer_adsress br").replaceWith("&nbsp;");
$('#_desktop_language_selector').appendTo('.setting-header-inner');
$('#_desktop_currency_selector').appendTo('.setting-header-inner');
$('#search_filters_wrapper .color').parent().parent().parent().addClass('color-boxes');
$('.color-boxes').parent().css('overflow', 'hidden');

function bondropDown() {
    var elementClick = '.current';
    var elementSlide = '.bon_drop_down';
    var activeClass = 'active';
    $(elementClick).on('click', function (e) {
        $('#_desktop_language_selector').show();
        $('#_desktop_currency_selector').show();
        var subUl = $(this).next(elementSlide);
        if (subUl.is(':hidden')) {
            subUl.fadeIn();
            $(this).addClass(activeClass);
        } else {
            subUl.fadeOut();
            $(this).removeClass(activeClass);
        }
        $(elementClick).not(this).next(elementSlide).slideUp();
        $(elementClick).not(this).removeClass(activeClass);
    });
}
new Picker({
    parent: document.querySelector('#custom-toggler'),
    popup: 'left',
    onDone: function (color) {
        MyStyleColor(color);
    },
});
$(document).ready(() => {
    $("#back-to-top").css('visibility', 'visible');
    $("#back-to-top").hide();
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        $('#back-to-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
});

function animateSite() {
    var $window = $(window);
    $('.revealOnScroll').addClass('animated');
    $window.on('scroll', revealOnScroll);

    function revealOnScroll() {
        var scrolled = $window.scrollTop(),
            win_height_padded = $window.height() * 1.1;
        $(".revealOnScroll:not(.animated)").each(function () {
            var $this = $(this),
                offsetTop = $this.offset().top;
            if (scrolled + win_height_padded > offsetTop) {
                if ($this.data('timeout')) {
                    window.setTimeout(function () {
                        $this.addClass('animated ' + $this.data('animation'));
                    }, parseInt($this.data('timeout'), 10));
                } else {
                    $this.addClass('animated ' + $this.data('animation'));
                }
            }
        });
        $(".revealOnScroll.animated").each(function () {
            var $this = $(this),
                offsetTop = $this.offset().top;
            if (scrolled + win_height_padded < offsetTop) {
                $(this).removeClass('animated fadeInUp zoomIn fadeInLeft rollIn rotateInDownRight wobble flash pulse fadeInDown fadeInRight rotateIn rotateInUpLeft tada shake fadeInLeftBig lightSpeedIn slideInUp  flipInY hinge fadeInLeftBig flip rotateInDownLeft  rotateInUpRight slideInLeft slideInRight  flipInX ');
            }
        });
    }
    let count2 = 1;
    $('.instagram-carousel-container .instagram-item').each(function () {
        $(this).attr('data-timeout', count2 * 120);
        count2++;
    });
    let count = 1;
    $('#main .main-animate-product .products article').each(function () {
        $(this).attr('data-timeout', count * 120);
        count++;
    });
    let count3 = 1;
    $('#main .feature-animate .products article').each(function () {
        $(this).attr('data-timeout', count3 * 120);
        count3++;
    });
    let count5 = 1;
    $('#product .product-accessories .products article').each(function () {
        $(this).attr('data-timeout', count5 * 120);
        count5++;
    });
    let count6 = 1;
    $('#product .same-products .products article').each(function () {
        $(this).attr('data-timeout', count6 * 120);
        count6++;
    });
    revealOnScroll();
};

function addAnimationCustom() {
    $('#bonhtmlcontent .box-htmlcontent .box-icon').addClass('revealOnScroll animated tada');
    $('#bonhtmlcontent .box-htmlcontent .box-icon').attr('data-animation', 'tada');
    $('#bonhtmlcontent .box-htmlcontent .box-content').addClass('revealOnScroll animated fadeInUp');
    $('#bonhtmlcontent .box-htmlcontent .box-content').attr('data-animation', 'fadeInUp');
}

// hover navigation
// let overlay = document.querySelector('header .bon-link-overlay'),
//     navList = document.querySelectorAll('header .menu>.top-menu>li');
// navList.forEach((list, index) => {
//     list.addEventListener('mouseover', () => {
//         let position = list.getBoundingClientRect();
//         overlay.classList.add('active');
//         overlay.style.left = position.x + 2 + 'px';
//         overlay.style.top = 0;
//         overlay.style.height = position.height + 'px';
//         overlay.style.width = position.width - 3 + 'px';
//         if (index == 0) {
//             overlay.style.width = position.width + 'px';
//             overlay.style.left = position.x + 'px';
//         }
//     });
//     list.addEventListener('mouseout', () => {
//         overlay.classList.remove('active');
//     });
// });
