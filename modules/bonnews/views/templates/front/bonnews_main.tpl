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

{extends file=$layout}

{block name='content'}
    {if isset($items) && $items}
        <div class="clearfix"></div>
        <section id="bonnews" class="bon-main">
            <div class="title-block revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                <h2 class="h2 products-section-title">
                    {l s='Latest News' mod='bonnews'}
                </h2>
{*                <span>{l s='Stay ahead of the trends with our news.' mod='bonnews'}</span>*}
            </div>
            <ul class="news-slider revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                {foreach from=$items item=item name=item}
                    {assign var="post_url" value="{$link->getModuleLink('bonnews', 'post', ['id_tab'=>$item.id, 'link_rewrite'=>$item.url])|escape:'htmlall':'UTF-8'}"}
                    <li class="bonnews-item">
                        <div class="row">
                            {if $item.type == 'image'}
                                {if isset($item.image) && $item.image}
                                    <a class="bonnews-image col-12 col-lg-4" href="{$post_url|escape:'htmlall':'UTF-8'}">
                                        <img class="img-responsive"
                                            src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                            alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                    </a>
                                {/if}
                            {elseif $item.type == 'video'}
                                {if isset($item.cover) && $item.cover}
                                    <div class="bonnews-video col-12 col-lg-4">
                                        <div class="bonnews-cover-img">
                                            <img class="img-responsive"
                                                src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.cover|escape:'htmlall':'UTF-8'}"
                                                alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                            <a href="#" class="bonnews-video-link" data-toggle="modal" data-target="#bonnews-video">
                                            </a>
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
                                    <div class="box-bonnews col-12 col-lg-4">
                                        <video id="video-element" class="" loop="loop">
                                            <source
                                                src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                type="video/mp4">
                                        </video>
                                    </div>
                                {/if}
                            {/if}
                            <div class="box-bonnews col-12 col-lg-8">
                                <div class="bonnews-item-description">
                                    {if isset($item.title) && $item.title}
                                        <a href="{$post_url|escape:'htmlall':'UTF-8'}">
                                            <h3>{$item.title|escape:'htmlall':'UTF-8'}</h3>
                                        </a>
                                    {/if}
                                    {if isset($item.description) && $item.description}
                                        {$item.description|escape:'htmlall':'UTF-8' nofilter}
                                        {if isset($item.author_name) && $item.author_name}
                                            <p class="author">
                                                <span>{l s='by' mod='bonnews'} <strong
                                                        style="color: #3a3a3a">{$item.author_name|escape:'htmlall':'UTF-8'}
                                                    </strong>{l s='on' mod='bonnews'}
                                                    {$item.date_post|date_format|escape:'htmlall':'UTF-8'}</span>
                                                {if isset($add_disqus) && $add_disqus}
                                                    <span class="comment-counter"><i class="fl-outicons-speech-balloon2"></i><a
                                                            href="{$post_url|escape:'htmlall':'UTF-8'}#disqus_thread"></a></span>
                                                {/if}
                                            </p>
                                        {/if}
                                    {/if}
                                </div>
                                <a href="{$post_url|escape:'htmlall':'UTF-8'}" class="read-more">
                                    {l s='Read More' mod='bonnews'}</a>
                            </div>
                        </div>
                    </li>
                {/foreach}
            </ul>
            {if $display_carousel}
                {foreach from=$items item=item name=item}
                    {if isset($item.cover) && $item.cover}
                        {if $smarty.foreach.item.iteration <= $limit} <div class="modal fade show" id="bonnews-video" tabindex="-1"
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
        <nav class="pagination">
            <div class="col-md-4">
                {block name='pagination_summary'}
                    {l s='Showing %from%-%to% of %total% item(s)' mod='bonnews' sprintf=['%from%' => $pagination.items_shown_from ,'%to%' => $pagination.items_shown_to, '%total%' => $pagination.total_items]}
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
                                            href="{$page.url|escape:'htmlall':'UTF-8'}"
                                            class="{if $page.type === 'previous'}previous {elseif $page.type === 'next'}next {/if}">
                                            {if $page.type === 'previous'}
                                                <i class="material-icons">&#xE314;</i>{l s='Previous' mod='bonnews'}
                                            {elseif $page.type === 'next'}
                                                {l s='Next' mod='bonnews'}<i class="material-icons">&#xE315;</i>
                                            {else}
                                                {$page.page|escape:'htmlall':'UTF-8'}
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
    {/if}
    {if isset($add_disqus) && $add_disqus}
        <script id="dsq-count-scr" src="//{$disqus_name|escape:'htmlall':'UTF-8'}.disqus.com/count.js" async></script>
    {/if}
{/block}