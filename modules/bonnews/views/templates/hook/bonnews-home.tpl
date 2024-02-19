{*
* 2015-2021 Bonpresta
*
* Bonpresta News Manager with Videos and Comments
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
    {if isset($home_title) && $home_title}
        <a href="{$link->getModuleLink('bonnews', 'main')|escape:'htmlall':'UTF-8'}">
            <h2 class="h2 products-section-title bonnews-home-title">
                {assign var="text" value=$home_title}
                {assign var="split" value=" "|explode:$text}
                {foreach from=$split item=item name=item}
                    {if $smarty.foreach.item.iteration == 1}
                        <span>{$item}</span>
                    {else}
                        {$item}
                    {/if}
                {/foreach}
            </h2>
        </a>
    {/if}
    <div class="spaced-section container">
        <div class="clearfix"></div>
        <section id="bonnews" class="bon-home">
            <div class="title-block revealOnScroll animated fadeInUp" data-animation="fadeInUp">
{*                <span>{l s='Stay ahead of the fashion trends with our news.' mod='bonnews'}</span>*}

            </div>
            <ul class="news-slider home revealOnScroll animated fadeInUp mb-0" data-animation="fadeInUp">
                {foreach from=$items item=item name=item}
                    {assign var="post_url" value="{$link->getModuleLink('bonnews', 'post', ['id_tab'=>$item.id, 'link_rewrite'=>$item.url])|escape:'htmlall':'UTF-8'}"}
                    {if $smarty.foreach.item.iteration <= $limit}
                        <li class="col-xs-12 col-sm-6 col-md-4 revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                            {if $item.type == 'image'}
                                {if isset($item.image) && $item.image}
                                    <a class="bonnews-image" href="{$post_url|escape:'htmlall':'UTF-8'}">
                                        <img class="img-responsive"
                                            src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                            alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                    </a>
                                {/if}
                            {elseif $item.type == 'video'}
                                {if isset($item.cover) && $item.cover}
                                    <div class="bonnews-video">
                                        <div class="bonnews-cover-img">
                                            <img class="img-responsive"
                                                src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.cover|escape:'htmlall':'UTF-8'}"
                                                alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                            <a href="#" class="bonnews-video-link" data-toggle="modal" data-target="#bonnews-video"></a>
                                        </div>
                                        {if !$display_carousel}
                                            <div class="modal fade show" id="bonnews-video" tabindex="-1" role="dialog"
                                                aria-labelledby="bonnews-video" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <video id="bonnews-video-element" class="" loop="loop" controls>
                                                                <source
                                                                    src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                                    type="video/mp4">
                                                            </video>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                {else}
                                    <div class="box-bonnews">
                                        <video id="video-element" class="" loop="loop">
                                            <source
                                                src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                type="video/mp4">
                                        </video>
                                    </div>
                                {/if}
                            {/if}
                            <div class="box-bonnews">
                                <div class="bonnews-item-description">

                                    {if isset($item.title) && $item.title}
                                        <a href="{$post_url|escape:'htmlall':'UTF-8'}">
                                            <h3>{$item.title|escape:'htmlall':'UTF-8'}</h3>
                                        </a>
                                    {/if}
                                    {if isset($item.description) && $item.description}
                                        {$item.description|escape:'htmlall':'UTF-8' nofilter}
                                    {/if}
                                </div>
                            </div>
                        </li>
                    {/if}
                {/foreach}
            </ul>
            {if $display_carousel}
                {foreach from=$items item=item name=item}
                    {if isset($item.cover) && $item.cover}
                        {if $smarty.foreach.item.iteration <= $limit} <div class="modal fade show show" id="bonnews-video" tabindex="-1"
                                role="dialog" aria-labelledby="bonnews-video" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video id="bonnews-video-element" class="" loop="loop" controls>
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
        </section>
    </div>
{/if}