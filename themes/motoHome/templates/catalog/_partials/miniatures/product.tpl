{*
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
{block name='product_miniature_item'}
    <article data-animation="fadeInUp"
             class="swiper-slide {if $page.page_name == 'category'}gridAnimate{/if} revealOnScroll animated fadeInUp product-miniature js-product-miniature  {if $page.page_name == 'index'} col-xs-12 col-sm-6  col-lg-3{elseif $page.page_name == 'category'}col-xs-12 col-sm-6 col-md-6 col-lg-4{else}col-xs-12 col-md-4 col-lg-3{/if}    {if isset($layout)}{if $layout == 'layouts/layout-full-width.tpl'}col-xs-12 col-sm-6 col-md-3{/if}{/if}"
             data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope
             itemtype="http://schema.org/Product">
        <div class="thumbnail-container">
            <div class="thumbnail-container-inner">
                <div class="thumbnail-container-images">
                    {block name='product_thumbnail'}
                        {if $product.cover}
                            <a href="{$product.url}" class="thumbnail product-thumbnail">
                                <img src="{$product.cover.bySize.home_default.url}"
                                     alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
                                     data-full-size-image-url="{$product.cover.large.url}">
                                {hook h="displayRolloverImage" product=$product type="hover"}
{*                                {block name='product_description_short'}*}
{*                                    <div class="sort-description" id="product-description-short-{$product.id}" itemprop="description">*}
{*                                        {$product.description_short|truncate:131:'...' nofilter}</div>*}
{*                                {/block}*}
                                <svg width="340" height="121" viewBox="0 0 340 121" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 16.0984C0 6.14032 8.99897 -1.39871 18.803 0.345833L326.803 55.1517C334.438 56.5104 340 63.149 340 70.9043V105C340 113.837 332.837 121 324 121H16C7.16344 121 0 113.837 0 105V16.0984Z" fill="url(#paint0_linear_1331_121)"/>
                                    <defs>
                                        <linearGradient id="paint0_linear_1331_121" x1="0" y1="-3" x2="79.829" y2="215.886" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FD370C"/>
                                            <stop offset="1" stop-color="#FD540C"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </a>
                        {else}
                            <a href="{$product.url}" class="thumbnail product-thumbnail">
                                <img src="{$urls.no_picture_image.bySize.home_default.url}">
                            </a>
                        {/if}
                    {/block}
                    {hook h='displayProductPriceBlock' product=$product type="before_price"}
                    {block name='product_flags'}
                        <ul class="product-flags">
                            {assign var=val value=0}
                            {foreach from=$product.flags item=flag}
                                {if $val == 0}
                                    {assign var=val value=$val+1}
                                    <li class="product-flag {$flag.type}">
                                        {if $flag.type === 'on-sale'}
                                            {l s='Sale' d='Shop.Theme.Global'}
                                            {if $product.discount_type === 'percentage'}
                                                {*                                            <span class="discount-percentage discount-product">{$product.discount_percentage}</span>*}
                                            {elseif $product.discount_type === 'amount'}
                                                {*                                            <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>*}
                                            {/if}
                                        {else}
                                            {$flag.label}
                                        {/if}
                                    </li>
                                {/if}
                            {/foreach}
                        </ul>
                    {/block}
                    <div class="add-to-cart-block">


                    </div>
                </div>
                <div class="thumbnail-container-bottom">
                    <div class="product-description">
                        {hook h='displayProductPriceBlock' product=$product type='weight'}

                        {block name='product_reviews'}
                            {hook h='displayProductListReviews' product=$product}
                        {/block}
                        {block name='product_name'}
                            {if $page.page_name == 'index'}
                                <h3 class="h3 product-title" itemprop="name">
                                    <a href="{$product.url}">{$product.name}</a>
                                </h3>
                            {else}
                                <h3 class="h3 product-title" itemprop="name">
                                    <a href="{$product.url}">{$product.name}</a>
                                </h3>
                            {/if}
                        {/block}
                        {block name='product_price_and_shipping'}
                            {if $product.show_price}
                                <div class="product-price-and-shipping" itemprop="offers" itemscope
                                     itemtype="https://schema.org/Offer">
                                    <meta itemprop="price" content="95" />
                                    <meta itemprop="priceCurrency" content="{$currency.iso_code}" />
                                    <link itemprop="availability" href="https://schema.org/InStock" />
                                    <meta itemprop="priceValidUntil" content="2020-11-05" />
                                    <a style="display: none" itemprop="url"
                                       href="{$product.url}">{$product.url}">{$product.name|truncate:30:'...'}</a>
                                    {if $product.has_discount}
                                        {hook h='displayProductPriceBlock' product=$product type="old_price"}
                                        <span class="sr-only">{l s='Regular price' d='Shop.Theme.Catalog'}</span>
                                        <span class="regular-price">{$product.regular_price}</span>
                                        {*{if $product.discount_type === 'percentage'}
                                                <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                                            {elseif $product.discount_type === 'amount'}
                                                <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                                            {/if}*}
                                    {/if}
                                    <span class="sr-only">{l s='Price' d='Shop.Theme.Catalog'}</span>
                                    {hook h='displayProductPriceBlock' product=$product type='unit_price'}
                                    <span class="price {if $product.has_discount}price-has-discount{/if}">{$product.price}</span>
                                </div>
                            {/if}
                        {/block}
                        {hook h='displayBonAttribute' product=$product}
                        <form action="{$urls.pages.cart}" method="post" class="add-to-cart-or-refresh">
                            <input type="hidden" name="token" value="{$static_token}">
                            <input type="hidden" name="id_product" value="{$product.id}"
                                   class="product_page_product_id">
                            <input type="hidden" name="qty" value="1">
                            <div class="btn-row">
                                <div class="bon-tooltip boncompare-hook-wrapper compare-button" data-id-compare="{$product.id}">
                                    {hook h="displayBonCompare"}
                                </div>
                                <button class="btn-primary white ajax_add_to_cart_button add-to-cart" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url} disabled {/if}>{l s='Add to cart' d='Shop.Theme.Actions'}</button>
                                <div class="bon-tooltip bonwishlist-hook-wrapper" data-id-product="{$product.id}">
                                    {hook h="displayBonWishlist"}
                                </div>
                            </div>
                        </form>
                    </div>

                    <div style="display: none" itemprop="aggregateRating" itemscope
                         itemtype="http://schema.org/AggregateRating">
                        <span itemprop="ratingValue">4.9</span>
                        <span itemprop="reviewCount">42</span>
                    </div>
                    <div style="display: none" class="comment clearfix" itemprop="review" itemscope
                         itemtype="https://schema.org/Review">
                        <div class="comment_author">
                            <div class="star_content clearfix" itemprop="reviewRating" itemscope
                                 itemtype="https://schema.org/Rating">
                                <meta itemprop="worstRating" content="0" />
                                <meta itemprop="ratingValue" content="3" />
                                <meta itemprop="bestRating" content="5" />
                            </div>
                            <div class="comment_author_infos">
                                <strong itemprop="author">asd</strong>
                                <meta itemprop="datePublished" content="fdg" />
                            </div>
                        </div>
                        <div class="comment_details">
                            <h4 class="title_block" itemprop="name">rty</h4>
                            <p itemprop="reviewBody">ewr</p>
                        </div>
                    </div>
                    <meta itemprop="description"
                          content="{$product.description_short|strip_tags:'UTF-8'|truncate:130:'...'}" />
                    <meta itemprop="sku" content="{l s='1234' d='Shop.Theme.Catalog'}" />
                    <meta itemprop="mpn" content="{l s='1234' d='Shop.Theme.Catalog'}" />
                </div>
            </div>

        </div>
    </article>
{/block}