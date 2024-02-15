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
* @author PrestaShop SA <contact@prestashop.com>
    * @copyright 2007-2020 PrestaShop SA
    * @license https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
    * International Registered Trademark & Property of PrestaShop SA
    *}
<div class="footer-container {if $page.page_name == 'product'}custom-footer{/if}">
    <div class="container">
        <div class="row">
            {block name='hook_footer'}
                {hook h='displayFooter'}
            {/block}
        </div>
        <div class="row">
            {block name='hook_footer_after'}
                {hook h='displayFooterAfter'}
            {/block}
        </div>
        <div class="app-stores d-none">
            <a class="app-store" href="{$urls.base_url}">
                <img class="" src="{$urls.css_url|replace:'css/':''}img/sample-1.png" alt="app-store">
            </a>
            <a class="google-play" href="{$urls.base_url}">
                <img class="" src="{$urls.css_url|replace:'css/':''}img/sample-2.png" alt="google-play">
            </a>
        </div>
    </div>
</div>
            {*
<div class="footer-container-bottom">
    <div class="container">
        <div class="row">
            {block name='copyright_link'}
                <div class="col-sm-12 col-md-6 revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                    <a class="_blank" href="http://www.prestashop.com" target="_blank">
                        {l s='%copyright% %year% - Ecommerce software by %prestashop%' sprintf=['%prestashop%' => 'PrestaShop™', '%year%' => 'Y'|date, '%copyright%' => '©'] d='Shop.Theme.Global'}
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                    <div class="footer-payment d-flex align-items-center justify-content-center justify-content-md-end">
                        <img src="{$urls.css_url|replace:'css/':''}img/payment_icons.png" alt="{l s='Payment' d='Shop.Theme.Actions'}" />
                        <p class="footer-payment-title">{l s='Follow us:' d='Shop.Theme.Global'} {hook h="displayFooter" mod="ps_socialfollow"}</p>
                    </div>
                </div>
            {/block}
        </div>
    </div>
</div>
*}