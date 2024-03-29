{**
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
* @author PrestaShop SA <contact@prestashop.com>
    * @copyright 2007-2020 PrestaShop SA
    * @license https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
    * International Registered Trademark & Property of PrestaShop SA
    *}
<div class="images-container">
    {block name='product_cover'}
        <div class="product-cover">
            {block name='product_flags'}
                <ul class="product-flags">
                    {foreach from=$product.flags item=flag}
                        <li class="product-flag {$flag.type}">{$flag.label}
                            {if $flag.type === 'on-sale'}
                                {if $product.discount_type === 'percentage'}
                                    <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                                {elseif $product.discount_type === 'amount'}
                                    <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                                {/if}
                            {/if}
                        </li>
                    {/foreach}
                </ul>
            {/block}
            {if $product.cover}
                <img class="js-qv-product-cover"
                    src="{if _PS_VERSION_ >= '1.7.7.'}{$product.default_image.bySize.large_default.url}{else}{$product.cover.bySize.large_default.url}{/if}"
                    alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image">
                <div class="layer hidden-sm-down"></div>
            {else}
                <img src="{$urls.no_picture_image.bySize.large_default.url}" style="width:100%;">
            {/if}
            <div class="bonwishlist-hook-wrapper" data-id-product="{$product.id}">
                {hook h="displayBonWishlist"}
            </div>
            <div class="boncompare-hook-wrapper" data-id-compare="{$product.id}">
                {hook h="displayBonCompare"}
            </div>
        </div>
    {/block}
    {block name='product_images'}
        <div class="js-qv-mask mask">
            <ul class="product-images js-qv-product-images">
                {foreach from=$product.images item=image}
                    <li class="thumb-container" data-image-large-src="{$image.bySize.large_default.url}">
                        <img class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
                            data-image-medium-src="{$image.bySize.large_default.url}"
                            data-image-large-src="{$image.bySize.large_default.url}" src="{$image.bySize.large_default.url}"
                            alt="{$image.legend}" title="{$image.legend}" itemprop="image">
                    </li>
                {/foreach}
            </ul>
        </div>
    {/block}
</div>
{hook h='displayAfterProductThumbs'}