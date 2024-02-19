{*
* 2015-2020 Bonpresta
*
* Bonpresta One Click Order
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
* @copyright 2015-2020 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}
<style>
    .btn-bonorder {
        background: {$bon_order_button|escape:'html':'UTF-8'};
    }
    .btn-bonorder:active:focus {
        box-shadow: inset 0 0 0 1px {$bon_order_button|escape:'html':'UTF-8'};
    }

    .btn-bonorder:hover,
    .btn-bonorder:active,
    .btn-bonorder:focus,
    .btn-bonorder:active:focus {
        background: {$bon_order_button_hover|escape:'html':'UTF-8'};
        border: 1px solid {$bon_order_button_hover|escape:'html':'UTF-8'};
    }
</style>

<div id="btn-bonorder">
    {if !$configuration.is_catalog}
        {block name='product_quantity'}
            <a href="#bonorder" class="btn-bonorder btn btn-primary {if !$product.add_to_cart_url}unvisible{/if}" data-toggle="modal" data-target="#bonorder-wrapper">
                <span>{l s='Buy in one click' mod='bonorder'}</span>
            </a>
        {/block}
    {/if}
</div>

<div class="modal fade" id="bonorder-wrapper" tabindex="-1" role="dialog" aria-labelledby="#bonorder-wrapper" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="popup-close" data-dismiss="modal" aria-label="Close">
            </button>
            <div class="modal-body">
                <div class="image-sticky-order">
                    <img class="js-qv-product-cover" src="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image">
                </div>
                <form method="post" class="bonorder_form" action="">
                    <fieldset>
                        <div class="clearfix">
                            <div class="form-group bon_order_box">
                                <label for="bon_order_name">{l s='Your name' mod='bonorder'}: <sup>*</sup></label>
                                <input class="form-control" type="text" id="bon_order_name" name="bon_order_name" value="{$bon_order_name|escape:'html':'UTF-8'}" />
                            </div>

                            <div class="form-group bon_order_box">
                                <label for="bon_order_phone">{l s='Your phone number' mod='bonorder'}: <sup>*</sup></label>
                                <input class="form-control" type="text" id="bon_order_phone" name="bon_order_phone" value="{$bon_order_phone|escape:'html':'UTF-8'}" />
                            </div>

                            <div class="form-group bon_order_box">
                                <label for="bon_order_email">{l s='Your email' mod='bonorder'}: <sup>*</sup></label>
                                <input class="form-control" type="text" id="bon_order_email" name="bon_order_mail" value="{$bon_order_mail|escape:'html':'UTF-8'}" />
                            </div>

                            <p class="bon_order_success alert alert-success"></p>
                            <p class="bon_order_errors alert alert-danger"></p>
                            <p class="bon_order_validate_phone alert alert-danger"></p>
                            <p class="bon_order_validate_name alert alert-danger"></p>
                            <p class="bon_order_validate_mail alert alert-danger"></p>
                        </div>
                        <div class="submit">
                            <input type="hidden" name="bon_order_id_product" value="{$bon_order_id_product|escape:'html':'UTF-8'}" />
                            <button type="submit" class="btn btn-primary button button-small bonorder_send">
                                {l s='Send' mod='bonorder'}
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>