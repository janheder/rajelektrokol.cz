{**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<div id="_desktop_cart">
    <div class="blockcart cart-preview {if $cart.products_count > 0}active{else}inactive{/if}" data-refresh-url="{$refresh_url}">
        <div class="header">
            {hook h='displayBonCart'}
            <a class="bon-tooltip" rel="nofollow" href="{$cart_url}">
                <svg width="22" height="25" viewBox="0 0 26 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.79983 0.600006C0.916174 0.600006 0.199829 1.31635 0.199829 2.20001C0.199829 3.08366 0.916174 3.80001 1.79983 3.80001H3.75059L4.23948 5.75559C4.24461 5.77821 4.25022 5.80063 4.2563 5.82287L6.42787 14.5091L4.99975 15.9373C2.98387 17.9531 4.41159 21.4 7.26249 21.4H20.9998C21.8834 21.4 22.5997 20.6837 22.5997 19.8C22.5997 18.9164 21.8834 18.2 20.9998 18.2L7.26249 18.2L8.86249 16.6H19.3998C20.0059 16.6 20.5599 16.2576 20.8309 15.7155L25.6309 6.11555C25.8789 5.61957 25.8524 5.03054 25.5609 4.55884C25.2693 4.08713 24.7544 3.80001 24.1998 3.80001H7.04907L6.55206 1.81195C6.37399 1.09968 5.73402 0.600006 4.99983 0.600006H1.79983Z" fill="#3a3a3a"/>
                    <path d="M22.5998 25.4C22.5998 26.7255 21.5253 27.8 20.1998 27.8C18.8743 27.8 17.7998 26.7255 17.7998 25.4C17.7998 24.0745 18.8743 23 20.1998 23C21.5253 23 22.5998 24.0745 22.5998 25.4Z" fill="#3a3a3a"/>
                    <path d="M7.39983 27.8C8.72531 27.8 9.79983 26.7255 9.79983 25.4C9.79983 24.0745 8.72531 23 7.39983 23C6.07435 23 4.99983 24.0745 4.99983 25.4C4.99983 26.7255 6.07435 27.8 7.39983 27.8Z" fill="#3a3a3a"/>
                </svg>
                <span class="cart-products-count">{$cart.products_count}</span>
            </a>
        </div>
    </div>
{*    <span class="icon-text">{l s='Cart' d='Shop.Theme.Actions'} <span>{$cart.totals.total.value}</span></span>*}
</div>