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

{if isset($items) && $items}
    <div class="container">
        <div class="clearfix"></div>
        <section id="boncollection" class="boncollection-home">
{*            <div class="title-block revealOnScroll animated fadeInUp" data-animation="fadeInUp">*}
{*                <a href="{$link->getModuleLink('boncollection', 'main')}">*}
{*                    <h2 class="h2 products-section-title text-uppercase">*}
{*                        {l s='Our Collections' mod='boncollection'}*}
{*                    </h2>*}
{*                </a>*}
{*                <span>{l s='Stay ahead of the trends with our collections.' mod='boncollection'}</span>*}
{*            </div>*}
            <div class="boncollection-wrapper row">
                <div class="boncollection-text offset-xl-1 col-xl-4 col-md-5 col-12">
                    {foreach from=$items item=item name=item}
                        {if $smarty.foreach.item.iteration <= 1}
                            {if isset($item.title) && $item.title}
                                <h3 class="boncollection-title">{$item.title nofilter}</h3>
                            {/if}
                            {if isset($item.description) && $item.description}
                                <div class="boncollection-description">{$item.description nofilter}</div>
                            {/if}
                            <div class="boncollection-btn-wrapper">
                                <a class="boncollection-btn btn-primary" href="{$link->getModuleLink('boncollection', 'main')}">{l s='Show All!' mod='boncollection'}</a>
                            </div>
                        {/if}
                    {/foreach}
                </div>
                <div class="boncollection-images col-12 col-md-7 col-xl-6">
                    <ul class="boncollection-slider">
                        {foreach from=$items item=item name=item}
                            {assign var="collection_url" value="{$link->getModuleLink('boncollection', 'collection', ['id_tab'=>$item.id, 'link_rewrite'=>$item.url])|escape:'htmlall':'UTF-8'}"}
                            {if $smarty.foreach.item.iteration <= 3}
                                <li class="boncollection-item"
                                    >
                                    {if isset($item.image) && $item.image}
                                        <a class="boncollection-image revealOnScroll animated" href="{$collection_url}">
                                            <img class="img-responsive"
                                                 src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                 alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                        </a>
                                    {/if}
                                </li>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
            </div>
        </section>
    </div>
{/if}