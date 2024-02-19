{*
* 2015-2020 Bonpresta
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
* @author Bonpresta
* @copyright 2015-2020 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{if isset($theme_color_demo) && $theme_color_demo}
<button id="custom-toggler"></button>
{/if}

<div class="bon-custom-menu">
    <button id="custom-menu-open"></button>
    <div class="boxed-setting">
        <p>Boxed:</p>
        <span class="toggle-bg ">
            <input class="input-boxed " type="radio" value="on">
            <span class="switch-boxed "></span>
        </span>
    </div>
    <div class="Sticky-header">
        <p>Sticky Header:</p>
        <span class="toggle-bg active">
            <input class="input-sticky-header" type="radio" value="on">
            <span class="switch-header active"></span>
        </span>
    </div>
    <div class="sticky-addcart">
        <p>Sticky Add To Cart</p>
        <span class="toggle-bg active">
            <input class="input-sticky-cart" type="radio" value="on">
            <span class="switch-cart active"></span>
        </span>
    </div>
    <div class="Sticky-footer">
        <p>Sticky Footer:</p>
        <span class="toggle-bg active">
            <input class="input-sticky-footer" type="radio" value="on">
            <span class="switch-footer active"></span>
        </span>
    </div>
    <div class="bon-select-language">
        <p>Font:</p>
        <form id="bon-select">
            <select class="bon-select-form" name="language-select" form="bon-select">
                <option value="Lato">Lato</option>
                <option value="Raleway">Raleway</option>
                <option value="OpenSans">OpenSans</option>
                <option value="Roboto">Roboto</option>
                <option value="Oswald">Oswald</option>
                <option value="Ubuntu">Ubuntu</option>
                <option value="Playfair">Playfair</option>
                <option value="Lora">Lora</option>
                <option value="Indie">Indie</option>
                <option value="Hind">Hind</option>
            </select>
        </form>
    </div>
</div>




{if isset($theme_promo) && $theme_promo && $theme_enable_promo && $theme_enable_promo && $page.page_name === "index"}
<div class="promo-container">
    <ul class="promo-list">
        <li class="promo-item active-item">
            <a class="promo-item-inner" target="_blank" href="{$theme_promo_link}">
                <div class="item-description">
                    <span class="name">Promotion Code -30%</span>
                    <div class="promo-code-value">
                        <span class="value">{$theme_promo}</span>
                    </div>
                    <span class="btn btn-primary">Buy now</span>
                </div>

            </a>
            <button class="close-promo-popup"></button>
        </li>
    </ul>
</div>
{/if}


{if isset($theme_color_enable) && $theme_color_enable}
<style>
    #bonbanners .h1 {
        -webkit-text-stroke-color: {$theme_color|escape: 'html':'UTF-8'};
    }
    #bonnews.bon-home .box-bonnews h3:before,#bonpromotion .bonpromotion-countdown > span span,.boncategoruproduct .boncategoruproduct-item p.h2:before,
    #bonslider .swiper-pagination-bullet-active {
        background-color: {$theme_color|escape: 'html':'UTF-8'};
    }
    #bonswiper .swiper-slide .box-bonslick .bonswiper-btn::before, .featured-products-swiper .swiper-pagination .swiper-pagination-progressbar-fill,
    #bonswiper .swiper-pagination-progressbar .swiper-pagination-progressbar-fill,.footer_before .block_newsletter,
    #bonswiper .swiper-slide .box-bonslick .bonswiper-btn:hover,#bonnews a.read-more::after,
    .products-section-title::before, .btn-primary::before, .btn-secondary::before, .btn-tertiary::before {
        background: {$theme_color|escape: 'html':'UTF-8'};
    }
    #bonswiper .swiper-slide .box-bonslick .bonswiper-btn:hover,#bonlookbookfw .bonlookboon_point-product-title a:hover,
    #footer .footer-container #block_myaccount_infos .myaccount-title a,
    .btn-primary:active, .btn-primary:focus, .btn-primary:hover, .btn-secondary:active, .btn-secondary:focus,#footer .footer-container .h3,
    .btn-secondary:hover, .btn-tertiary:active, .btn-tertiary:focus, .btn-tertiary:hover,.product-price-and-shipping .price-has-discount,
    #bonwishlist:hover .wishlist-tooltip i, .btn-primary, #bonpromotion .bonpromotion-countdown-btn:hover,
    #bonpromotion .bonpromotion-countdown-btn:active, a:hover,#footer .block_newsletter form .btn-footer:hover::after {
        color: #fff;
    }

    #bonslick .slick-slide .box-bonslick span,
    #bonslick .slick-slide .box-bonslick span:hover,
    li.product-flag.new,
    .meshim_widget_components_chatButton_Button .button_bar,
    body .bon-shipping,
    .btn-primary,
    .btn-primary:hover,
    .custom-checkbox input[type=checkbox]+span .checkbox-checked,
    .bonpromotion-countdown-btn,
    .product-accessories .thumbnail-container .ajax_add_to_cart_button,
    .toggle-bg.active {
        background: none;
               background-color: {$theme_color|escape: 'html':'UTF-8'};
               border-color: {$theme_color|escape: 'html':'UTF-8'};
    }

    nav#header-nav .navigation #_desktop_top_menu .top-menu .nav-arrows i,
    #product-availability .product-available,#header .header-top .position-static .bon-nav-bar #_desktop_setting-header:focus i,
    #header .header-top .position-static .bon-nav-bar #_desktop_setting-header:hover i,
    #header .header-top .position-static .bon-nav-bar #_desktop_user_info:focus i,#bonlookbookfw .bonlookbookfw_header-title .h1 span,
    #header .header-top .position-static .bon-nav-bar #_desktop_user_info:hover i,
    #bonnews .slick-prev:hover::before,#bonnews .slick-next:hover:before,.bonslider-item-description p.h1,
    .product-miniature .bonwishlist-hook-wrapper:hover .wish-button.active::before,
    .box-bonslick h2, .home-category .category-item:hover .category-name, .home-category .category-item .category-info span, .newsletter-content p b,
    .pagination .current a,#boncompare:hover .bonicon-compare, .boncompare-hook-wrapper:hover .compare-button::before,
    .product-page-right .product-price .current-price,.product-miniature .bonwishlist-hook-wrapper:hover .wish-button.active::before,
    .featured-products .thumbnail-container .thumbnail-container-images .add-to-cart-block .bon-tooltip.btn-quick-view:hover .quick-view i::before,
    .product-miniature .thumbnail-container .thumbnail-container-images .add-to-cart-block .bon-tooltip.btn-quick-view:hover .quick-view i::before,
    #_desktop_top_menu>.top-menu>li.sfHover>a,#_desktop_top_menu .top-menu .nav-arrows > a:hover i,
    #main .product-information .product-actions #group_1 .input-container label span.check,.products-section-title span,
    #bonswiper .bonswiper-button-next:hover::after, #bonswiper .bonswiper-button-prev:hover::after,
    #bonpromotion .box-promotion .box-promotion-desc h3,
    .featured-products .thumbnail-container .thumbnail-container-images .add-to-cart-block .bon-tooltip.add-to-cart-btn:hover .ajax_add_to_cart_button > i,
    .product-miniature .thumbnail-container .thumbnail-container-images .add-to-cart-block .bon-tooltip.add-to-cart-btn:hover .ajax_add_to_cart_button > i,
    .product-container .product-list .product-item .item-description .product-item-name,.product-miniature .bonwishlist-hook-wrapper:hover .wish-button,
    .product-container .product-list .product-item .item-description .product-item-name:hover,a:hover,.product-price-and-shipping,
    #trends_products .swiper-button-next:hover:after, #trends_products .swiper-button-prev:hover:after,#bonnews a.read-more,
    .swiper-button-next.bonswiper-button-next.theme-style:hover, .swiper-button-prev.bonswiper-button-prev.theme-style:hover,
    #bonwishlist .wishlist_add_to_cart_button:hover i,#header .header-top .position-static .bon-nav-bar #_desktop_cart:hover .blockcart i,
    #bonwishlist .wishlist-summary-product-name .product-title:hover span,#boncompare .compare-count,#bonwishlist .wishlist-count,#header #_desktop_cart:not(.bon-desktop-sticky-cart) .cart-products-count,
    #header .header-top .position-static #_desktop_setting-header i.active, #header #_desktop_setting-header:hover {
        color: {$theme_color|escape: 'html':'UTF-8'};
    }
    #bonlookbookfw .bonlookbookfw_item-pointer-content .bonlookbookfw_point-title {
        color: {$theme_color|escape: 'html':'UTF-8'}!important;
    }
    .featured-products .thumbnail-container .thumbnail-container-images .add-to-cart-block > div:hover svg.shopping-cart path,
    .product-miniature .thumbnail-container .thumbnail-container-images .add-to-cart-block > div:hover svg.shopping-cart path,
    #bonslider .swiper-pagination-bullet-active .circle {
        stroke: {$theme_color|escape: 'html':'UTF-8'};
    }
    #bonslider .bonslider-social a:hover svg path,.compare-button.active path, .products .product-thumbnail svg path,
    .bonwishlist-hook-wrapper:hover svg path,.boncompare-hook-wrapper:hover svg path,#bonbanners .banner-inner_footer-soc a:hover svg path,
    .featured-products .thumbnail-container .thumbnail-container-images .add-to-cart-block > div:hover svg path,
    .product-miniature .thumbnail-container .thumbnail-container-images .add-to-cart-block > div:hover svg path,body main .wish-button.active path,
    #bonlookbook .bonlookbook-button-prev:hover > svg > path, #bonlookbook .bonlookbook-button-next:hover > svg > path,
    #header #_desktop_cart:hover svg path, #header #_desktop_user_info:hover svg path, #header #boncompare:hover svg path, #header #bonwishlist:hover svg path, #header .bon-search-icon:hover svg path {
        fill: {$theme_color|escape: 'html':'UTF-8'};
    }
    li.product-flag.new:after,
    #productCommentsBlock .pull-right .open-comment-form {
        border-color: {$theme_color|escape: 'html':'UTF-8'};
        border-right-color: transparent;
        border-bottom-color: transparent;
    }

    #_desktop_top_menu ul[data-depth='0']>li>a:after,
    .tabs .nav-tabs .nav-item .nav-link:after,
    .custom-radio input[type='radio']+span:before,
    ::-webkit-scrollbar-thumb:hover,
    .product-actions .add-to-cart:hover,
    .featured-products .thumbnail-container .ajax_add_to_cart_button:hover,
    .product-actions .add-to-cart,
    .product-add-to-cart .product-quantity .bon-stock-countdown .bon-stock-countdown-range .bon-stock-countdown-progress {
               background: {$theme_color|escape: 'html':'UTF-8'};
    }

    .footer-container .links li a:hover:before,
    #bonwishlist .wishlist-tooltip:hover i,
    .products-sort-order .select-title:after,
    #video-container #controls .play:hover:before,
    #video-container #controls .pause:hover:before,
    #video-container #controls .mute:hover:before,
    #video-container #controls .unmute:hover:before,
    #bonslick .slick-prev:hover:before,
    #bonslick .slick-next:hover:before,
    #main .images-container .js-qv-mask .slick-slider .slick-arrow.slick-next:hover:before,
    #main .images-container .js-qv-mask .slick-slider .slick-arrow.slick-prev:hover:before,
    .bonsearch:focus,.bon-newsletter-coupon p,#bonlookbook .bonlookbook-button-next:hover, #bonlookbook .bonlookbook-button-prev:hover,
    .bonsearch_button.active,#bonlookbook .bonlookbook_header-title .h1 span,
    #header .header-top .position-static #_desktop_setting-header i.active,
    .quickview .modal-content .modal-body .product-price .current-price,
    .comments_note a span:hover,
    .product-quantity .bon-product-popup .title-popup-1:hover,
    .product-quantity .bon-product-popup .title-popup-2:hover,
    .product-add-to-cart .product-quantity .bon-review-inner a:hover,
    .product-quantity .bon-product-popup .title-popup-1:hover:before,
    .product-quantity .bon-product-popup .title-popup-2:hover:before,
    .product-add-to-cart .product-quantity .bon-review-inner a:hover:before {
               color: {$theme_color|escape: 'html':'UTF-8'};
    }

    #header .top-menu a[data-depth="0"]:hover,
    #header .header-top .position-static .bon-nav-bar #_desktop_setting-header i:hover,
    .bonsearch:hover,
    .bonsearch_button.active,
    #header .header-top .position-static .bon-nav-bar #_desktop_user_info i:hover,
    #header .header-top .position-static .bon-nav-bar #_desktop_cart .blockcart i:hover,
    #header .header-top .position-static .bon-nav-bar #_desktop_setting-header i.active,
    .bonthumbnails li a:hover,
    .footer-container .links li a:hover,
    #wrapper .breadcrumb li a:hover,
    .pagination a:not(.previous):not(.next):hover,
    .pagination .next:hover,
    .pagination .previous:hover,
    .featured-products .product-title a:hover,
    .product-accessories .product-title a:hover,
    .product-miniature .product-title a:hover,
    .footer-container-bottom a:hover,
    #search_filters .facet .facet-label a:hover,
    #_desktop_top_menu .sub-menu ul[data-depth="1"]>li a:hover,
    #_desktop_top_menu .sub-menu ul[data-depth="2"]>li a:hover,
    .footer-container .product-container .product-list .product-item .item-description .product-item-name:hover,
    #header #_desktop_currency_selector .currency-selector ul li a:hover,
    #back-to-top:hover,
    .bonsearch #search_popup .wrap_item .product_image h5:hover,
    #bon_manufacturers_block .owl-nav .owl-next:hover,
    #bon_manufacturers_block .owl-nav .owl-prev:hover,
    .bon_manufacture_list h4 a:hover,
    .bon-newsletter .bon-newsletter-close>i:hover,
    .product-add-to-cart .product-quantity .bon-product-popup .bon-product-delivery a:hover:before,
    .product-add-to-cart .product-quantity .bon-product-popup .bon-product-delivery a:hover,
    #main .product-information .product-actions #group_1 .input-container label:hover span.radio-label,
    .product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a:hover,
    .product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a:hover:before,
    .product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a:hover,
    .product-add-to-cart .product-quantity .bon-product-popup .bon-product-size a:hover:before,
    #bonwishlist .wishlist-tooltip:hover i {
               color: {$theme_color|escape: 'html':'UTF-8'};
    }

    .product-actions .add-to-cart:hover,
    .featured-products .thumbnail-container .ajax_add_to_cart_button:hover,
    #main .product-information .product-actions #group_1 .input-container label span.check,
    #main .product-information .product-actions #group_1 .input-container label:hover span.radio-label {
               border-color: {$theme_color|escape: 'html':'UTF-8'};
        ;
    }

    .bonthumbnails li a:hover,
    #main .images-container .js-qv-mask .slick-slider .slick-slide:hover,
    #main .images-container .js-qv-mask .slick-slider .slick-slide.selected,
    body .bonthumbnails li.active,
    body .bonthumbnails li:focus {
               box-shadow: inset 0 0 0 2px {$theme_color|escape: 'html':'UTF-8'};
    .wish-button.active path, .compare-button.active path {
        fill: {$theme_color|escape: 'html':'UTF-8'} !important;
    }
</style>
{/if}