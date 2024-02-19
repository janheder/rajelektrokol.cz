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
{extends file=$layout}
{block name='head_seo' prepend}
    <link rel="canonical" href="{$product.canonical_url}">
{/block}
{block name='head' append}
    <meta property="og:type" content="product">
    <meta property="og:url" content="{$urls.current_url}">
    <meta property="og:title" content="{$page.meta.title}">
    <meta property="og:site_name" content="{$shop.name}">
    <meta property="og:description" content="{$page.meta.description}">
    <meta property="og:image" content="{$product.cover.large.url}">
    <meta property="product:pretax_price:amount" content="{$product.price_tax_exc}">
    <meta property="product:pretax_price:currency" content="{$currency.iso_code}">
    <meta property="product:price:amount" content="{$product.price_amount}">
    <meta property="product:price:currency" content="{$currency.iso_code}">
    {if isset($product.weight) && ($product.weight != 0)}
        <meta property="product:weight:value" content="{$product.weight}">
        <meta property="product:weight:units" content="{$product.weight_unit}">
    {/if}
{/block}
{block name='content'}
    <div class="revealOnScroll animated fadeInUp" data-animation="fadeInUp" id="main" itemscope itemtype="https://schema.org/Product">
        <meta itemprop="url" content="{$product.url}">
        <meta itemprop="sku" content="{$product.id_product}"/>
        <meta itemprop="mpn" content="{$product.reference}"/>
        <div class="row">
            <div class="col-md-6">
                {block name='page_content_container'}
                    <section class="page-content" id="content">
                        {block name='page_content'}
                            {block name='product_cover_thumbnails'}
                                {include file='catalog/_partials/product-cover-thumbnails.tpl'}
                            {/block}
                        {/block}
                    </section>
                {/block}
            </div>
            <div class="col-md-6 product-page-right">
                {block name='page_header_container'}
                    {block name='page_header'}
                        <h1 class="h1" itemprop="name">{block name='page_title'}{$product.name}{/block}</h1>
                    {/block}
                {/block}
                {if $product.reference}
                    <div class="product-reference">
                        <label class="label">{l s='Reference:' d='Shop.Theme.Catalog'} </label>
                        <span>{$product.reference}</span>
                    </div>
                {/if}
                {block name='product_prices'}
                    {include file='catalog/_partials/product-prices.tpl'}
                    {hook h='displayProductPriceBlock' product=$product type="before_price"}
                {/block}
                {block name='product_reviews'}
                    {hook h='displayProductListReviews' product=$product}
                {/block}
                <div class="product-information">
                    {block name='product_description_short'}
                        <div id="product-description-short-{$product.id}" class="product-description-short" itemprop="description">{$product.description_short nofilter}
                        </div>
                    {/block}
                    {if $product.is_customizable && count($product.customizations.fields)}
                        {block name='product_customization'}
                            {include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
                        {/block}
                    {/if}
                    <div class="product-actions">
                        {block name='product_buy'}
                            <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                                <div class="image-sticky-wrapper">
                                    <img class="js-qv-product-cover" src="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image">
                                </div>
                                <div class="bon-sticky-name">
                                    <h1 class="h1" itemprop="name">{block name='page_title'}{$product.name|truncate:15:""}{/block}</h1>
                                    {block name='product_prices'}
                                        {include file='catalog/_partials/product-prices.tpl'}
                                        {hook h='displayProductPriceBlock' product=$product type="before_price"}
                                    {/block}
                                </div>
                                <input type="hidden" name="token" value="{$static_token}">
                                <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
                                <input type="hidden" name="id_customization" value="{$product.id_customization}" id="product_customization_id">
                                {block name='product_pack'}
                                    {if $packItems}
                                        <section class="product-pack">
                                            <p class="h4">{l s='This pack contains' d='Shop.Theme.Catalog'}</p>
                                            {foreach from=$packItems item="product_pack"}
                                                {block name='product_miniature'}
                                                    {include file='catalog/_partials/miniatures/pack-product.tpl' product=$product_pack}
                                                {/block}
                                            {/foreach}
                                        </section>
                                    {/if}
                                {/block}
                                {block name='product_discounts'}
                                    {include file='catalog/_partials/product-discounts.tpl'}
                                {/block}
                                {block name='product_variants'}
                                    {include file='catalog/_partials/product-variants.tpl'}
                                {/block}
                                {block name='product_add_to_cart'}
                                    {include file='catalog/_partials/product-add-to-cart.tpl'}
                                {/block}
                                {* Input to refresh product HTML removed, block kept for compatibility with themes *}
                                {block name='product_refresh'}{/block}
                            </form>
                        {/block}
                        {hook h='displayOneClick'}
                        {block name='product_additional_info'}
                            {include file='catalog/_partials/product-additional-info.tpl'}
                        {/block}
                    </div>
                    {block name='hook_display_reassurance'}
                        {hook h='displayReassurance'}
                    {/block}
                </div>
            </div>
        </div>
        {block name='product_right_column'}
            {hook h='displayRightColumnProduct' product=$product category=$category}
        {/block}                
        <div class="row">
            <div class="col-md-12">
                {*TOM*}
                {include file='catalog/_partials/product-details.tpl'}
                
                {block name='product_tabs'}
                    <div class="tabs product-tabs">
                        <ul id="tab-list" class="nav nav-tabs" role="tablist">
                            {if $product.description}
                                <li class="nav-item">
                                    <a class="nav-link{if $product.description} active{/if}" data-toggle="tab" href="#description" role="tab" aria-controls="description" {if $product.description} aria-selected="true" {/if}>{l s='Description' d='Shop.Theme.Catalog' }</a> </li> {/if}
                                {*TOM
                                  <li class="nav-item">
                                    <a class="nav-link{if !$product.description} active{/if}" data-toggle="tab" href="#product-details" role="tab" aria-controls="product-details" {if !$product.description} aria-selected="true" {/if}>{l s='Product Details' d='Shop.Theme.Catalog'}
                                    </a>
                                </li>*}
                                {if $product.attachments}
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#attachments" role="tab" aria-controls="attachments">{l s='Attachments' d='Shop.Theme.Catalog'}</a>
                                    </li>
                                {/if}
                                {foreach from=$product.extraContent item=extra key=extraKey}
                                    <li class="nav-item">
                                        <a class="nav-link reviewtab" data-toggle="tab" href="#extra-{$extraKey}" role="tab" aria-controls="extra-{$extraKey}">{$extra.title} ({$nbComments})</a>
                                    </li>
                                {/foreach}
                                {hook h="displayProductTab"}
                            </ul>                            
                            <div class="tab-content" id="tab-content">
                                <div class="tab-pane fade in{if $product.description} active{/if} revealOnScroll animated fadeInUp" data-animation="fadeInUp" id="description" role="tabpanel">
                                    {block name='product_description'}
                                        <div class="product-description">{$product.description nofilter}</div>
                                    {/block}
                                </div>
                                  {*TOM{block name='product_details'}
                                    {include file='catalog/_partials/product-details.tpl'}
                                {/block}*}
                                {block name='product_attachments'}
                                    {if $product.attachments}
                                        <div class="tab-pane fade in" id="attachments" role="tabpanel">
                                            <section class="product-attachments">
                                                {* <p class="h5 text-uppercase">{l s='Download' d='Shop.Theme.Actions'}</p>*}
                                                {foreach from=$product.attachments item=attachment}
                                                    <div class="attachment">
                                                        <h2><a href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">{$attachment.name}</a>
                                                        </h2>
                                                        <p>{$attachment.description}</p>
                                                        <a class="btn btn-primary btn-download" href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}">
                                                            {l s='Download' d='Shop.Theme.Actions'} ({$attachment.file_size_formatted})
                                                        </a>
                                                    </div>
                                                {/foreach}
                                            </section>
                                        </div>
                                    {/if}
                                {/block}
                                {foreach from=$product.extraContent item=extra key=extraKey}
                                    <div class="tab-pane fade in revealOnScroll animated{$extra.attr.class}" data-animation="fadeInUp" id="extra-{$extraKey}" role="tabpanel" {foreach $extra.attr as $key=> $val}{/foreach}>
                                        {$extra.content nofilter}
                                    </div>
                                {/foreach}
                                {hook h="displayProductTabContent"}
                            </div>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"></div>
                        </div>
                    {/block}
                    {block name='product_accessories'}
                        {if $accessories}
                            <section class="spaced-section-reduced product-accessories featured-products featured-products-swiper clearfix">
                                <h2 class="h2 products-section-title text-uppercase revealOnScroll animated fadeInUp" data-animation="fadeInUp">{l s='You <span>might</span>
                                    also <span>like</span>' d='Shop.Theme.Catalog'}
{*                                    <div class="prod-swiper-button_wrapper">*}
{*                                        <div class="theme-style bonswiper-button-prev swiper-button-prev"></div>*}
{*                                        <span class="current"></span>*}
{*                                        <span class="total"></span>*}
{*                                        <div class="theme-style bonswiper-button-next swiper-button-next"></div>*}
{*                                    </div>*}
                                </h2>
{*                                <span class="same-products-description revealOnScroll animated fadeInUp" data-animation="fadeInUp">{l*}
{*                                    s='Stay ahead of fashion trends with our new selection.' d='Shop.Theme.Catalog'}</span>*}
                                <div class="products swiper-wrapper">
                                    {foreach from=$accessories item="product_accessory"}
                                        {block name='product_miniature'}
                                            {include file='catalog/_partials/miniatures/product.tpl' product=$product_accessory}
                                        {/block}
                                    {/foreach}
                                </div>
                                <div class="bonswiper-pagination swiper-pagination"></div>
                            </section>
                        {/if}
                    {/block}
                </div>
            </div>                
            {block name='product_footer'}
                {hook h='displayFooterProduct' product=$product category=$category}
            {/block}
            {block name='product_images_modal'}
                {include file='catalog/_partials/product-images-modal.tpl'}
            {/block}
            {block name='page_footer_container'}
                <footer class="page-footer">
                    {block name='page_footer'}
                        <!-- Footer content -->
                    {/block}
                </footer>
            {/block}
        {/block}
    </div>