{*
* 2015-2021 Bonpresta
*
* Bonpresta Portfolio with Masonry Effect
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
Business Clothes
{block name='content'}
    {if isset($categories) && $categories}
        <div class="clearfix"></div>
        <section id="bonportfolio" class="bonportfolio-main">
            <div class="title-block revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                <h2 class="h2 products-section-title less custom-page">
                    {l s='Portfolio' mod='bonportfolio'}
                </h2>
            </div>
            <ul class="bonportfolio-tabs">
                <li class="bonportfolio-item-title active"
                    data-category="0">
                    <h3> {l s='All Categories' mod='bonportfolio'}</h3>
                </li>
                {foreach from=$categories item=category name=category}
                    {if isset($category.title) && $category.title}
                        <li class="bonportfolio-item-title"
                            data-category="{$category.id|escape:'htmlall':'UTF-8'}">
                            <h3>{$category.title|escape:'htmlall':'UTF-8'}</h3>
                        </li>
                    {/if}
                {/foreach}
            </ul>
            <div class="row" style="opacity: 0; transition: all .3s linear;">
                <ul style="height: 0" class="bonportfolio-items col-12 col-xs-12 active revealOnScroll animated fadeInUp"
                    data-animation="fadeInUp"
                    data-category="0">
                    {foreach from=$categories_all item=category name=category}
                        {if isset($category.items) && $category.items}
                            {foreach from=$category.items item=item name=item}
                                <li class="bonportfolio-item revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                                    {if $item.type == 'image'}
                                        {if isset($item.image) && $item.image}
                                            <a data-caption="{$item.title|escape:'htmlall':'UTF-8'}" data-fancybox="gallery"
                                                href="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}">
                                                <img class="img-responsive"
                                                    src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                    alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                                <div class="bonportfolio-item-description">
                                                    {if isset($item.title) && $item.title}
                                                        <h3>{$item.title|escape:'htmlall':'UTF-8'}</h3>
                                                    {/if}
                                                    <hr>
                                                    {if isset($item.description) && $item.description}
                                                        <p>
                                                            {$item.description|escape:'htmlall':'UTF-8' nofilter}</p>
                                                    {/if}
                                                </div>
                                            </a>
                                        {/if}
                                    {elseif $item.type == 'video'}
                                        {if isset($item.cover) && $item.cover}
                                            <div class="bonportfolio-video">
                                                <div class="bonportfolio-cover-img">
                                                    <img class="img-responsive"
                                                        src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.cover|escape:'htmlall':'UTF-8'}"
                                                        alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                                    <a href="#" class="bonportfolio-video-link" data-toggle="modal"
                                                        data-target="#bonportfolio-video-{$item['id_tab']|escape:'htmlall':'UTF-8'}">
                                                    </a>
                                                </div>
                                            </div>
                                        {else}
                                            <div class="box-bonportfolio-video">
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
                        {/if}
                    {/foreach}
                </ul>
            </div>
            {foreach from=$categories item=category name=category}
                <div class="row">
                    <ul class="bonportfolio-items col-12 col-xs-12 revealOnScroll animated fadeInUp" data-animation="fadeInUp"
                        data-category="{$category.id|escape:'htmlall':'UTF-8'}">
                        {if isset($category.items) && $category.items}
                            {foreach from=$category.items item=item name=item}
                                <li class="bonportfolio-item revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                                    {if $item.type == 'image'}
                                        {if isset($item.image) && $item.image}
                                            <a data-caption="{$item.title|escape:'htmlall':'UTF-8'}" data-fancybox="gallery"
                                                href="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}">
                                                <img class="img-responsive"
                                                    src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                    alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                                <div class="bonportfolio-item-description">
                                                    {if isset($item.title) && $item.title}
                                                        <h3>{$item.title|escape:'htmlall':'UTF-8'}</h3>
                                                    {/if}
                                                    <hr>
                                                    {if isset($item.description) && $item.description}
                                                        <p>
                                                            {$item.description|escape:'htmlall':'UTF-8' nofilter}</p>
                                                    {/if}
                                                </div>
                                            </a>
                                        {/if}
                                    {elseif $item.type == 'video'}
                                        {if isset($item.cover) && $item.cover}
                                            <div class="bonportfolio-video">
                                                <div class="bonportfolio-cover-img">
                                                    <img class="img-responsive"
                                                        src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.cover|escape:'htmlall':'UTF-8'}"
                                                        alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                                    <a href="#" class="bonportfolio-video-link" data-toggle="modal"
                                                        data-target="#bonportfolio-video-{$item['id_tab']|escape:'htmlall':'UTF-8'}">
                                                    </a>
                                                </div>
                                            </div>
                                        {else}
                                            <div class="box-bonportfolio-video">
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
                        {/if}
                    </ul>
                </div>
            {/foreach}
            {if isset($add_sharebuttons) && $add_sharebuttons}
                <div class="bonportfolio-social social-sharing">
                    <p>{l s='Share on:' mod='bonnews'}</p>
                    <ul>
                        {assign var="portfolio_url" value="{$link->getModuleLink('bonportfolio', 'main', array(), true)|escape:'htmlall':'UTF-8'}"}
                        <li class="facebook"><a target="_blank"
                                href="https://www.facebook.com/sharer.php?u={$portfolio_url|escape:'htmlall':'UTF-8'}"></a>
                        </li>
                        <li class="twitter"><a target="_blank"
                                href="https://twitter.com/intent/tweet?text={$portfolio_url|escape:'htmlall':'UTF-8'}"></a>
                        </li>
                        <li class="pinterest">
                            <a target="_blank"
                                href="https://www.pinterest.com/pin/create/button/?media={$urls.base_url|escape:'htmlall':'UTF-8'}modules/bonportfolio/views/img/{$categories[0]['items'][0]['image']|escape:'htmlall':'UTF-8'}&url={$portfolio_url|escape:'htmlall':'UTF-8'}"></a>
                        </li>
                    </ul>
                </div>
            {/if}
            {foreach from=$categories item=category name=category}
                {if isset($category.items) && $category.items}
                    {foreach from=$category.items item=item name=item}
                        {if $item.type == 'video'}
                            {if isset($item.cover) && $item.cover}
                                <div class="modal fade show" id="bonportfolio-video-{$item['id_tab']|escape:'htmlall':'UTF-8'}" tabindex="-1"
                                    role="dialog"
                                    aria-labelledby="bonportfolio-video" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <video id="bonportfolio-video-element" class="" loop="loop" controls>
                                                    <source
                                                        src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                        type="video/mp4">
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {/if}
                    {/foreach}
                {/if}
            {/foreach}
        </section>
    {/if}
{/block}