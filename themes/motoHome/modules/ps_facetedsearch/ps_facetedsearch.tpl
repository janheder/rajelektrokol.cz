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
    {if isset($listing.rendered_facets)}
        <div id="search_filters_wrapper" class="d-none d-md-block revealOnScroll animated fadeInUp" data-animation="fadeInUp">
            <div id="search_filter_controls" class="d-md-none">
                <span id="_mobile_search_filters_clear_all"></span>
                <button class="btn btn-secondary ok">
                    <i class="material-icons rtl-no-flip">&#xE876;</i>
                    {l s='OK' d='Shop.Theme.Actions'}
                </button>
            </div>
            {$listing.rendered_facets nofilter}
        </div>
    {/if}
<section id="js-active-search-filters" class="{if $activeFilters|count}active_filters{else}hide{/if} ">
    {block name='active_filters_title'}
{*        <p class="h6 {if $activeFilters|count}active-filter-title{else}d-sm-none{/if}">{l s='Active filters' d='Shop.Theme.Global'}</p>*}
    {/block}

    {if $activeFilters|count}
        <ul>
            {foreach from=$activeFilters item="filter"}
                {block name='active_filters_item'}
                    <li class="filter-block">
                        {l s='%1$s: ' d='Shop.Theme.Catalog' sprintf=[$filter.facetLabel]}
                        {$filter.label}
                        <a class="js-search-link" href="{$filter.nextEncodedFacetsURL}"><i class="material-icons close">&#xE5CD;</i></a>
                    </li>
                {/block}
            {/foreach}
        </ul>
    {/if}
</section>
