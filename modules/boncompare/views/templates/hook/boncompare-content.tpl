{*
* 2015-2021 Bonpresta
*
* Bonpresta Product Compare
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
* @copyright 2015-2021 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

<div class="modal fade" id="compare-wrapper" tabindex="-1" role="dialog" aria-labelledby="#compare-wrapper"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <h2 class="title">{l s='Product Comparison' mod='boncompare'}</h2>
            <button type="button" class="popup-close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                {if isset($products) && $products}
                    <div class="boncompare-list">
                        <div class="div-table">
                            <div class="div-table-row">
                                <div class="div-table-col boncompare-features">
                                </div>
                                {foreach from=$products item=product name=product}
                                    <div class="div-table-col main-info"
                                        data-id-compare="{$product.info.id_product|escape:'htmlall':'UTF-8'}">
                                        <a class="thumbnail product-thumbnail"
                                            href="{$product.info.url|escape:'htmlall':'UTF-8'}">
                                            <img class="replace-2x img-responsive"
                                                src="{$product.info.cover.bySize.home_default.url|escape:'htmlall':'UTF-8'}"
                                                alt="{$product.info.cover.legend|escape:'htmlall':'UTF-8'}"
                                                data-full-size-image-url="{$product.info.cover.large.url|escape:'htmlall':'UTF-8'}">
                                            <h6 class="h3 product-title" itemprop="name">
                                                {$product.info.name|escape:'htmlall':'UTF-8'}
                                            </h6>
                                            {hook h="displayProductListReviews" product=$product.info}
                                            <div class="product-info">
                                                {block name='product_price_and_shipping'}
                                                    {if $product.info.show_price}
                                                        <div class="compare-summary-product-price">
                                                            <span
                                                                class="price {if $product.info.has_discount}has-discount{/if}">{$product.info.price|escape:'htmlall':'UTF-8'}</span>
                                                            {if $product.info.has_discount}
                                                                <span
                                                                    class="regular-price">{$product.info.regular_price|escape:'htmlall':'UTF-8'}</span>
                                                            {/if}
                                                        </div>
                                                    {/if}
                                                {/block}
                                                <div class="compare_add_to_cart">
                                                    {* <div class="bonwishlist-hook-wrapper"
                                                        data-id-product="{$product.info.id_product|escape:'htmlall':'UTF-8'}">
                                                        {hook h="displayBonWishlist"}
                                                    </div> *}
                                                    <form action="{$link->getPageLink('cart')|escape:'htmlall':'UTF-8'}"
                                                        method="post" class="add-to-cart-or-refresh">
                                                        <input type="hidden" name="token"
                                                            value="{$static_token|escape:'htmlall':'UTF-8'}">
                                                        <input type="hidden" name="id_product"
                                                            value="{$product.info.id_product|escape:'htmlall':'UTF-8'}"
                                                            class="product_page_product_id">
                                                        <input type="hidden" name="qty" value="1">
                                                        <button class="compare_add_to_cart_button"
                                                            data-button-action="add-to-cart" type="submit"
                                                            onclick="closeBoncompare()">
                                                            <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M13.5463 16.875C14.1538 16.875 14.7388 16.6163 15.1438 16.1606C15.5488 15.705 15.7401 15.0975 15.6669 14.4956L14.3451 3.015C14.2213 1.94063 13.3101 1.125 12.2244 1.125H3.77568C2.69005 1.125 1.7788 1.94063 1.65505 3.015L0.333177 14.4956C0.260052 15.0975 0.451302 15.705 0.856302 16.1606C1.2613 16.6163 1.8463 16.875 2.4538 16.875H13.5463ZM1.44693 14.625L2.77443 3.14438C2.83068 2.6325 3.2638 2.25 3.77568 2.25H12.2244C12.7363 2.25 13.1694 2.6325 13.2257 3.14438L14.5532 14.625C14.5869 14.9119 14.4969 15.1931 14.3001 15.4125C14.1088 15.6319 13.8388 15.75 13.5463 15.75H2.4538C2.1613 15.75 1.8913 15.6319 1.70005 15.4125C1.50318 15.1931 1.41318 14.9119 1.44693 14.625Z" fill="#3A3A3A" stroke="#3A3A3A" stroke-width="0.3"/>
                                                                <path d="M8 7.875C9.86109 7.875 11.375 6.36109 11.375 4.5V3.9375C11.375 3.62689 11.1231 3.375 10.8125 3.375C10.5019 3.375 10.25 3.62689 10.25 3.9375V4.5C10.25 5.74065 9.24065 6.75 8 6.75C6.75935 6.75 5.75 5.74065 5.75 4.5V3.9375C5.75 3.62689 5.49811 3.375 5.1875 3.375C4.87689 3.375 4.625 3.62689 4.625 3.9375V4.5C4.625 6.36109 6.13891 7.875 8 7.875Z" fill="#3A3A3A" stroke="#3A3A3A" stroke-width="0.1"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <span class="compare-button-delete"></span>
                                            {block name='product_flags'}
                                                <ul class="product-flags">
                                                    {foreach from=$product.info.flags item=flag}
                                                        <li class="product-flag {$flag.type}">{$flag.label|escape:'htmlall':'UTF-8'}
                                                            {if $flag.type === 'on-sale'}
                                                                {if $product.info.discount_type === 'percentage'}
                                                                    <span
                                                                        class="discount-percentage discount-product">{$product.info.discount_percentage|escape:'htmlall':'UTF-8'}</span>
                                                                {elseif $product.info.discount_type === 'amount'}
                                                                    <span
                                                                        class="discount-amount discount-product">{$product.info.discount_amount_to_display|escape:'htmlall':'UTF-8'}</span>
                                                                {/if}
                                                            {/if}
                                                        </li>
                                                    {/foreach}
                                                </ul>
                                            {/block}
                                        </a>
                                    </div>
                                {/foreach}
                            </div>
                            <div class="div-table-row">
                                <div class="div-table-col boncompare-features">
                                    <h5>{l s='Category' mod='boncompare'}</h5>
                                </div>
                                {foreach from=$products item=product name=product}
                                    <div class="div-table-col"
                                        data-id-compare="{$product.info.id_product|escape:'htmlall':'UTF-8'}">
                                        <p>{if !$product.category}-{else}{$product.category|escape:'htmlall':'UTF-8'}{/if}
                                        </p>
                                    </div>
                                {/foreach}
                            </div>
                            <div class="div-table-row">
                                <div class="div-table-col boncompare-features">
                                    <h5>{l s='Manufacture' mod='boncompare'}</h5>
                                </div>
                                {foreach from=$products item=product name=product}
                                    <div class="div-table-col"
                                        data-id-compare="{$product.info.id_product|escape:'htmlall':'UTF-8'}">
                                        <p>{if
                                                !$product.manufacturer_name}-{else}{$product.manufacturer_name|escape:'htmlall':'UTF-8'}
                                        {/if}
                                    </p>
                                </div>
                            {/foreach}
                        </div>
                        <div class="div-table-row">
                            <div class="div-table-col boncompare-features">
                                <h5>{l s='Attributes' mod='boncompare'}</h5>
                            </div>
                            {foreach from=$products item=product name=product}
                                <div class="div-table-col compare-attr"
                                    data-id-compare="{$product.info.id_product|escape:'htmlall':'UTF-8'}">
                                    {if !$product.attributes}
                                        <p>-</p>
                                    {else}
                                        {foreach from=$product.attributes item=attribute name=attribute}
                                            <span>{$attribute|escape:'htmlall':'UTF-8'}</span><span>,</span>
                                        {/foreach}
                                    {/if}
                                </div>
                            {/foreach}
                        </div>
                        <div class="div-table-row --special">
                            <div class="div-table-col boncompare-features ">
                            {if !$product.info.features}
                                <p>-</p>
                            {else}
                                {foreach from=$product.info.features item=feature name=feature}
                                    <p><span>{$feature.name|escape:'htmlall':'UTF-8'}</span> 
                                {/foreach}
                            {/if}
                            </div>
                            {foreach from=$products item=product name=product}
                                <div class="div-table-col"
                                    data-id-compare="{$product.info.id_product|escape:'htmlall':'UTF-8'}">
                                    {if !$product.info.features}
                                        <p>-</p>
                                    {else}
                                        {foreach from=$product.info.features item=feature name=feature}
                                            <p>
                                                <span>{$feature.value|escape:'htmlall':'UTF-8'}</span>
                                            </p>
                                        {/foreach}
                                    {/if}
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
                {else}
                <div class="no-compare">
                    <img src="{_MODULE_DIR_}boncompare/views/img/compare.png" alt="compare">
                    <h6>{l s='There are no more items in your compare' mod='boncompare'}
                    </h6>
                </div>
                {/if}
                <div class="no-compare-js no-compare" style="display: none;">
                    <img src="{_MODULE_DIR_}boncompare/views/img/compare.png" alt="compare">
                    <h6>{l s='There are no more items in your compare' mod='boncompare'}
                </div>
            </div>
        </div>
    </div>
</div>