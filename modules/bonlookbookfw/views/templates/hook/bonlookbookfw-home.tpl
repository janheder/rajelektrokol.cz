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
    #bonlookbookfw .bonlookbookfw_header-title a:hover {
        color: {$settingsfw['BON_LOOKBOOKFW_TITLE_HOVER_COLOR'].value|escape:'htmlall':'UTF-8'}!important;
    }
</style>
{if isset($items) && $items}
    <section id="bonlookbookfw" class="bonlookbookfw{if $sliderfw_settings['BON_LOOKBOOKFW_SLIDER_DISPLAY_CAROUSEL'].value} swiper{/if}{if !($settingsfw['BON_LOOKBOOKFW_HOME_TEXT'].value)} bonlookboofwk-without-text{/if}">

        {if $settingsfw['BON_LOOKBOOKFW_TITLE'].value || $settingfw['BON_LOOKBOOKFW_SUBTITLE'].value}
            <div class="bonlookbookfw_header {$settingsfw['BON_LOOKBOOKFW_TEXT_POSITION'].value|escape:'htmlall':'UTF-8'}">

                {if $settingsfw['BON_LOOKBOOKFW_TITLE'].value && $settingsfw['BON_LOOKBOOKFW_TITLE_TEXT'].value}
                    <div class="bonlookbookfw_header-title">
                        {assign var="text" value=$settingsfw['BON_LOOKBOOKFW_TITLE_TEXT'].value}
                        {assign var="split" value=" "|explode:$text}
                        <a href="{$link->getModuleLink('bonlookbookfw', 'main')|escape:'htmlall':'UTF-8'}" class="h1" style="color: {$settingsfw['BON_LOOKBOOKFW_TITLE_COLOR'].value|escape:'htmlall':'UTF-8'}">
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

                {if $settingsfw['BON_LOOKBOOKFW_SUBTITLE'].value}
                    <div class="bonlookbookfw_header-subtitle">
                        <p class="h2" style="color: {$settingsfw['BON_LOOKBOOKFW_SUBTITLE_COLOR'].value|escape:'htmlall':'UTF-8'}">
                            {l s='Stay ahead of the fashion trends with our new selection' mod='bonlookbookfw'}</p>
                    </div>
                {/if}
            </div>
        {/if}
        <div class="bonlookbookfw_wrapper{if $sliderfw_settings['BON_LOOKBOOKFW_SLIDER_DISPLAY_CAROUSEL'].value} swiper-wrapper{/if}">

            {foreach from=$items item=item name=item}

                {if $smarty.foreach.item.iteration <= $settingsfw['BON_LOOKBOOKFW_HOME_LIMIT'].value}
                    <div class="bonlookbookfw_item{if $sliderfw_settings['BON_LOOKBOOKFW_SLIDER_DISPLAY_CAROUSEL'].value} swiper-slide{/if}">

                        {if isset($item.title) && $item.title && $settingsfw['BON_LOOKBOOKFW_HOME_ELEM_TITLE'].value ||
                        isset($item.description) && $item.description && $settingsfw['BON_LOOKBOOKFW_HOME_TEXT'].value}
                            <div class="bonlookbookfw_item-text">
                                {if isset($item.title) && $item.title && $settingsfw['BON_LOOKBOOKFW_HOME_ELEM_TITLE'].value}
                                    <div class="bonlookbookfw_item-title">
                                        {$item.title|escape:'htmlall':'UTF-8'}
                                    </div>
                                {/if}
                                {if isset($item.description) && $item.description && $settingsfw['BON_LOOKBOOKFW_HOME_TEXT'].value}
                                    <div class="bonlookbookfw_item-description">
                                        {$item.description nofilter}
                                    </div>
                                {/if}
                            </div>
                        {/if}
                        <div class="bonlookbookfw_item-img">
                            <img class="img-responsive"
                                 src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                 alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                            <div class="bonlookbookfw_points-wrapper">

                                {if isset($points) && $points && $item.subitems}

                                    {foreach from=$points item=point name=point}

                                        {if $item.id == $point.id_tab && $point.status}
                                            <div class="bonlookbookfw_point"
                                                 style="top: {$point.top|escape:'htmlall':'UTF-8' / $item.image_size[1]|escape:'htmlall':'UTF-8' * 100}%; left: {$point.left|escape:'htmlall':'UTF-8' / $item.image_size[0]|escape:'htmlall':'UTF-8' * 100}%">
                                                <div class="bonlookbookfw_item-pointer">
                                                    <style>
                                                        #bonlookbookfw .bonlookbookfw_item-pointer:after {
                                                            background-color: {$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'};
                                                        }
                                                    </style>
                                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g filter="url(#filter0_f_1150_1046)">
                                                            <circle cx="22" cy="22" r="10" fill="url(#paint0_linear_1150_1046)"/>
                                                        </g>
                                                        <defs>
                                                            <filter id="filter0_f_1150_1046" x="0" y="0" width="44" height="44" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                                                <feGaussianBlur stdDeviation="6" result="effect1_foregroundBlur_1150_1046"/>
                                                            </filter>
                                                            <linearGradient id="paint0_linear_1150_1046" x1="12" y1="12" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                <stop offset="1" stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                    <div class="bonlookbookfw_item-pointer-content {if $point.top >= $item.image_size[1] / 2}bottom-{if $point.left >= $item.image_size[0] / 2}right{else}left{/if}{else}top-{if $point.left >= $item.image_size[0] / 2}right{else}left{/if}{/if}">
                                                        {if $point.top >= $item.image_size[1] / 2}
                                                            {if $point.left >= $item.image_size[0] / 2}
                                                                <svg class="bonlookbookfw_item-pointer-line bottom-right" width="395" height="170" viewBox="0 0 395 170" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M393.5 168.5L226 1H0" stroke="url(#paint0_linear_1150_1050)" stroke-width="2" stroke-linejoin="round" stroke-dasharray="1 6"/>
                                                                    <defs>
                                                                        <linearGradient id="paint0_linear_1150_1050" x1="0" y1="1" x2="120.724" y2="284.612" gradientUnits="userSpaceOnUse">
                                                                            <stop stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                            <stop offset="1" stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                        </linearGradient>
                                                                    </defs>
                                                                </svg>
                                                            {else}
                                                                <svg class="bonlookbookfw_item-pointer-line bottom-left" width="375" height="161" viewBox="0 0 375 161" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M1 160L160.199 1H375" stroke="url(#paint0_linear_1150_1050)" stroke-width="2" stroke-linejoin="round" stroke-dasharray="1 6"/>
                                                                    <defs>
                                                                        <linearGradient id="paint0_linear_1150_1050" x1="375" y1="1" x2="260.502" y2="270.323" gradientUnits="userSpaceOnUse">
                                                                            <stop stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                            <stop offset="1" stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                        </linearGradient>
                                                                    </defs>
                                                                </svg>

                                                            {/if}
                                                        {else}
                                                            {if $point.left >= $item.image_size[0] / 2}
                                                                <svg class="bonlookbookfw_item-pointer-line top-right" width="375" height="161" viewBox="0 0 375 161" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M1 160L160.199 1H375" stroke="url(#paint0_linear_1150_1050)" stroke-width="2" stroke-linejoin="round" stroke-dasharray="1 6"/>
                                                                    <defs>
                                                                        <linearGradient id="paint0_linear_1150_1050" x1="375" y1="1" x2="260.502" y2="270.323" gradientUnits="userSpaceOnUse">
                                                                            <stop stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                            <stop offset="1" stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                        </linearGradient>
                                                                    </defs>
                                                                </svg>
                                                            {else}
                                                                <svg class="bonlookbookfw_item-pointer-line top-left" width="293" height="239" viewBox="0 0 293 239" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <g filter="url(#filter0_d_1150_1063)">
                                                                        <path d="M4.99999 1.00001L234 230L289 230" stroke="url(#paint0_linear_1150_1063)" stroke-width="2" stroke-linejoin="round" stroke-dasharray="1 6"/>
                                                                    </g>
                                                                    <defs>
                                                                        <filter id="filter0_d_1150_1063" x="0.292881" y="0.292969" width="292.707" height="238.707" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                                            <feOffset dy="4"/>
                                                                            <feGaussianBlur stdDeviation="2"/>
                                                                            <feComposite in2="hardAlpha" operator="out"/>
                                                                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1150_1063"/>
                                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1150_1063" result="shape"/>
                                                                        </filter>
                                                                        <linearGradient id="paint0_linear_1150_1063" x1="289" y1="230" x2="65.2047" y2="-47.5453" gradientUnits="userSpaceOnUse">
                                                                            <stop stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                            <stop offset="1" stop-color="{$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}"/>
                                                                        </linearGradient>
                                                                    </defs>
                                                                </svg>
                                                            {/if}
                                                        {/if}
                                                        <div class="bonlookbookfw_point-product-wrapper">
                                                            <div class="bonlookbookfw_point-product">
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
                                                                    <div class="bonlookboon_point-product-link">
                                                                        <a href="{$point.product.link|escape:'htmlall':'UTF-8'}"
                                                                           target="_blank">{l s='View Product' mod='bonlookbookfw'}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="bonlookbookfw_point-title" style="color: {$settingsfw['BON_LOOKBOOKFW_POINTER_COLOR'].value|escape:'htmlall':'UTF-8'}">{$point.title|escape:'htmlall':'UTF-8'}</div>
                                                            <div class="bonlookbookfw_point-description"> {$point.description nofilter}</div>

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

        {if $sliderfw_settings['BON_LOOKBOOKFW_SLIDER_NAV'].value && $sliderfw_settings['BON_LOOKBOOKFW_SLIDER_DISPLAY_CAROUSEL'].value}
            <div class="bonlookbookfw-button_wrapper">
                <div class="bonlookbookfw-button-prev swiper-button-prev">
                    <svg width="93" height="8" viewBox="0 0 93 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.646446 3.64645C0.451187 3.84171 0.451187 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53554 7.53553C4.7308 7.34027 4.7308 7.02369 4.53554 6.82843L1.70711 4L4.53554 1.17157C4.7308 0.976311 4.7308 0.659728 4.53554 0.464466C4.34027 0.269204 4.02369 0.269204 3.82843 0.464466L0.646446 3.64645ZM93 3.5L1 3.5V4.5L93 4.5V3.5Z" fill="#1A1A1A"/>
                    </svg>
                    {l s='Back' mod='bonlookbookfw'}
                </div>
                <div class="bonlookbookfw-button-next swiper-button-next">
                    {l s='Next' mod='bonlookbookfw'}
                    <svg width="93" height="8" viewBox="0 0 93 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M92.3536 4.35356C92.5488 4.1583 92.5488 3.84172 92.3536 3.64645L89.1716 0.464474C88.9763 0.269212 88.6597 0.269212 88.4645 0.464474C88.2692 0.659736 88.2692 0.976318 88.4645 1.17158L91.2929 4.00001L88.4645 6.82843C88.2692 7.0237 88.2692 7.34028 88.4645 7.53554C88.6597 7.7308 88.9763 7.7308 89.1716 7.53554L92.3536 4.35356ZM-4.37114e-08 4.5L92 4.50001L92 3.50001L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="#1A1A1A"/>
                    </svg>
                </div>
            </div>
        {/if}
    </section>
{/if}