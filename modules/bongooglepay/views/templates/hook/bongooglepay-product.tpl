{*
 * 2015-2021 Bonpresta
 *
 * Bonpresta Google Pay
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
 *  @author    Bonpresta
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}
 
{if $product.add_to_cart_url}
    <input type="hidden" id="price_bongooglepay" data-price="{math equation=$product.quantity_wanted*$product.price_amount}"
        value="{$product.quantity_wanted|escape:'htmlall':'UTF-8'}" min="{$product.minimal_quantity|escape:'htmlall':'UTF-8'}">
    <input type="hidden" id="currency_bongooglepay" data-currency="{$currency.iso_code|escape:'htmlall':'UTF-8'}">
    <div id="bon-google-checkout">
    </div>
{/if}