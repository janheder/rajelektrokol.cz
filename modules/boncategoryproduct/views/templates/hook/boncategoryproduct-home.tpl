{*
 * 2015-2021 Bonpresta
 *
 * Bonpresta Category Products with Tabs and Carousel on Home Page
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
*}

{if isset($categories) && $categories}
    <div class="container">
        <section class="boncategoruproduct spaced-section revealOnScroll animated fadeInUp" data-animation="fadeInUp">
            <div class="products">
                <div class="block-container">
                    <div class="wrapper block-content">
                        {foreach from=$categories item=category}
                            <div class="boncategoruproduct-item">
                                <p class="h2">{$category.title|escape:'htmlall':'UTF-8'}</p>
                                <div class="wrapper-items">
{*                                    <div class="block-name">*}
{*                                        <span class="block-category-name">{$category.category->name|escape:'htmlall':'UTF-8'}</span>*}
{*                                    </div>*}
                                    <div class="block-item{if !$display_caroucel} caroucel_disable{else} caroucel_enable{/if}">
                                        {if $display_caroucel}
                                            <div class="boncategoryproduct-swiper swiper">
{*                                                <div class="swiper-buttons">*}
{*                                                    <div class="boncategoryproduct-button swiper-button-prev"*}
{*                                                         data-nav="prev{$category.id_item|escape:'htmlall':'UTF-8'}"></div>*}
{*                                                    <div class="boncategoryproduct-button swiper-button-next"*}
{*                                                         data-nav="next{$category.id_item|escape:'htmlall':'UTF-8'}"></div>*}
{*                                                </div>*}
                                                <div class="swiper-wrapper">
                                                    {assign var=anyItem value=0}
                                                    {assign var=val value=1}
                                                    {foreach from=$category.result item=product name=product}
                                                            {$anyItem = 1}
                                                            {assign var="product" value=$product.info }
                                                            {if $val == 1}
                                                                <div class="swiper-slide item-padding">
                                                            {/if}
                                                                <div class="product-wrapper">
                                                                    {if $product.cover}
                                                                        <div class="product-image">
                                                                            <a href="{$product.url}" class="thumbnail">
                                                                                <img src="{$product.cover.bySize.cart_default.url}"
                                                                                     alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
                                                                                     data-full-size-image-url="{$product.cover.large.url}">
                                                                            </a>
                                                                        </div>
                                                                    {else}
                                                                        <div class="product-image">
                                                                            <a href="{$product.url}" class="thumbnail product-thumbnail">
                                                                                <img src="{$urls.no_picture_image.bySize.cart_default.url}">
                                                                            </a>
                                                                        </div>
                                                                    {/if}
                                                                    <div class="product-info">
                                                                        <h3 class="h3 product-title" itemprop="name"><a
                                                                                    href="{$product.url}">{$product.name|truncate:30:'...'}</a>
                                                                        </h3>
                                                                        {if $product.show_price}
                                                                            <div class="product-price-and-shipping">
                                                                <span
                                                                        class="price {if $product.has_discount}price-has-discount{/if}">{$product.price}</span>
                                                                                {if $product.has_discount}
                                                                                    {hook h='displayProductPriceBlock' product=$product type="old_price"}
                                                                                    <span
                                                                                            class="sr-only">
                                                                        {l s='Regular price' mod='boncategoryproduct'}</span>
                                                                                    <span class="regular-price">{$product.regular_price}</span>
                                                                                {/if}
                                                                                <span
                                                                                        class="sr-only">
                                                                    {l s='Price' mod='boncategoryproduct'}</span>
                                                                                {hook h='displayProductPriceBlock' product=$product type='unit_price'}
                                                                            </div>
                                                                        {/if}
                                                                        <a class="view-product" href="{$product.url}">{l s='View Product' mod='boncategoryproduct'}</a>
                                                                    </div>
                                                                </div>
                                                            {if $smarty.foreach.product.last || $val == 4}
                                                                </div>
                                                            {/if}
                                                            {if $val != 4}
                                                                {assign var=val value=$val+1}
                                                            {else}
                                                                {assign var=val value=1}
                                                            {/if}
                                                      
                                                    {/foreach}
                                                </div>
                                            </div>
                                        {else}
                                            {foreach from=$category.result item=product}

                                                {assign var="product" value=$product.info }
                                                <div class="product-wrapper item-padding">
                                                    {if $product.cover}
                                                        <div class="product-image">
                                                            <a href="{$product.url}" class="thumbnail">
                                                                <img src="{$product.cover.bySize.cart_default.url}"
                                                                     alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
                                                                     data-full-size-image-url="{$product.cover.large.url}">
                                                            </a>
                                                        </div>
                                                    {else}
                                                        <div class="product-image">
                                                            <a href="{$product.url}" class="thumbnail product-thumbnail">
                                                                <img src="{$urls.no_picture_image.bySize.cart_default.url}">
                                                            </a>
                                                        </div>
                                                    {/if}
                                                    <div class="product-info">
                                                        <h3 class="h3 product-title" itemprop="name"><a
                                                                    href="{$product.url}">{$product.name|truncate:30:'...'}</a>
                                                        </h3>
                                                        {if $product.show_price}
                                                            <div class="product-price-and-shipping">
                                                                <span
                                                                    class="price {if $product.has_discount}price-has-discount{/if}">{$product.price}</span>
                                                                {if $product.has_discount}
                                                                    {hook h='displayProductPriceBlock' product=$product type="old_price"}
                                                                    <span
                                                                        class="sr-only">
                                                                        {l s='Regular price' mod='boncategoryproduct'}</span>
                                                                    <span class="regular-price">{$product.regular_price}</span>
                                                                {/if}
                                                                <span
                                                                    class="sr-only">
                                                                    {l s='Price' mod='boncategoryproduct'}</span>
                                                                {hook h='displayProductPriceBlock' product=$product type='unit_price'}
                                                            </div>
                                                        {/if}
                                                        <a href="{$product.url}">{l s='View Product' mod='boncategoryproduct'}</a>
                                                    </div>
                                                </div>
                                            {/foreach}
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </section>
    </div>
{/if}