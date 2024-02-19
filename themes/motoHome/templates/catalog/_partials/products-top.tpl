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

{block name='product_list_header'}
{*    {if isset($listing.label) && $listing.label}*}
{*        <h1 class="h1">*}
{*            {$listing.label}*}
{*        </h1>*}
{*    {/if}*}
{/block}
<div id="js-product-list-header" class="row revealOnScroll animated fadeInUp" data-animation="fadeInUp">
    {if $category.description}
    {if $listing.pagination.items_shown_from == 1}

        <div id="category-description" class="text-muted">{$category.description nofilter}</div>
       {if $category.image.large.url}
      <div class="category-cover">
          <img src="{$category.image.large.url}" alt="{if !empty($category.image.legend)}{$category.image.legend}{else}{$category.name}{/if}">
      </div>
      {/if} 

    {/if}
    {/if}
</div>
<div id="js-product-list-top" class="row products-selection revealOnScroll animated fadeInUp" data-animation="fadeInUp">
    <div class="col-md-6 d-none d-md-block total-products pl-0">
        <h1 class="h1">
            {if $listing.pagination.total_items > 1}
                <span>{l s='%product_count% products.' d='Shop.Theme.Catalog' sprintf=['%product_count%' => $listing.pagination.total_items]}</span>
            {elseif $listing.pagination.total_items > 0}
                <span>{l s='1 product.' d='Shop.Theme.Catalog'}</span>
            {/if}
        </h1>
    </div>
    <div class="col-md-6">
        <div class="sort-by-row">
            {block name='sort_by'}
                {include file='catalog/_partials/sort-orders.tpl' sort_orders=$listing.sort_orders}
            {/block}
            {if !empty($listing.rendered_facets)}
                <div class=" d-md-none filter-button">
                    <button id="search_filter_toggler" class="btn btn-primary">
                        {l s='Filter' d='Shop.Theme.Actions'}
                    </button>
                </div>
            {/if}
            {if $page.page_name == 'category'}
                {hook h="displayGridButton"}
            {/if}
        </div>
    </div>
    <div class="d-md-none text-sm-center showing">
        {l s='Showing %from%-%to% of %total% item(s)' d='Shop.Theme.Catalog' sprintf=[
        '%from%' => $listing.pagination.items_shown_from ,
        '%to%' => $listing.pagination.items_shown_to,
        '%total%' => $listing.pagination.total_items
        ]}
    </div>
</div>