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
<div class="less h2 products-section-title revealOnScroll animated fadeInUp" data-animation="fadeInUp">
    {if $products|@count == 1}
        {l s='<span>%s</span> other <span>product</span> in the <span>same</span> category:' sprintf=[$products|@count] d='Shop.Theme.Catalog'}
    {else}
        {l s='<span>%s</span> other <span>products</span> in the <span>same</span> category:' sprintf=[$products|@count] d='Shop.Theme.Catalog'}
    {/if}
    {*                <div class="prod-swiper-button_wrapper d-none d-md-flex">*}
    {*                    <div class="theme-style bonswiper-button-prev swiper-button-prev"></div>*}
    {*                    <span class="current"></span>*}
    {*                    <span class="total"></span>*}
    {*                    <div class="theme-style bonswiper-button-next swiper-button-next"></div>*}
    {*                </div>*}
</div>
<div class="row">
    <div class="col-md-12">
        <section class="spaced-section-reduced featured-products same-products featured-products-swiper clearfix revealOnScroll animated fadeInUp" data-animation="fadeInUp">
            {*        <span class="same-products-description">{l s='Stay ahead of the automotive trends trends with our new selection.' d='Shop.Theme.Catalog'}</span>*}
            <div class="products swiper-wrapper">
                {foreach from=$products item="product"}
                    {include file="catalog/_partials/miniatures/product.tpl" product=$product}
                {/foreach}
            </div>
            <div class="bonswiper-pagination swiper-pagination"></div>
        </section>
    </div>
</div>