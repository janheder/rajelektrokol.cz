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
{*TOM    
<div class="h2 products-section-title revealOnScroll animated fadeInUp" data-animation="fadeInUp">
    {l s='the <span>bike</span> is the pursuit of <span>freedom</span>' d='Shop.Theme.Catalog'}
{*    <div class="prod-swiper-button_wrapper">*}
{*        <div class="theme-style bonswiper-button-prev swiper-button-prev"></div>*}
{*        <span class="current"></span>*}
{*        <span class="total"></span>*}
{*        <div class="theme-style bonswiper-button-next swiper-button-next"></div>*}
{*    </div>*}
{*TOM</div>*}
{*TOM
<span class="products-section-description revealOnScroll animated fadeInUp" data-animation="fadeInUp">
    {l s='Lorem ipsum dolor sit amet, consecteturadipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco consequat.' d='Shop.Theme.Catalog'}
</span>
*}

<div class="container">
    <section class="spaced-section featured-products main-animate-product clearfix">

{*        <div class="products swiper-wrapper">*}
        <div class="products row">
            {foreach from=$products item="product"}
                {include file="catalog/_partials/miniatures/product.tpl" product=$product}
            {/foreach}
        </div>

        {*<a class="all-product-link float-xs-left float-md-right h4" href="{$allProductsLink}">
            {l s='All products' d='Shop.Theme.Catalog'}<i class="material-icons">&#xE315;</i>
        </a>*}
        <div class="bonswiper-pagination swiper-pagination"></div>
    </section>

    {hook h='displayButtonScroll'  url=$allProductsLink parent='.featured-products .products'}
</div>