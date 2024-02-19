{*
* 2015-2021 Bonpresta
*
* Bonpresta Collection Manager with Photos and Videos
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

{extends file=$layout}

{block name='content'}
    {if isset($items) && $items}
        <div class="clearfix"></div>
        <section id="boncollection" class="boncollection-main">
            <div class="title-block revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                <h2 class="h2 products-section-title less custom-page">
                    {l s='Latest Collections' mod='boncollection'}
                </h2>
            </div>
            <ul class="revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                <div class="row">
                    {foreach from=$items item=item name=item}
                        {assign var="collection_url" value="{$link->getModuleLink('boncollection', 'collection', ['id_tab'=>$item.id, 'link_rewrite'=>$item.url])|escape:'htmlall':'UTF-8'}"}
                        {if $smarty.foreach.item.iteration <= $limit}
                            <li class="boncollection-item col-12 col-xs-12 col-md-6 col-lg-4">
                                {if isset($item.image) && $item.image}
                                    <a class="boncollection-image" href="{$collection_url}">
                                        <img class="img-responsive"
                                            src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                            alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                        <div class="boncollection-item-title">
                                            {if isset($item.title) && $item.title}
                                                <h3>{$item.title nofilter}</h3>
                                                <i class="bonicon-rightarrow30"></i>
                                            {/if}
                                        </div>
                                    </a>
                                {/if}
                                <div class="boncollection-item-description">
                                    {if isset($item.description) && $item.description}
                                        <p class="description">{$item.description nofilter}</p>
                                        <div class="description-footer">
                                            {if isset($item.date_public) && $item.date_public}
                                                <p>
                                                    {$item.date_public|date_format:"%B %e, %Y"|escape:'htmlall':'UTF-8'}
                                                </p>
                                            {/if}
                                            {if $item.quantity_sub > 0}
                                                <p class="quantity_sub">{$item.quantity_sub|escape:'htmlall':'UTF-8'}
                                                    {l s='element(s)' mod='boncollection'}
                                                </p>
                                            {else}
                                                <p class="quantity_sub">
                                                    {l s='0 element(s)' mod='boncollection'}
                                                </p>
                                            {/if}
                                        </div>

                                    {/if}
                                </div>
                            </li>
                        {/if}
                    {/foreach}
                </div>
            </ul>
            <nav class="pagination">
                <div class="col-md-4">
                    {block name='pagination_summary'}
                        Showing {$pagination.items_shown_from}-{$pagination.items_shown_to} of {$pagination.total_items} item(s)
                    {/block}
                </div>
                <div class="col-md-6 offset-md-2 pr-0">
                    {block name='pagination_page_list'}
                        {if $pagination.should_be_displayed}
                            <ul class="page-list clearfix text-sm-center">
                                {foreach from=$pagination.pages item="page"}
                                    <li {if $page.current} class="current" {/if}>
                                        {if $page.type === 'spacer'}
                                            <span class="spacer">&hellip;</span>
                                        {else}
                                            <a
                                                rel="{if $page.type === 'previous'}prev{elseif $page.type === 'next'}next{else}nofollow{/if}"
                                                href="{$page.url}"
                                                class="{if $page.type === 'previous'}previous {elseif $page.type === 'next'}next {/if}">
                                                {if $page.type === 'previous'}
                                                    <i class="material-icons">&#xE314;</i>{l s='Previous' d='Shop.Theme.Actions'}
                                                {elseif $page.type === 'next'}
                                                    {l s='Next' d='Shop.Theme.Actions'}<i class="material-icons">&#xE315;</i>
                                                {else}
                                                    {$page.page}
                                                {/if}
                                            </a>
                                        {/if}
                                    </li>
                                {/foreach}
                            </ul>
                        {/if}
                    {/block}
                </div>
            </nav>
        </section>
    {/if}
{/block}