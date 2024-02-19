{*
* 2015-2021 Bonpresta
*
* Bonpresta Bonask
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
{if isset($product)}
    <div class="modal fade" id="bonask-wrapper" tabindex="-1" role="dialog" aria-labelledby="#bonask-wrapper"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="block-ask" role="document">
            <div class="modal-content">
                <h2 class="title">{l s='Write your question' mod='bonask'}</h2>
                <button type="button" class="popup-close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="image-sticky-ask">
                        <img class="js-qv-product-cover"
                             src="{if $product.cover.bySize.large_default.url == ""}{$urls.no_picture_image.bySize.home_default.url}{else}{$product.cover.bySize.large_default.url|escape:'html':'UTF-8'}{/if}"
                             alt="{$product.cover.legend|escape:'html':'UTF-8'}"
                             title="{$product.cover.legend|escape:'html':'UTF-8'}" style="width:100%;" itemprop="image">
                    </div>
                    <form method="post" class="bonask_form" action="#">
                        <fieldset>
                            <div class="clearfix">
                                <div class="form-group bon_ask_box">
                                    <label for="bon_ask_name">{l s='Your name' mod='bonask'}: <sup>*</sup></label>
                                    <input class="form-control" type="text" id="bon_ask_name" name="bon_ask_name"
                                           value="{$bon_ask_name|escape:'html':'UTF-8'}"/>
                                </div>
                                <div class="form-group bon_ask_box">
                                    <label for="bon_ask_phone">{l s='Your phone number' mod='bonask'}:
                                        <sup>*</sup></label>
                                    <input class="form-control" type="text" id="bon_ask_phone" name="bon_ask_phone"
                                           value="{$bon_ask_phone|escape:'html':'UTF-8'}"/>
                                </div>
                                <div class="form-group bon_ask_box">
                                    <label for="bon_ask_email">{l s='Your email' mod='bonask'}: <sup>*</sup></label>
                                    <input class="form-control" type="text" id="bon_ask_email" name="bon_ask_mail"
                                           value="{$bon_ask_mail|escape:'html':'UTF-8'}"/>
                                </div>
                                <div class="form-group bon_ask_box">
                                    <label for="bon_ask_question">{l s='Your question' mod='bonask'}: <sup>*</sup></label>
                                    <textarea class="bon_ask_question" id="bon_ask_question"
                                              name="bon_ask_question"></textarea>
                                </div>
                                <p class="bon_ask_success"></p>
                                <div class="submit">
                                    <input type="hidden" name="bon_ask_id_product"
                                           value="{$bon_ask_id_product|escape:'html':'UTF-8'}"/>
                                    <button type="submit" class="btn btn-primary button button-small bonask_send">
                                        {l s='Send' mod='bonask'}
                                    </button>
                                </div>
                            </div>

                        </fieldset>

                    </form>
                </div>
            </div>
        </div>
    </div>
{/if}