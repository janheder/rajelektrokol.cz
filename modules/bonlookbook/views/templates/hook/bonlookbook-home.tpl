{*
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
* @author Bonpresta
* @copyright 2015-2022 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}
<style>
    #bonlookbook .bonlookbook_header-title a:hover {
        color: {$settingslb['BON_LOOKBOOK_TITLE_HOVER_COLOR'].value|escape:'htmlall':'UTF-8'}!important;
    }
</style>
{if isset($items) && $items}
    <section id="bonlookbook" class="bonlookbook{if $slider_settings['BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL'].value} swiper{/if}{if !($settingslb['BON_LOOKBOOK_HOME_TEXT'].value)} bonlookbook-without-text{/if}">
        {if $settingslb['BON_LOOKBOOK_TITLE'].value || $settingslb['BON_LOOKBOOK_SUBTITLE'].value}
            <div class="bonlookbook_header {$settingslb['BON_LOOKBOOK_TEXT_POSITION'].value|escape:'htmlall':'UTF-8'}">
                {if $settingslb['BON_LOOKBOOK_TITLE'].value && $settingslb['BON_LOOKBOOK_TITLE_TEXT'].value}
                    <div class="bonlookbook_header-title">
                        {assign var="text" value=$settingslb['BON_LOOKBOOK_TITLE_TEXT'].value}
                        {assign var="split" value=" "|explode:$text}
                        <a href="{$link->getModuleLink('bonlookbook', 'main')|escape:'htmlall':'UTF-8'}" class="h1" style="color: {$settingslb['BON_LOOKBOOK_TITLE_COLOR'].value|escape:'htmlall':'UTF-8'}">
                            {foreach from=$split item=item name=item}
                                {if $smarty.foreach.item.iteration == 3 || $smarty.foreach.item.iteration == 6}
                                    <span>{$item}</span>
                                {else}
                                    {$item}
                                {/if}
                            {/foreach}
                        </a>
                    </div>
                {/if}

                {if $settingslb['BON_LOOKBOOK_SUBTITLE'].value}
                    <div class="bonlookbook_header-subtitle">
                        <p class="h2" style="color: {$settingslb['BON_LOOKBOOK_SUBTITLE_COLOR'].value|escape:'htmlall':'UTF-8'}">
                            {l s='Stay ahead of the fashion trends with our new selection' mod='bonlookbook'}</p>
                    </div>
                {/if}
            </div>
        {/if}
        <div class="bonlookbook_wrapper{if $slider_settings['BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL'].value} swiper-wrapper{/if}">

            {foreach from=$items item=item name=item}

                {if $smarty.foreach.item.iteration <= $settingslb['BON_LOOKBOOK_HOME_LIMIT'].value}
                    <div class="bonlookbook_item{if $slider_settings['BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL'].value} swiper-slide{/if}">

                        {if isset($item.title) && $item.title && $settingslb['BON_LOOKBOOK_HOME_ELEM_TITLE'].value ||
                        isset($item.description) && $item.description && $item.description && $settingslb['BON_LOOKBOOK_HOME_TEXT'].value}
                            <div class="bonlookbook_item-text">
                                {if isset($item.title) && $item.title && $settingslb['BON_LOOKBOOK_HOME_ELEM_TITLE'].value}
                                    <div class="bonlookbook_item-title">
                                        {$item.title|escape:'htmlall':'UTF-8'}
                                    </div>
                                {/if}
                                {if isset($item.description) && $item.description && $settingslb['BON_LOOKBOOK_HOME_TEXT'].value}
                                    <div class="bonlookbook_item-description">
                                        {$item.description nofilter}
                                    </div>
                                {/if}
                            </div>
                        {/if}
                        <div class="bonlookbook_item-img">
                            <img class="img-responsive"
                                 src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                 alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                            <div class="bonlookbook_points-wrapper">

                                {if isset($points) && $points && $item.subitems}

                                    {foreach from=$points item=point name=point}

                                        {if $item.id == $point.id_tab && $point.status}
                                            <div class="bonlookbook_point"
                                                 style="top: {$point.top|escape:'htmlall':'UTF-8' / $item.image_size[1]|escape:'htmlall':'UTF-8' * 100}%; left: {$point.left|escape:'htmlall':'UTF-8' / $item.image_size[0]|escape:'htmlall':'UTF-8' * 100}%">
                                                <div class="bonlookbook_item-pointer">
                                                    <style>
                                                        #bonlookbook .bonlookbook_item-pointer:after {
                                                            background-color: {$settingslb['BON_LOOKBOOK_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'};
                                                        }
                                                    </style>
                                                    <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g filter="url(#filter0_f_1140_1361)">
                                                            <circle cx="36" cy="36" r="16" fill="url(#paint0_linear_1140_1361)"/>
                                                        </g>
                                                        <defs>
                                                            <filter id="filter0_f_1140_1361" x="0" y="0" width="72" height="72" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                                                <feGaussianBlur stdDeviation="10" result="effect1_foregroundBlur_1140_1361"/>
                                                            </filter>
                                                            <linearGradient id="paint0_linear_1140_1361" x1="20" y1="20" x2="52" y2="52" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="{$settingslb['BON_LOOKBOOK_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                <stop offset="1" stop-color="{$settingslb['BON_LOOKBOOK_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </div>
                                                <div class="bonlookbook_point-product {if $point.top >= $item.image_size[1] / 2}bottom-{if $point.left >= $item.image_size[0] / 2}right{else}left{/if}{else}top-{if $point.left >= $item.image_size[0] / 2}right{else}left{/if}{/if}">
                                                    <div class="bonlookboon_point-product-image">
                                                        <a href="{$point.product.link|escape:'htmlall':'UTF-8'}" target="_blank">
                                                            <img src="{$link->getImageLink($point.product.link_rewrite, $point.product_image.id_image, 'home_default')}"
                                                                 alt="{$point.product.name|truncate:30:'...'|escape:'htmlall':'UTF-8'}" />
                                                        </a>
                                                    </div>
                                                    <div class="bonlookboon_point-product-info">
                                                        <div class="bonlookboon_point-product-title">
                                                            <a href="{$point.product.link|escape:'htmlall':'UTF-8'}"
                                                               target="_blank">{$point.product.name|escape:'htmlall':'UTF-8'}</a>
                                                        </div>
                                                        <div class="bonlookboon_point-product-price">

                                                            {if $point.product.price|string_format:"%.1f" < $point.product.price_without_reduction|string_format:"%.1f"}
                                                                <p class="after-discount">
                                                                    {$currency.sign|escape:'htmlall':'UTF-8'}{$point.product.price|string_format:"%.1f"|escape:'htmlall':'UTF-8'}
                                                                </p>
                                                                <p class="before-discount">
                                                                    {$currency.sign|escape:'htmlall':'UTF-8'}{$point.product.price_without_reduction|string_format:"%.1f"|escape:'htmlall':'UTF-8'}
                                                                </p>
                                                            {else}
                                                                <p class="without-discount">{$currency.sign}{$point.product.price|string_format:"%.1f"|escape:'htmlall':'UTF-8'}
                                                                </p>
                                                            {/if}
                                                        </div>
                                                        <div class="bonlookboon_point-product-link">
                                                            <a href="{$point.product.link|escape:'htmlall':'UTF-8'}"
                                                               target="_blank">{l s='View Product' mod='bonlookbook'}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                    </div>
                {/if}
            {/foreach}
        </div>

        {if $slider_settings['BON_LOOKBOOK_SLIDER_NAV'].value && $slider_settings['BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL'].value}
            <div class="bonlookbook-button_wrapper">
                <div class="bonlookbook-button-prev swiper-button-prev">
                    <svg width="93" height="8" viewBox="0 0 93 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.646446 3.64645C0.451187 3.84171 0.451187 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53554 7.53553C4.7308 7.34027 4.7308 7.02369 4.53554 6.82843L1.70711 4L4.53554 1.17157C4.7308 0.976311 4.7308 0.659728 4.53554 0.464466C4.34027 0.269204 4.02369 0.269204 3.82843 0.464466L0.646446 3.64645ZM93 3.5L1 3.5V4.5L93 4.5V3.5Z" fill="#1A1A1A"/>
                    </svg>
                    {l s='Back' mod='bonlookbook'}
                </div>
                <div class="bonlookbook-button-next swiper-button-next">
                    {l s='Next' mod='bonlookbook'}
                    <svg width="93" height="8" viewBox="0 0 93 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M92.3536 4.35356C92.5488 4.1583 92.5488 3.84172 92.3536 3.64645L89.1716 0.464474C88.9763 0.269212 88.6597 0.269212 88.4645 0.464474C88.2692 0.659736 88.2692 0.976318 88.4645 1.17158L91.2929 4.00001L88.4645 6.82843C88.2692 7.0237 88.2692 7.34028 88.4645 7.53554C88.6597 7.7308 88.9763 7.7308 89.1716 7.53554L92.3536 4.35356ZM-4.37114e-08 4.5L92 4.50001L92 3.50001L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="#1A1A1A"/>
                    </svg>
                </div>
            </div>
        {/if}
    </section>
{/if}