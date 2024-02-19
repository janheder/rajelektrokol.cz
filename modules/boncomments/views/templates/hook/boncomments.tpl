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
* @author PrestaShop SA <contact@prestashop.com>
    * @copyright 2007-2021 PrestaShop SA
    * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
    * International Registered Trademark & Property of PrestaShop SA
    *
    *}

<script type="text/javascript">
    var productcomments_controller_url = '{$productcomments_controller_url nofilter}';
    var confirm_report_message = '{l s='Are you sure that you want to report this comment ? ' mod='boncomments' js=1}';
    var secure_key = '{$secure_key}';
    var productcomments_url_rewrite = '{$productcomments_url_rewriting_activated}';
    var productcomment_added = '{l s='Your comment has been added!' mod='boncomments' js=1}';
    var productcomment_added_moderation = '{l s='Your comment has been submitted and will be available once approved by a moderator.' mod='boncomments' js=1}';
    var productcomment_title = '{l s='New comment ' mod='boncomments' js=1}';
    var productcomment_ok = '{l s='OK ' mod='boncomments' js=1}';
    var moderation_active = {$moderation_active};
</script>

<div id="productCommentsBlock">
    <div class="tabs">
        <div id="new_comment_form_ok" class="alert alert-success" style="display:none;padding:15px 25px"></div>
        <div id="product_comments_block_tab">
            {if !$comments}
                <span class="no-reviews">{l s='This product has no reviews!' mod='boncomments'}</span>
            {/if}
            {if $comments}
                {foreach from=$comments item=comment}
                    {if $comment.content}
                        <div class="comment clearfix">
                            <div class="comment_author">
                                <div class="star_content clearfix">
                                    {section name="i" start=0 loop=5 step=1}
                                        {if $comment.grade le $smarty.section.i.index}
                                            <div class="star"></div>
                                        {else}
                                            <div class="star star_on"></div>
                                        {/if}
                                    {/section}
                                </div>
                                <div class="comment_author_infos">
                                    <strong itemprop="author">{$comment.customer_name|escape:'html':'UTF-8'}</strong><br />
                                    <em>{$comment.date_add|date_format}</em>
                                    <meta itemprop="datePublished"
                                        content="{dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}" />
                                </div>
                            </div>

                            <div class="comment_details">
                                <h4 class="title_block">{$comment.title}</h4>
                                <p>{$comment.content|escape:'html':'UTF-8'|nl2br nofilter}</p>
                                <ul>
                                    {if !$logged}
                                        <li>
                                            {assign var='total_advice_my' value=$comment.total_advice - $comment.total_useful}
                                            <span class="yes" data-toggle="modal" data-target="#modal-logged">{l s='%1$d'
                                                    sprintf=[$comment.total_useful,$comment.total_advice] mod='boncomments'}</span>
                                            <span class="no" data-toggle="modal" data-target="#modal-logged">{l s='%2$d'
                                                    sprintf=[$comment.total_useful,$total_advice_my] mod='boncomments'}</span>
                                        </li>

                                        <div class="modal fade" id="modal-logged" tabindex="-1" role="dialog"
                                            aria-labelledby="modal-logged" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <span>{l s='In order to write a comment please log in.'
                                                                mod='boncomments'}</span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="popup-close" data-dismiss="modal"></button>
                                                        <button type="button" class="btn btn-primary"><a
                                                                href="{$link->getPageLink('my-account', true)}">{l s='Login'
                                                                    mod='boncomments'}</a></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    {/if}

                                    {if $logged}
                                        {if !$comment.customer_advice}
                                            <li>{l s='' mod='boncomments'}
                                                <button class="usefulness_btn yes" data-is-usefull="1"
                                                    data-id-product-comment="{$comment.id_product_comment}">{l s=''
                                                        mod='boncomments'}</button>
                                                <button class="usefulness_btn no" data-is-usefull="0"
                                                    data-id-product-comment="{$comment.id_product_comment}">{l s=''
                                                        mod='boncomments'}</button>
                                            </li>
                                        {/if}
                                        {if !$comment.customer_report}
                                            <li><span class="report_btn" data-id-product-comment="{$comment.id_product_comment}">{l s=''
                                                        mod='boncomments'}</span></li>
                                        {/if}
                                    {/if}
                                </ul>
                                {hook::exec('displayProductComment', $comment) nofilter}
                            </div>
                        </div>
                    {/if}
                {/foreach}
            {else}
            {/if}
        </div>
        <div class="clearfix pull-right">

            {if ($too_early == false AND ($logged OR $allow_guests))}
                <a id="write-review-anchor" class="open-comment-form btn-primary" href="#new_comment_form" data-toggle="modal"
                    data-target="#new_comment_form">{l s='Write your review' mod='boncomments'}</a>
            {/if}
        </div>
    </div>

    {if isset($productcomments_product) && $productcomments_product}
        <div id="new_comment_form" class="modal fade" aria-hidden="true">
            <form id="id_new_comment_form" action="#" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="popup-close" data-dismiss="modal" aria-label="Close"></button>
                    <h2 class="title">{l s='Write your review' mod='boncomments'}</h2>
                    <div class="row">
                        <div class="hidden-sm-down col-md-6">
                            {if isset($productcomments_product) && $productcomments_product}
                                <img src="{$productcomment_cover_image}" alt="{$productcomments_product->name}"
                                    title="{$productcomments_product->name}">
                                <div class="product clearfix">
                                    <div class="product_desc">
                                        <p class="product_name">
                                            <strong>{if
                                                    isset($productcomments_product->name)}{$productcomments_product->name}{elseif
                                                isset($productcomments_product.name)}{$productcomments_product.name}{/if}</strong>
                                    </p>
                                    {if
                                        isset($productcomments_product->description_short)}{$productcomments_product->description_short
                                        nofilter}{elseif
                                        isset($productcomments_product.description_short)}{$productcomments_product.description_short
                                    nofilter}{/if}
                            </div>
                        </div>
                        {/if}
                    </div>
                    <div class="col-sm-12 col-12 col-md-6">
                        <div class="new_comment_form_content">
                            {* <h2>{l s='Write your review' mod='boncomments'}</h2>*}
                            {if $criterions|@count > 0}
                                <ul id="criterions_list">
                                    {foreach from=$criterions item='criterion'}
                                        <li>

                                            <label>{$criterion.name|escape:'html':'UTF-8'}</label>
                                            <div class="star_content">
                                                <input class="star" type="radio"
                                                    name="criterion[{$criterion.id_product_comment_criterion|round}]"
                                                    value="1" />
                                                <input class="star" type="radio"
                                                    name="criterion[{$criterion.id_product_comment_criterion|round}]"
                                                    value="2" />
                                                <input class="star" type="radio"
                                                    name="criterion[{$criterion.id_product_comment_criterion|round}]"
                                                    value="3" />
                                                <input class="star" type="radio"
                                                    name="criterion[{$criterion.id_product_comment_criterion|round}]"
                                                    value="4" />
                                                <input class="star" type="radio"
                                                    name="criterion[{$criterion.id_product_comment_criterion|round}]"
                                                    value="5" checked="checked" />
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    {/foreach}
                                </ul>
                            {/if}
                            <label for="comment_title">{l s='Title for your review' mod='boncomments'}<sup
                                    class="required">*</sup></label>
                            <input id="comment_title" name="title" type="text" value="" />

                            <label for="content">{l s='Your review' mod='boncomments'}<sup
                                    class="required">*</sup></label>
                            <textarea id="content" name="content"></textarea>

                            {if $allow_guests == true && !$logged}
                                <label>{l s='Your name' mod='boncomments'}<sup class="required">*</sup></label>
                                <input id="commentCustomerName" name="customer_name" type="text" value="" />
                            {/if}

                            <div id="new_comment_form_footer">
                                <input id="id_product_comment_send" name="id_product" type="hidden"
                                    value='{$id_product_comment_form}' />

                                {*{if $PRODUCT_COMMENTS_GDPR == 1}
                                    {literal}
                                    <input
                                        onchange="if($(this).is(':checked')){$('#submitNewMessage').removeClass('gdpr_disabled'); $('#submitNewMessage').removeAttr('disabled'); rebindClickButton();}else{$('#submitNewMessage').addClass('gdpr_disabled'); $('#submitNewMessage').off('click'); $('#submitNewMessage').attr('disabled', 1); }"
                                        id="gdpr_checkbox" type="checkbox">
                                    {/literal}
                                    {l s='I accept ' mod='boncomments'} <a target="_blank"
                                        href="{$link->getCmsLink($PRODUCT_COMMENTS_GDPRCMS)}">{l s='privacy policy'
                                        mod='boncomments'}</a> {l s='rules' mod='boncomments'}
                                    {/if}*}
                                    <div id="new_comment_form_error" class="error" style="display:none">
                                        <ul></ul>
                                    </div>
                                    <p class="fr">
                                        <a class="btn btn-secondary" href="#"
                                            onclick="$('#new_comment_form').modal('hide');">{l s='Cancel'
                                                mod='boncomments'}</a>
                                        <button class="btn btn-primary" id="submitNewMessage" name="submitMessage"
                                            type="submit">{l s='Send' mod='boncomments'}</button>&nbsp;
                                    </p>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form><!-- /end new_comment_form_content -->
        </div>
    {/if}
</div>