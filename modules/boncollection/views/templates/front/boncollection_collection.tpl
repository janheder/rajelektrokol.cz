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
    {if isset($collection) && $collection}
        <section id="boncollection-page">
            <div class="clearfix"></div>
            <div class="row boncollection-wrapper">
                <div class="boncollection-image col-12 col-xs-12 col-md-6">
                    {if isset($collection.image) && $collection.image}
                        <img class="img-responsive"
                            src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$collection.image|escape:'htmlall':'UTF-8'}"
                            alt="{$collection.title|escape:'htmlall':'UTF-8'}" />
                    {/if}
                </div>
                <div class="boncollection-info col-12 col-xs-12 col-md-6">
                    <h5 class="mb-1">{l s='Collection' mod='boncollection'}</h5>
                    {if isset($collection.title) && $collection.title}
                        <h2 class="mb-1">{$collection.title nofilter}</h2>
                    {/if}
                    {if isset($collection.description) && $collection.description}
                        <p class="boncollection-description">{$collection.description nofilter}</p>
                    {/if}
                    <hr>
                    {if isset($collection.author_name) && $collection.author_name}
                        <p class="author">{l s='by' mod='boncollection'} {$collection.author_name} </p>
                    {/if}
                    {if isset($collection.date_public) && $collection.date_public}
                        <p> {$collection.date_public|date_format:"%A, %B %e, %Y"|escape:'htmlall':'UTF-8'}
                        </p>
                    {/if}
                </div>
            </div>
            {if isset($items) && $items}
                <div class="container boncollection-container">
                <ul class="row boncollection-items">
                    {foreach from=$items item=item name=item}
                        <li class="boncollection-item">
                            {if $item.type == 'image'}
                                {if isset($item.image) && $item.image}
                                    <a data-caption="{$item.title nofilter}" data-fancybox="gallery"
                                        href="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}">
                                        <img class="img-responsive"
                                            src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                            alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                        <div class="boncollection-item-description">
                                            {if isset($item.title) && $item.title}
                                                <h3>{$item.title nofilter}</h3>
                                            {/if}
                                            <hr>
                                            {if isset($item.description) && $item.description}
                                              <p class="">{$item.description nofilter}</p>
                                            {/if}
                                        </div>
                                    </a>
                                {/if}
                            {elseif $item.type == 'video'}
                                {if isset($item.cover) && $item.cover}
                                    <div class="boncollection-video">
                                        <div class="boncollection-cover-img">
                                            <img class="img-responsive"
                                                src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.cover|escape:'htmlall':'UTF-8'}"
                                                alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                            <a href="#" class="boncollection-video-link" data-toggle="modal"
                                                data-target="#boncollection-video">
                                            </a>
                                        </div>
                                        <div class="modal fade show" id="boncollection-video" tabindex="-1" role="dialog"
                                            aria-labelledby="boncollection-video" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <video id="boncollection-video-element" class="" loop="loop" controls>
                                                            <source
                                                                src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                                type="video/mp4">
                                                        </video>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {else}
                                    <div class="box-boncollection-video">
                                        <video id="video-element" class="" loop="loop">
                                            <source
                                                src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                type="video/mp4">
                                        </video>
                                    </div>
                                {/if}

                            {/if}

                        </li>
                    {/foreach}
                </ul></div>
            {/if}

            <div class="boncollection-nav">
                <a href="{$link->getModuleLink('boncollection', 'main')}">
                    <i class="material-icons">&#xE314;</i>{l s='Show More Collections' mod='boncollection'}
                </a>
                {if isset($add_sharebuttons) && $add_sharebuttons}
                    <div class="boncollection-social social-sharing">
                        <p>{l s='Share on:' mod='bonnews'}</p>
                        <ul>
                            {assign var="collection_url" value="{$link->getModuleLink('boncollection', 'collection', ['id_tab'=>$collection.id, 'link_rewrite'=>$collection.url])|escape:'htmlall':'UTF-8'}"}
                            <li class="facebook"><a target="_blank"
                                    href="https://www.facebook.com/sharer.php?u={$collection_url}"></a>
                            </li>
                            <li class="twitter"><a target="_blank"
                                    href="https://twitter.com/intent/tweet?text={$collection.title|escape:'htmlall':'UTF-8'}{$collection_url}"></a>
                            </li>
                            <li class="pinterest">
                                <a target="_blank"
                                    href="https://www.pinterest.com/pin/create/button/?media={$urls.base_url}modules/boncollection/views/img/{$collection.image|escape:'htmlall':'UTF-8'}&url={$collection_url}"></a>
                            </li>
                        </ul>
                    </div>
                {/if}
                {* <div class="bon-prevnextcollection">
                        {if isset($prevNextcollection.prev_id) && $prevNextcollection.prev_id}
                            <a
                                href="{$link->getModuleLink('boncollection', 'collection', ['id_tab'=>$prevNextcollection.prev_id, 'link_rewrite'=>$prevNextcollection.url_prev])|escape:'htmlall':'UTF-8'}">
                                <i class="material-icons">&#xE314;</i>{l s='Prev' mod='boncollection'}
                            </a>
                        {/if}
                        {if isset($prevNextcollection.next_id) && $prevNextcollection.next_id}
                            <a
                                href="{$link->getModuleLink('boncollection', 'collection', ['id_tab'=>$prevNextcollection.next_id, 'link_rewrite'=>$prevNextcollection.url_next])|escape:'htmlall':'UTF-8'}">
                                {l s='Next' mod='boncollection'}<i class="material-icons">&#xE315;</i>
                            </a>
                        {/if}
                    </div> *}
            </div>
        </section>
    {/if}
{/block}