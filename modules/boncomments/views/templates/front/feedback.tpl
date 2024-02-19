{*
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2021 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
*}
{extends file='page.tpl'}
{block name="page_content"}
    <script type="text/javascript">
        var productcomments_controller_url = '{$boncomments_controller_url nofilter}';
        var confirm_report_message = '{l s='Are you sure that you want to report this comment?' mod='boncomments' js=1}';
        var secure_key = '{$secure_key}';
        var productcomments_url_rewrite = '{$boncomments_url_rewriting_activated}';
        var productcomment_added = '{l s='Your comment has been added!' mod='boncomments' js=1}';
        var productcomment_added_moderation = '{l s='Your comment has been submitted and will be available once approved by a moderator.' mod='boncomments' js=1}';
        var productcomment_title = '{l s='New comment' mod='boncomments' js=1}';
        var productcomment_ok = '{l s='OK' mod='boncomments' js=1}';
        var moderation_active = {$moderation_active};
    </script>
    <div id="productCommentsBlock">
        <div id="product_comments_block_tab" class="product_comment_feedback">
            {if $comments}
                {foreach from=$comments item=comment}
                    {if $comment.content}
                        <div class="comment clearfix">
                            <div class="comment_author">
                                <div class="comment_product">
                                    {assign var="pImages" value=boncomments::getImagesByID($comment.id_product, 1)}
                                    {if $pImages}
                                        {foreach from=$pImages item=image name=images}
                                            <a href="{Context::getContext()->link->getProductLink($comment.id_product)}">
                                                <img src="{Context::getContext()->link->getImageLink($comment.link_rewrite, $image, 'cart_default')}"
                                                    {if $smarty.foreach.images.first}class="current img_{$smarty.foreach.images.index}" 
                                                    {else}
                                                        class="img_{$smarty.foreach.images.index}"
                                                    style="display:none;" {/if}
                                                    alt="{$comment.name|escape:'htmlall':'UTF-8'}" />
                                            </a>
                                        {/foreach}
                                    {/if}
                                    <div class="star_content clearfix">
                                        {section name="i" start=0 loop=5 step=1}
                                            {if $comment.grade le $smarty.section.i.index}
                                                <div class="star"></div>
                                            {else}
                                                <div class="star star_on"></div>
                                            {/if}
                                        {/section}
                                    </div>
                                </div>
                                <div class="comment_author_infos">
                                    <strong>{$comment.customer_name|escape:'html':'UTF-8'}</strong><br />
                                    <em>{dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}</em>
                                </div>
                            </div>
                            <div class="comment_details">
                                <h4 class="title_block">{$comment.title}</h4>
                                <p>{$comment.content|escape:'html':'UTF-8'|nl2br nofilter}</p>
                                <ul>
                                    {if $comment.total_advice > 0}
                                        <li>{l s='%1$d out of %2$d people found this review useful.' sprintf=[$comment.total_useful,$comment.total_advice] mod='boncomments'}
                                        </li>
                                    {/if}
                                    {if $logged}
                                        {if !$comment.customer_advice}
                                            <li>{l s='Was this comment useful to you?' mod='boncomments'}
                                                <button class="usefulness_btn" data-is-usefull="1"
                                                    data-id-product-comment="{$comment.id_product_comment}">{l s='yes' mod='boncomments'}</button>
                                                <button class="usefulness_btn" data-is-usefull="0"
                                                    data-id-product-comment="{$comment.id_product_comment}">{l s='no' mod='boncomments'}</button>
                                            </li>
                                        {/if}
                                        {if !$comment.customer_report}
                                            <li><span class="report_btn"
                                                    data-id-product-comment="{$comment.id_product_comment}">{l s='Report abuse' mod='boncomments'}</span>
                                            </li>
                                        {/if}
                                    {/if}
                                </ul>
                                {hook::exec('displayProductComment', $comment) nofilter}
                            </div>
                        </div>
                    {/if}
                {/foreach}
            {else}
                <div class="alert alert-info">
                    {l s='No comments currently available' mod='boncomments'}
                </div>
            {/if}
        </div>
    </div>
    {block name='pagination'}
        {include file='_partials/pagination.tpl' pagination=$pagination}
    {/block}
{/block}