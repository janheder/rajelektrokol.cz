{*
* 2015-2020 Bonpresta
*
* Bonpresta Cart
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
{if $cart.products}
    <ul id="bon-cart-summary-product-list">
        <div class="bon-cart-summary-product-wrapper">
            {foreach from=$cart.products item=product}
                <li class="cart-summary-product-item">
                    <div class="bon-cart-summary-product-image">
                        <a class="thumbnail product-thumbnail" href="{$product.url|escape:'htmlall':'UTF-8'}">
                            <img class="product-image" src="{$product.cover.medium.url|escape:'htmlall':'UTF-8'}" alt="{$product.cover.legend|escape:'htmlall':'UTF-8'}" title="{$product.cover.legend|escape:'htmlall':'UTF-8'}" itemprop="image">
                        </a>
                    </div>
                    <div class="bon-cart-summary-product-info">
                   
                          <span> {include 'module:ps_shoppingcart/ps_shoppingcart-product-line.tpl' product=$product}</span>  
                        {block name='product_discount'}
                                {if $product.has_discount}
                                    {hook h='displayProductPriceBlock' product=$product type="old_price"}
                                    <span class="regular-price">{$product.regular_price|escape:'htmlall':'UTF-8'}</span>
                                {/if}
                         {/block}
            </div>
            <a class="remove-from-cart" rel="nofollow" href="{$product.remove_from_cart_url|escape:'htmlall':'UTF-8'}"
               data-link-action="delete-from-cart" data-id-product="{$product.id_product|escape:'javascript'}"
               data-id-product-attribute="{$product.id_product_attribute|escape:'javascript'}"
               data-id-customization="{$product.id_customization|escape:'javascript'}">
            </a>
        </li>
        {/foreach}
    </div>
    {block name='cart_summary'}
    <div class="card cart-summary">

        {block name='cart_totals'}
            {include file='checkout/_partials/cart-detailed-totals.tpl' cart=$cart}
        {/block}

        {if $cart.products}
        <div class="bon-card-actions">
            <a class="btn btn-primary" href="{$cart_url|escape:'htmlall':'UTF-8'}" title="{l s='View cart' mod='boncart'}">{l s='View cart' mod='boncart'}</a>
            <a href="{$urls.pages.order|escape:'htmlall':'UTF-8'}" class="btn btn-primary" title="{l s='Proceed to checkout' mod='boncart'}">{l s='Proceed to checkout' mod='boncart'}</a>
        </div>
        {/if}
    </div>
    {/block}
</ul>
{else}
<div class="no-items alert alert-info">{l s='There are no more items in your cart' mod='boncart'}</div>
{/if}