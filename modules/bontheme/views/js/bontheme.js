/*
 * 2015-2021 Bonpresta
 *
 * Bonpresta Theme
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

document.addEventListener("DOMContentLoaded", function (e) {
    prestashop.on('updateProductList', (data) => {
        updateProductListDOM(data);
    });

    function updateProductListDOM(data) {
        if ($("#category").length) {
            GridList();
        }
        selectFonts();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    adaptiveHeight();
    boxedBody();
    customPseudoStyles();
    changeLanguageCustom();
    openLeftMenu();
    promoCodePopup()
    selectFonts();
    clickBonTheme();
    clickMenu();
    stickyMenu();
    BonThemePromo();
    if ($("#category")) {
        GridList();
    }

    if (theme_sticky_header == true) {
        stickyHeader();
    } else {
        $('.input-sticky-header').attr('value', 'off');
        $('.switch-header').removeClass('active');
        $('.Sticky-header .toggle-bg').removeClass('active');
    }

    if (theme_sticky_cart == true) {
        stickyCart();
    } else {
        $('.switch-cart').removeClass('active');
        $('.input-sticky-cart').attr('value', 'off');
        $('.sticky-addcart .toggle-bg').removeClass('active');
    }

    if (theme_sticky_footer == true) {
        stickyFooter();
    } else {
        $('.switch-footer').removeClass('active');
        $('.input-sticky-footer').attr('value', 'off');
        $('.Sticky-footer .toggle-bg').removeClass('active');
    }
});
window.addEventListener('resize', function(event) {
    stickyHeader();
    stickyCart();
    stickyFooter();
});
function BonThemePromo() {
    let BonLocalPromo = JSON.parse(localStorage.getItem("BonLocalPromo"))

    if (BonLocalPromo === 'close') {
        $('.promo-container').removeClass('active-list')
    } else {
        $('.promo-container').addClass('active-list')
    }

    $('.close-promo-popup').on('click', function () {
        localStorage.setItem("BonLocalPromo", JSON.stringify("close"));
        $('.promo-container').removeClass('active-list')
    });
}
function clickMenu() {
    jQuery(function ($) {
        $(document).mouseup(function (e) {
            var div = $("#header");
            if (!div.is(e.target) &&
                div.has(e.target).length === 0) {
                $('#menu-icon').removeClass('active');
                $('#mobile_top_menu_wrapper').removeClass('active');
                $('#wrapper').removeClass('active');
                $('#mobile_top_menu_wrapper').css('transition', 'all 0.2s linear');
            }
        });
    });
}

function clickBonTheme() {
    jQuery(function ($) {
        $(document).mouseup(function (e) {
            var div = $(".bon-custom-menu");
            if (!div.is(e.target) &&
                div.has(e.target).length === 0) {
                $('#custom-menu-open').removeClass('custom-button-active');
                $('.bon-custom-menu').removeClass('custom-menu-active');
            }
        });
    });
}

function promoCodePopup() {
    let promoList = $('.promo-list');
    if (promoList.length) {
        let listItems = $('li', promoList);
        if (listItems.length) {
            $('.close-promo-popup').on('click', function () {
                $('.promo-container').removeClass('active-list');
            })

        }
    }
}
function getPageWidth() {
    let pageWidth = window.innerWidth;

    if (typeof pageWidth != "number") {
        // if browser work in standard mode
        if (document.compatMode == "CSS1Compat") {
            pageWidth = document.documentElement.clientWidth;
        } else {
            pageWidth = document.body.clientWidth;
        }
    }

    return pageWidth;
}

function stickyMenu() {
    let header = document.getElementById("header");
    let headerHeight = $('#header').height();
    let navHeight = $('#header .header-top .container .row').height();
    let sticky = header.offsetTop + headerHeight;

    $(window).on("scroll", function () {
        // stickyMenuCode();
    });

    // window.addEventListener('resize', function(event) {
    //     stickyMenuCode();
    // });

    // function stickyMenuCode() {
    //     if ($('.input-sticky-header').attr('value') === 'on') {
    //         if (getPageWidth() > 576) {
    //             let selector = $(window).scrollTop() > sticky ? "#header .header-top" : '#header';
    //             $('#mobile_top_menu_wrapper').css('position', 'absolute').css('top', $(selector).height()).css('transition', 'none').css('height', 'calc(100vh - ' + $(selector).height() + 'px');
    //         } else {
    //             if ($(window).scrollTop() > sticky) {
    //                 $('#mobile_top_menu_wrapper').css('position', 'fixed').css('top', '0').css('height', 'calc(100vh - ' + navHeight + 'px');
    //             } else {
    //                 $('#mobile_top_menu_wrapper').css('position', 'absolute').css('top', $("#header").height()).css('transition', 'none').css('height', 'calc(100vh - ' + headerHeight + 'px');
    //             }
    //         }
    //     } else {
    //         if ($(window).scrollTop() > sticky) {
    //             $('#mobile_top_menu_wrapper').css('position', 'fixed').css('top', 0).css('transition', 'none').css('height', '100vh - ' + $('#header .header-top .row > .col-12.position-static').height());
    //         } else {
    //             $('#mobile_top_menu_wrapper').css('position', 'absolute').css('top', $('#header').height()).css('transition', 'none').css('height', 'calc(100vh - ' + headerHeight + 'px');
    //         }
    //     }
    // }
}
function stickyHeader() {
    let header = document.getElementById("header");
    let headerHeight = $('#header').height();
    let mainHeight = $('main').height();
    let sticky = header.offsetTop + headerHeight;

    if (mainHeight > 1200) {
        $(window).on("scroll", function () {
            // bottom page
            if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight && $(window).scrollTop() > sticky) {
                $('#header').addClass("bottom-hide");
            } else {
                $('#header').removeClass("bottom-hide");
            }

            if ($('.input-sticky-header').attr('value') === 'on') {
                if ($(window).scrollTop() > sticky) {
                    $('#header').addClass('sticky-head');
                } else {
                    $('#header').removeClass('sticky-head');
                }
            } else {
                $('#header').removeClass('sticky-head');
            }
        });
    }
}


function stickyCart() {
    const pageName = document.querySelector('body').getAttribute('id');

    if (pageName === 'product') {
        const productRight = document.querySelector('#product .col-md-6.product-page-right');
        let skrollHeight = productRight.offsetHeight + 70;

        // чтобы страница не прыгала при скролле
        if ($(window).width() >= 1300 &&
            $('.input-sticky-cart').attr('value') === 'on') productRight.style.minHeight = skrollHeight + 'px';

        $(window).on("scroll", function () {
            // чтобы не прыгала страница при скролле
            if ($(window).width() >= 1300 && $('.input-sticky-cart').attr('value') === 'on') {
                const footerEl = document.querySelector('#product #footer');
                if ($(window).scrollTop() > skrollHeight) {
                    $('#product .product-information .product-actions').attr('id', 'bon-stick-cart');
                    let blockHeight = document.querySelector('#bon-stick-cart').offsetHeight;
                    footerEl.style.paddingBottom = blockHeight + 'px';
                } else {
                    $('#product .product-information .product-actions').attr('id', '');
                }
            } else {
                $('#product .product-information .product-actions').attr('id', '');
            }
        });
    }
}


function openLeftMenu() {
    let customMenu = $('.bon-custom-menu');
    let customMenuButton = $('#custom-menu-open');
    $(customMenuButton).on('click', function () {
        if ($(customMenuButton).hasClass('custom-button-active')) {
            $(customMenuButton).removeClass('custom-button-active');
            $(customMenu).removeClass('custom-menu-active');
        } else {
            $(customMenuButton).addClass('custom-button-active');
            $(customMenu).addClass('custom-menu-active');
        }

    });
}

function boxedBody() {
    if ($(window).width() > 1600) {
        $('.input-boxed').on('click', function () {
            if ($('.switch-boxed').hasClass('active')) {
                $('.switch-boxed').removeClass('active');
                $('.input-boxed').parent().removeClass('active');
                $('.toggle-bg .input-boxed').attr('value', 'off');
            } else {
                $('.switch-boxed').addClass('active');
                $('.input-boxed').parent().addClass('active');
                $('.toggle-bg .input-boxed').attr('value', 'on');
            }
            if ($('.input-boxed').attr('value') === 'on') {
                $('#footer').addClass('boxed');
                $('main').addClass('boxed');
                $('#bonbanners').addClass('boxed-banners');
                $('body').addClass('boxed-body');
                $('.footer-container').css('margin-top', '0px');
                $('.box-bonslick').addClass('slick-boxed');
                $('#bon-stick-cart').addClass('boxed');
                $('.bon-shipping').addClass('shipping-boxed');
                $('.product-container').addClass('boxed');
            } else {
                $('main').removeClass('boxed');
                $('#footer').removeClass('boxed');
                $('.footer-container').css('margin-top', '20px');
                $('body').removeClass('boxed-body');
                $('#bonbanners').removeClass('boxed-banners');
                $('.box-bonslick').removeClass('slick-boxed');
                $('#bon-stick-cart').removeClass('boxed');
                $('.bon-shipping').removeClass('shipping-boxed');
                $('.product-container').removeClass('boxed');
            }
        });
    } else {
        $('.boxed-setting').css('display', 'none');
    }
}

$('.input-sticky-header').on('click', function () {
    if ($('.switch-header').hasClass('active')) {
        $('.switch-header').removeClass('active');
        $('.input-sticky-header').parent().removeClass('active');
        $('.input-sticky-header').attr('value', 'off');
    } else {
        $('.switch-header').addClass('active');
        $('.input-sticky-header').parent().addClass('active');
        $('.input-sticky-header').attr('value', 'on');
        stickyHeader();
    }
});



$('.input-sticky-cart').on('click', function () {
    if ($('.switch-cart').hasClass('active')) {
        $('.switch-cart').removeClass('active');
        $('.input-sticky-cart').parent().removeClass('active');
        $('.input-sticky-cart').attr('value', 'off');
    } else {
        $('.switch-cart').addClass('active');
        $('.input-sticky-cart').parent().addClass('active');
        $('.input-sticky-cart').attr('value', 'on');
        stickyCart();
    }
});


$('.input-sticky-footer').on('click', function () {
    if ($('.switch-footer').hasClass('active')) {
        $('.switch-footer').removeClass('active');
        $('.input-sticky-footer').parent().removeClass('active');
        $('.input-sticky-footer').attr('value', 'off');
        stickyFooter();
    } else {
        $('.switch-footer').addClass('active');
        $('.input-sticky-footer').parent().addClass('active');
        $('.input-sticky-footer').attr('value', 'on');
        stickyFooter();
    }
});


function stickyFooter() {
    let windowWidth = parseInt($(window).width());
    let footerResponsiveHeight = parseInt($('#footer').outerHeight(true));
    let footer = $('#footer');
    let mainContainer = $('main');
    let nav = navigator.userAgent;
    let documentHeight = parseInt($(document).height());

    if (windowWidth >= 768 && $('.input-sticky-footer').attr('value') === 'on' && documentHeight > 1300) {
        if (navigator.userAgent.search("Chrome") >= 0 && !(nav.match(/Edge/))) {
            $(footer).addClass('sticky-footer');
            $(mainContainer).css('margin-bottom', '0');
            // $(mainContainer).css('margin-bottom', footerResponsiveHeight + 'px');
        } else {
            $(footer).removeClass('sticky-footer');
            (mainContainer).css('margin-bottom', '0');
            (mainContainer).css('padding-bottom', '0');
        }
    } else {
        $(footer).removeClass('sticky-footer');
        (mainContainer).css('margin-bottom', '0');
        (mainContainer).css('padding-bottom', '0');
        $('.input-sticky-footer').attr('value', 'off');
    }
}


function adaptiveHeight() {
    let mainContainer = $('main');
    let documentHeight = parseInt($(document).height());

    if (documentHeight < 1300) {
        $('#footer').removeClass('sticky-footer').css('z-index', '1');
        $(mainContainer).css('margin-bottom', '0');
    }

    $(window).on("scroll", function () {
        if (documentHeight < 1300) {
            $('#footer').removeClass('sticky-footer').css('z-index', '1');
            $(mainContainer).css('margin-bottom', '0');
        }
    });


    if (navigator.userAgent.search("Firefox") >= 0) {

        if (documentHeight < 1300) {
            $('#footer').removeClass('sticky-footer').css('z-index', '1');
            $(mainContainer).css('padding-bottom', '0');
            $(mainContainer).css('margin-bottom', '0');
        }

        $(window).on("scroll", function () {
            if (documentHeight < 1300) {
                $('#footer').removeClass('sticky-footer').css('z-index', '1');
                $(mainContainer).css('padding-bottom', '0');
                $(mainContainer).css('margin-bottom', '0');
            }
        });
    }

}

function selectFonts () {
    let body = $("body");
    body.addClass(theme_fonts)
    if(body.hasClass(theme_fonts)){
        $(this).removeClass(theme_fonts)
    }
}

function changeLanguageCustom() {
    $('.bon-select-form').on('change', function () {
        let languageValue = $(this).val();
        let body = $('body');
        switch (languageValue) {
            case 'Lato':
                $(body).addClass('Lato');
                $(body).removeClass('Raleway OpenSans Inter Roboto Oswald Ubuntu Playfair Lora Indie Hind');
                break;
            case 'Raleway':
                $(body).addClass('Raleway');
                $(body).removeClass('OpenSans Inter Roboto Oswald Ubuntu Playfair Lora Indie Hind Lato');
                break;
            case 'OpenSans':
                $(body).addClass('OpenSans');
                $(body).removeClass('Raleway  Inter Roboto Oswald Ubuntu Playfair Lora Indie Hind Lato');
                break;
            case 'Roboto':
                $(body).addClass('Roboto');
                $(body).removeClass('Raleway  Inter OpenSans Oswald Ubuntu Playfair Lora Indie Hind Lato');
                break;
            case 'Oswald':
                $(body).addClass('Oswald');
                $(body).removeClass('Raleway  Inter OpenSans Roboto Ubuntu Playfair Lora Indie Hind Lato');
                break;
            case 'Ubuntu':
                $(body).addClass('Ubuntu');
                $(body).removeClass('Raleway  Inter OpenSans Roboto Oswald Playfair Lora Indie Hind Lato');
                break;
            case 'Playfair':
                $(body).addClass('Playfair');
                $(body).removeClass('Raleway  Inter OpenSans Roboto Oswald Ubuntu Lora Indie Hind Lato');
                break;
            case 'Lora':
                $(body).addClass('Lora');
                $(body).removeClass('Raleway  Inter OpenSans Roboto Oswald Ubuntu Playfair Indie Hind Lato');
                break;
            case 'Indie':
                $(body).addClass('Indie');
                $(body).removeClass('Raleway  Inter OpenSans Roboto Oswald Ubuntu Playfair Lora Hind Lato');
                break;
            case 'Hind':
                $(body).addClass('Hind');
                $(body).removeClass('Raleway  Inter OpenSans Roboto Oswald Ubuntu Playfair Lora Indie Lato');
                break;
            default:
                $('body').addClass('Inter');
                $(body).removeClass('Raleway Hind OpenSans Roboto Oswald Ubuntu Playfair Lora Indie Lato');
                break;
        }
    });
}


function customPseudoStyles() {
    window.addRule = function (selector, styles, sheet) {

        styles = (function (styles) {
            if (typeof styles === "string") return styles;
            var clone = "";
            for (var prop in styles) {
                if (styles.hasOwnProperty(prop)) {
                    var val = styles[prop];
                    prop = prop.replace(/([A-Z])/g, "-$1").toLowerCase();
                    clone += prop + ":" + (prop === "content" ? '"' + val + '"' : val) + "; ";
                }
            }
            return clone;
        }(styles));
        sheet = sheet || document.styleSheets[document.styleSheets.length - 1];

        if (sheet.insertRule) sheet.insertRule(selector + " {" + styles + "}", sheet.cssRules.length);
        else if (sheet.addRule) sheet.addRule(selector, styles);

        return this;

    };

    if ($) $.fn.addRule = function (styles, sheet) {
        addRule(this.selector, styles, sheet);
        return this;
    };
}

function MyStyleColor(color) {
    $(" #productCommentsBlock .pull-right .open-comment-form,.featured-products .btn-row .bon-tooltip, .product-miniature .btn-row .bon-tooltip").addRule({
        borderColor: color.rgbaString,
    });
    $(' #header .header-top .position-static #_desktop_setting-header i.active').addRule({
        color: color.rgbaString,
    });
    $('#bonwishlist .wishlist-summary-product-name .product-title:hover span').addRule({
        color: color.rgbaString,
    });

    $('#bonwishlist .wishlist-tooltip:hover i').addRule({
        color: color.rgbaString,
    });

    $('#bonwishlist .wishlist_add_to_cart_button:hover i').addRule({
        color: color.rgbaString,
    });

    $("li.product-flag.new:after").addRule({
        borderColor: color.rgbaString,
        borderRightColor: 'transparent',
        borderBottomColor: 'transparent',
    });

    $("#product li.product-flag.new:after").addRule({
        borderColor: color.rgbaString,
        borderRightColor: 'transparent',
        borderBottomColor: 'transparent',
    });

    $("#_desktop_top_menu ul[data-depth='0']>li>a:after").addRule({
        backgroundColor: color.rgbaString,
    });
    $(".products-section-title:before, #bonnews a.read-more:after").addRule({
        backgroundColor: color.rgbaString,
    });

    $(".tabs .nav-tabs .nav-item .nav-link:after").addRule({
        backgroundColor: color.rgbaString,
    });

    $(".footer-container .links li a:hover:before, #bonnews .slick-prev:hover:before, #bonnews .slick-next:hover:before").addRule({
        color: color.rgbaString,
    });

    $(".custom-radio input[type='radio'] + span:before,#bonlookbookfw .bonlookbookfw_item-pointer:after,#bonnews.bon-home .box-bonnews h3:before,#bonpromotion .bonpromotion-countdown > span span," +
        ".boncategoruproduct .boncategoruproduct-item p.h2:before,#bonslider .swiper-pagination-bullet-active").addRule({
        backgroundColor: color.rgbaString,
    });

    $(".products-sort-order .select-title:after").addRule({
        color: color.rgbaString,
    });

    $("#video-container #controls .play:hover:before").addRule({
        color: color.rgbaString,
    });

    $("#video-container #controls .pause:hover:before").addRule({
        color: color.rgbaString,
    });

    $("#video-container #controls .mute:hover:before").addRule({
        color: color.rgbaString,
    });

    $("#video-container #controls .unmute:hover:before").addRule({
        color: color.rgbaString,
    });

    $("#bonslick .slick-prev:hover:before").addRule({
        color: color.rgbaString,
    });

    $("#bonslick .slick-next:hover:before").addRule({
        color: color.rgbaString,
    });

    $("#main .images-container .js-qv-mask .slick-slider .slick-arrow.slick-next:hover:before").addRule({
        color: color.rgbaString,
    });

    $("#main .images-container .js-qv-mask .slick-slider .slick-arrow.slick-prev:hover:before").addRule({
        color: color.rgbaString,
    });

    $('.product-add-to-cart .product-quantity .bon-product-popup .bon-product-delivery a:hover:before').addRule({
        color: color.rgbaString
    });

    $('.product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a:hover:before').addRule({
        color: color.rgbaString
    });

    $('.product-add-to-cart .product-quantity .bon-product-popup .bon-review-inner a:hover:before').addRule({
        color: color.rgbaString
    });


    $('.social-sharing ul li a:hover:before').addRule({
        color: color.rgbaString,
    });

    $('.product-quantity .bon-product-popup .title-popup-1:hover:before').addRule({
        color: color.rgbaString,
    });
    $('.featured-products .thumbnail-container .thumbnail-container-images .add-to-cart-block .bon-tooltip.add-to-cart-btn:hover .ajax_add_to_cart_button > i').addRule({
        color: color.rgbaString,
    });
    $('.product-miniature .thumbnail-container .thumbnail-container-images .add-to-cart-block .bon-tooltip.add-to-cart-btn:hover .ajax_add_to_cart_button > i').addRule({
        color: color.rgbaString,
    });

    $('.product-quantity .bon-product-popup .title-popup-2:hover:before').addRule({
        color: color.rgbaString,
    });
    $('.product-miniature .bonwishlist-hook-wrapper:hover .wish-button.active:before').addRule({
        color: color.rgbaString,
    });
    $('.product-miniature .bonwishlist-hook-wrapper:hover .wish-button').addRule({
        color: color.rgbaString,
    });
    $('#header #_desktop_cart:hover svg path, #header #_desktop_user_info:hover svg path, #header #boncompare:hover svg path, #header #bonwishlist:hover svg path, #header .bon-search-icon:hover svg path,' +
        '.featured-products .thumbnail-container .thumbnail-container-images .add-to-cart-block > div:hover svg path, .bonwishlist-hook-wrapper:hover svg path,' +
        '.product-miniature .thumbnail-container .thumbnail-container-images .add-to-cart-block > div:hover svg path,.boncompare-hook-wrapper:hover svg path,' +
        '#bonbanners .banner-inner_footer-soc a:hover svg path,#bonslider .bonslider-social a:hover svg path,' +
        '#bonlookbook .bonlookbook-button-prev:hover > svg > path, #bonlookbook .bonlookbook-button-next:hover > svg > path').addRule({
        fill: color.rgbaString,
    });
    $('.featured-products .thumbnail-container .thumbnail-container-images .add-to-cart-block .bon-tooltip.btn-quick-view:hover .quick-view i:before').addRule({
        color: color.rgbaString,
    });
    $('#bonlookbookfw .bonlookbookfw_item-pointer circle,body main .wish-button.active path,.compare-button.active path, .products .product-thumbnail svg path').addRule({
        fill: color.rgbaString,
    });
    $('#bonlookbookfw .bonlookbookfw_item-pointer-content .bonlookbookfw_point-title').attr('style', 'color: ' + color.rgbaString +' !important');
    $('#bonbanners .h1').attr('style', '-webkit-text-stroke-color: ' + color.rgbaString);
    $('.product-add-to-cart .product-quantity .bon-review-inner a:hover:before').addRule({
        color: color.rgbaString,
    });
    $('.product-miniature .thumbnail-container .thumbnail-container-images .add-to-cart-block .bon-tooltip.btn-quick-view:hover .quick-view i::before').addRule({
        color: color.rgbaString,
    });
    $('#header #_desktop_setting-header:hover,#bonswiper .bonswiper-button-next:hover:after, #bonswiper .bonswiper-button-prev:hover:after').addRule({
        color: color.rgbaString,
    });
    $('.featured-products .thumbnail-container .thumbnail-container-images .add-to-cart-block > div:hover svg.shopping-cart path, ' +
        '.product-miniature .thumbnail-container .thumbnail-container-images .add-to-cart-block > div:hover svg.shopping-cart path,' +
        '.bonwishlist-hook-wrapper svg path,#bonslider .swiper-pagination-bullet-active .circle,' +
        'body:not(#module-bonlookbookfw-main) #bonlookbookfw .bonlookbookfw_item-pointer-content path,.boncompare-hook-wrapper svg path').addRule({
        stroke: color.rgbaString,
    });

    $('.product-add-to-cart .product-quantity .bon-product-popup .bon-review-inner a:hover:before,.bonslider-item-description p.h1,#bonlookbookfw .bonlookboon_point-product-title a:hover,' +
        '.product-price-and-shipping .price-has-discount,#bonpromotion .box-promotion .box-promotion-desc h3,' +
        '.product-add-to-cart .product-quantity .bon-product-popup .bon-product-delivery a:hover:before,#bonlookbookfw .bonlookbookfw_header-title .h1 span,' +
        '#header a:hover::after, #header a:hover i, #header a:not(.dropdown-item):hover span,#boncompare:hover .bonicon-compare, .boncompare-hook-wrapper:hover .compare-button::before,' +
        '.box-bonslick h2, .home-category .category-item:hover .category-name, .home-category .category-item .category-info span, .newsletter-content p b,' +
        '.product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a:hover:before,#bonlookbook .bonlookboon_point-product-link a:hover, ' +
        '#bonlookbook .bonlookboon_point-product-title a:hover,a:hover,#bonnews a.read-more,.bon-newsletter-coupon p,.product-price-and-shipping,' +
        '#trends_products .swiper-button-next:hover:after, #trends_products .swiper-button-prev:hover:after,#bonlookbook .bonlookbook_header-title .h1 span,' +
        '.swiper-button-next.bonswiper-button-next.theme-style:hover, .swiper-button-prev.bonswiper-button-prev.theme-style:hover,' +
        '#footer .footer-container #block_myaccount_infos .myaccount-title a,' +
        '#bonlookbook .bonlookbook-button-next:hover, #bonlookbook .bonlookbook-button-prev:hover,.products-section-title span,#footer .footer-container .h3').addRule({
        color: color.rgbaString,

    });
    $('#bonbanners .h1').addRule({
        webkitTextStrokeColor: color.rgbaString,
    });

    if (navigator.userAgent.search('Chrome') >= 0) {
        $("::-webkit-scrollbar-thumb:hover").addRule({
            backgroundColor: color.rgbaString,
        });
    }

    $('#write-review-anchor, #bonslick .box-bonslick span' +
        ', li.product-flag.new, .meshim_widget_components_chatButton_Button .button_bar, body .bon-shipping' +
        ', .featured-products-swiper .swiper-pagination .swiper-pagination-progressbar-fill,.footer_before .block_newsletter' +
        ', .btn-primary, .custom-checkbox input[type=checkbox]+span .checkbox-checked, .bonpromotion-countdown-btn, .product-actions .add-to-cart, .toggle-bg.active,' +
        '#bonswiper .swiper-slide .box-bonslick .bonswiper-btn,#bonswiper .swiper-pagination-progressbar .swiper-pagination-progressbar-fill,' +
        '.product-add-to-cart .product-quantity .bon-stock-countdown .bon-stock-countdown-range .bon-stock-countdown-progress').css('background', color.rgbaString);

    $('#_desktop_top_menu .top-menu .nav-arrows i, #product-availability .product-available, .pagination .current a, .product-page-right .product-price .current-price, #_desktop_top_menu > .top-menu> li.sfHover > a,' +
        '#header .header-top .position-static .bon-nav-bar #_desktop_cart:hover .blockcart i, a:hover, #boncompare .compare-count, #bonwishlist .wishlist-count, #header #_desktop_cart:not(.bon-desktop-sticky-cart) .cart-products-count,' +
        '#main .product-information .product-actions #group_1 .input-container label span.check,#_desktop_search_widget .bonsearch_button.active, #header .header-top .position-static #_desktop_setting-header i.active' +
        ', .quickview .modal-content .modal-body .product-price .current-price,.product-container .product-list .product-item .item-description .product-item-name, #bonwishlist .wishlist_add_to_cart_button:hover i').css('color', color.rgbaString);

    $('#header .top-menu a[data-depth="0"], #header .header-top .position-static #_desktop_setting-header i, .bonsearch,' +
        '#header .header-top .position-static #_desktop_user_info i, #header .header-top .position-static #_desktop_cart .blockcart i,' +
        '.bonthumbnails li a, .footer-container .links li a, #wrapper .breadcrumb li a, .pagination a:not(.previous):not(.next), .pagination .next, .pagination .previous, .featured-products .product-title a,' +
        '.product-accessories .product-title a, .product-miniature .product-title a, .footer-container-bottom a, #search_filters .facet .facet-label a, #_desktop_top_menu .sub-menu ul[data-depth="1"]>li a' +
        ', #_desktop_top_menu .sub-menu ul[data-depth="2"]>li a, .footer-container .product-container .product-list .product-item .item-description .product-item-name' +
        ', #header #_desktop_currency_selector .currency-selector ul li a, #back-to-top, .bonsearch #search_popup .wrap_item .product_image h5, .bon_manufacture_list h4 a, #bon_manufacturers_block .owl-nav .owl-prev' +
        ',#bon_manufacturers_block .owl-nav .owl-next, #bonwishlist .wishlist-tooltip i, .product-add-to-cart .product-quantity .bon-product-popup .bon-product-delivery a,.product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a,' +
        '.product-add-to-cart .product-quantity .bon-product-popup .bon-review-inner a, .comments_note a span, .bon-newsletter .bon-newsletter-close > i,' +
        '.product-add-to-cart .product-quantity .bon-product-popup .bon-product-delivery a, #main .product-information .product-actions #group_1 .input-container label:hover span.radio-label,' +
        '.product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a, .product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a,' +
        '.product-quantity .bon-product-popup .title-popup-1, .product-quantity .bon-product-popup .title-popup-2, .product-add-to-cart .product-quantity .bon-review-inner a, .product-container .product-list .product-item .item-description .product-item-name').hover(function () {
        $(this).css('color', color.rgbaString).addClass('color-bon');
        $('.active-color-bon').not($(this)).removeClass('color-bon').css('color', '');
        $(this).on('mouseleave', function () {
            $(this).css('color', '');
        })
    });

    $('#main .product-information .product-actions #group_1 .input-container label span.check').css('border-color', color.rgbaString);

    $('.btn-primary').hover(function () {
        $(this).css('border-color', color.rgbaString);
        $(this).css('backgroundColor', color.rgbaString);
    });

    $('#productCommentsBlock .pull-right .open-comment-form').hover(function () {
        $(this).css('border-color', color.rgbaString);
        $(this).css('backgroundColor', color.rgbaString);
        $(this).css('color', '#ffffff');
    });

    $('.bonthumbnails li a, #main .images-container .js-qv-mask .slick-slider .slick-slide,#main .images-container .js-qv-mask .slick-slider .slick-slide.selected').hover(function () {
        $(this).css('box-shadow', 'inset 0 0 0 2px ' + color.rgbaString).addClass('active-hover-bon');
        $('.active-hover-bon').not($(this)).removeClass('active-hover-bon').css('box-shadow', '');
    });

    $('.bonthumbnails li.active').css('box-shadow', 'inset 0 0 0 2px ' + color.rgbaString);
}


// Grid list


function GridList() {
    animateGrid();

    if ($("#category").length) {
        var product_col = JSON.parse(localStorage.getItem("ProductCol")) || 3;
        gridResponse();

        function gridResponse() {
            if ($(window).width() > 1024) {
                $(".products-grid").addClass('active');

                prestashop.on("updateProductList", () => {
                    $(".products-grid").addClass('active');
                    GridCss();
                    GridAddClass();
                });

                function GridCss() {
                    $(".products-grid.active").attr("style", "--product-col:" + product_col);
                }

                function GridAddClass() {
                    var product_col = JSON.parse(localStorage.getItem("ProductCol")) || 3;
                    if (product_col == 1) {
                        localStorage.setItem("class", JSON.stringify("product-one"));
                        $("#js-product-list article").addClass("product-one");

                    } else {
                        $("#js-product-list article").removeClass("product-one");
                    }
                    if (product_col == 2) {
                        localStorage.setItem("class", JSON.stringify("product-two"));
                        $("#js-product-list article").addClass("product-two");

                    } else {
                        $("#js-product-list article").removeClass("product-two");
                    }
                    if (product_col == 3) {
                        localStorage.setItem("class", JSON.stringify("product-three"));
                        $("#js-product-list article").addClass("product-three");

                    } else {
                        $("#js-product-list article").removeClass(
                            "product-three"
                        );
                    }
                    if (product_col == 4) {
                        localStorage.setItem("class", JSON.stringify("product-four"));
                        $("#js-product-list article").addClass("product-four");

                    } else {
                        $("#js-product-list article").removeClass("product-four");
                    }
                }


                GridCss();
                $(".buttons-grid button").removeClass('--active');
                $(".buttons-grid")
                    .find("button[data-grid=" + product_col + "]")
                    .addClass("--active");
                $(".products-grid.active").css("--product-col", product_col);

                $(".buttons-grid").on("click", "button[data-grid]", function () {
                    animateGrid();
                    if (!$(this).hasClass("--active")) {
                        product_col = $(this).attr("data-grid");
                        $(".buttons-grid").find("button.--active").removeClass("--active");
                        $(this).addClass("--active");
                        GridCss();
                        localStorage.setItem("ProductCol", JSON.stringify(product_col));
                    }
                    GridAddClass();

                });
                GridAddClass();
            }

        }

        $(window).resize(function () {
            gridResponse();
            if ($(window).width() <= 1024) {
                $("#js-product-list article").removeClass("product-one");
                $(".products-grid.active").removeClass('active');
            } else if (($(window).width() > 1024)) {
                gridResponse();
            }
            hideFourthGridBtn();
        });
    }
    hideFourthGridBtn();

    function hideFourthGridBtn() {
        if (($(window).width() < 1280) && !($(".buttons-grid button:first-child").hasClass('--active'))) {
            $("#js-product-list article").removeClass("product-four");
            $("#js-product-list article").addClass("product-three");
            $(".buttons-grid button").removeClass('--active');
            $(".buttons-grid button[data-grid=\"3\"]").addClass('--active');
        }
    }
    function animateGrid() {
        let $window = $(window);
        $('.revealOnScroll').addClass('animated');

        $window.on('scroll', gridAnimate);

        function gridAnimate() {
            let scrolled = $window.scrollTop(),
                win_height_padded = $window.height() * 1.1;
            $(".gridAnimate.revealOnScroll:not(.animated)").each(function () {
                let $this = $(this),
                    offsetTop = $this.offset().top;
                if (scrolled + win_height_padded > offsetTop) {
                    if ($this.data('timeout')) {

                        window.setTimeout(function () {
                            $this.addClass('animated ' + $this.data('animation'));
                        }, 2000);
                    } else {
                        $this.addClass('animated ' + $this.data('animation'));
                    }
                }

            });
            $(".gridAnimate.revealOnScroll.animated").each(function () {
                let $this = $(this),
                    offsetTop = $this.offset().top;
                if (scrolled + win_height_padded < offsetTop) {
                    $(this).removeClass('animated fadeInUp zoomIn fadeInLeft rollIn rotateInDownRight wobble flash pulse fadeInDown fadeInRight rotateIn rotateInUpLeft tada shake fadeInLeftBig lightSpeedIn slideInUp  flipInY hinge fadeInLeftBig flip rotateInDownLeft  rotateInUpRight slideInLeft slideInRight  flipInX ');
                }
            });
        }
    };

    let count8 = 1;

    $('#category .product-miniature').each(function () {
        $(this).attr('data-timeout', count8 * 90);
        count8++;
    });
}