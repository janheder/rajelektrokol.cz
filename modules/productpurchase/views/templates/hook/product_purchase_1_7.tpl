{*
* 2015-2020 Bonpresta
*
* Bonpresta Product Video Youtube
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
{if isset($purchase_products) && $purchase_products}
<div class="product-purchase-container active-list">
    <ul class="product-purchase-list">
        {foreach from=$purchase_products item=product name=product}
        <li class="product-purchase-item {if $smarty.foreach.media.iteration == 1} active-item {/if}">
            <a class="product-item-inner" href="{$product.info.url|escape:'htmlall':'UTF-8'}">
                <div class="product-purchase-image-wrapper">
                    <img class="replace-2x img-responsive" src="{$product.info.cover.bySize.home_default.url|escape:'htmlall':'UTF-8'}" alt="{$product.info.cover.legend|escape:'htmlall':'UTF-8'}" data-full-size-image-url="{$product.info.cover.large.url|escape:'htmlall':'UTF-8'}" />
                </div>
                <div class="product-purchase-item-description">
                    <p class="name">{$product.info.name|escape:'htmlall':'UTF-8'|truncate:25:'...':true}</p>
                    <p class="buyer">{$product.title|escape:'htmlall':'UTF-8'}</p>
                    <div class="current-price">
                        <span itemprop="price" class="price {if $product.info.has_discount}has_discount{/if}">{$product.info.price|escape:'htmlall':'UTF-8'}</span>
                        {if $product.info.has_discount}
                        {hook h='displayProductPriceBlock' product=$product.info type="old_price"}
                        <span class="regular-price">{$product.info.regular_price|escape:'htmlall':'UTF-8'}</span>
                        {/if}
                    </div>
                    <p class="buy-time">{$product.time|escape:'htmlall':'UTF-8'}</p>
                </div>
            </a>
            <button class="close-popup"></button>
        </li>
        {/foreach}
    </ul>
</div>
{/if}
