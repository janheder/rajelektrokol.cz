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
    {if isset($post) && $post}
        <section id="bonnews" class="bonpost container revealOnScroll animated fadeInUp" data-animation="fadeInUp">
            <div class="top-post row">
                {if isset($post.title) && $post.title}
                    <h2>{$post.title|escape:'htmlall':'UTF-8'}</h2>
                {/if}
                <div class="bon-prevnextpost">
                    {if isset($prevNextPost.prev_id) && $prevNextPost.prev_id}
                        <a class="prev-post"
                            href="{$link->getModuleLink('bonnews', 'post', ['id_tab'=>$prevNextPost.prev_id, 'link_rewrite'=>$prevNextPost.url_prev])|escape:'htmlall':'UTF-8'}">
                            <i class="material-icons">&#xE314;</i>{l s='Prev' mod='bonnews'}
                        </a>
                    {/if}
                    {if isset($prevNextPost.next_id) && $prevNextPost.next_id}
                        <a class="next-post"
                            href="{$link->getModuleLink('bonnews', 'post', ['id_tab'=>$prevNextPost.next_id, 'link_rewrite'=>$prevNextPost.url_next])|escape:'htmlall':'UTF-8'}">
                            {l s='Next' mod='bonnews'}<i class="material-icons">&#xE315;</i>
                        </a>
                    {/if}
                </div>
            </div>
            <div class="news-slider">
                <div class="content">
                    {if $post.type == 'image'}
                        {if isset($post.image) && $post.image}
                            <div class="bonnews-image">
                                <img class="img-responsive"
                                    src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$post.image|escape:'htmlall':'UTF-8'}"
                                    alt="{$post.title|escape:'htmlall':'UTF-8'}" />

                            </div>
                        {/if}
                    {elseif $post.type == 'video'}
                        <div class="post-video">
                            {if isset($post.cover) && $post.cover}
                                <div class="bonnews-video">
                                    <div class="bonnews-cover-img">
                                        <img class="img-responsive"
                                            src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$post.cover|escape:'htmlall':'UTF-8'}"
                                            alt="{$post.title|escape:'htmlall':'UTF-8'}" />
                                        <a href="#" class="bonnews-video-link" data-toggle="modal" data-target="#bonnews-video">
                                        </a>
                                    </div>
                                    <div class="modal fade show" id="bonnews-video" tabindex="-1" role="dialog"
                                        aria-labelledby="bonnews-video" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <video id="bonnews-video-element" class="" loop="loop" controls>
                                                        <source
                                                            src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$post.image|escape:'htmlall':'UTF-8'}"
                                                            type="video/mp4">
                                                    </video>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {else}
                                <div class="box-bonnews">
                                    <video id="video-element" class="" loop="loop">
                                        <source
                                            src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$post.image|escape:'htmlall':'UTF-8'}"
                                            type="video/mp4">
                                    </video>
                                </div>
                            {/if}
                        </div>
                    {/if}
                    {if isset($post.content_post) && $post.content_post}
                        <div class="box-bonnews">
                            <div class="bonnews-post-description">
                                {$post.content_post|escape:'htmlall':'UTF-8' nofilter}
                            </div>
                        </div>
                    {/if}
                </div>
            </div>

        </section>
        <section class="bonpost container">
            <div class="bottom-post row">
                {if isset($post.author_name) && $post.author_name}
                    <div class="author">
                        {if isset($post.author_img) && $post.author_img}
                            <img class="img-responsive author"
                                src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$post.author_img|escape:'htmlall':'UTF-8'}"
                                alt="{$post.title|escape:'htmlall':'UTF-8'}" />
                        {/if}
                        <div class="author-info">
                            <p><strong style="color: #3a3a3a;">{$post.author_name|escape:'htmlall':'UTF-8'}</strong></p>
                            <p> {l s='on' mod='bonnews'} {$post.date_post|date_format|escape:'htmlall':'UTF-8'}</p>
                        </div>
                    </div>
                {/if}
                {if isset($add_sharebuttons) && $add_sharebuttons}
                    <div class="bonnews-social social-sharing">
                        <p>{l s='Share on:' mod='bonnews'}</p>
                        <ul>
                            {assign var="post_url" value="{$link->getModuleLink('bonnews', 'post', ['id_tab'=>$post.id, 'link_rewrite'=>$post.url])|escape:'htmlall':'UTF-8'}"}
                            <li class="facebook"><a target="_blank"
                                    href="https://www.facebook.com/sharer.php?u={$post_url|escape:'htmlall':'UTF-8'}"></a>
                            </li>
                            <li class="twitter"><a target="_blank"
                                    href="https://twitter.com/intent/tweet?text={$post.title|escape:'htmlall':'UTF-8'}{$post_url|escape:'htmlall':'UTF-8'}"></a>
                            </li>
                            <li class="pinterest">
                                <a target="_blank"
                                    href="https://www.pinterest.com/pin/create/button/?media={$urls.base_url|escape:'htmlall':'UTF-8'}modules/bonnews/views/img/{$post.image|escape:'htmlall':'UTF-8'}&url={$post_url|escape:'htmlall':'UTF-8'}"></a>
                            </li>
                        </ul>
                    </div>
                {/if}
            </div>
            <div class="row">
                <a class="back-posts" href="{$link->getModuleLink('bonnews', 'main')|escape:'htmlall':'UTF-8'}">
                    <i class="material-icons">&#xE314;</i>{l s='Show More News' mod='bonnews'}
                </a>
            </div>
        </section>
    {/if}
    {if isset($add_disqus) && $add_disqus && isset($disqus_name) && $disqus_name}
        <section class="disqus-post-box">
            <h3>{l s='Disqus' mod='bonnews'}</h3>
            <div id="disqus_thread"></div>
        </section>
        <script>
            {literal}
                (function() {
                    var d = document,
                        s = d.createElement('script');
                    s.src = 'https://{/literal}{$disqus_name|escape:'htmlall':'UTF-8'}{literal}.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                })();
            {/literal}
        </script>
        <noscript>{l s='Please enable JavaScript to view the' mod='bonnews'}<a
                href="https://disqus.com/?ref_noscript">{l s='comments powered by Disqus.' mod='bonnews'}</a></noscript>

        <script id="dsq-count-scr" src="//{$disqus_name|escape:'htmlall':'UTF-8'}.disqus.com/count.js" async></script>
    {/if}
{/block}