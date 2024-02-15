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

<div class="block_newsletter wrapper revealOnScroll animated fadeInUp links" data-animation="fadeInUp">
    <div class="container d-flex justify-content-between align-content-center">
        <div class="block_newsletter-text">
            <p class="h3">{l s='Subscribe to Newsletter' d='Shop.Theme.Global'}</p>
            <p class="h4">{l s='And be aware of all discounts!' d='Shop.Theme.Global'}</p>
        </div>
        {*        <div class="title clearfix d-md-none" data-target="#footer_newsletter" data-toggle="collapse">*}
        {*            <span class="h3 text-uppercase block-newsletter-title">{l s='Newsletter Signup' d='Shop.Theme.Global'}</span>*}
        {*            <span class="float-xs-right">*}
        {*                <span class="navbar-toggler collapse-icons">*}
        {*                    <i class="mercury-icon-angle-bottom add"></i>*}
        {*                    <i class="mercury-icon-angle-up remove"></i>*}
        {*                </span>*}
        {*            </span>*}
        {*        </div>*}
        <div id="footer_newsletter" class="collapse">
            {*<p id="block-newsletter-label" class="col-md-5 col-12">{l s='Get our latest news and special sales' d='Shop.Theme.Global'}</p>*}
            {*            {if $conditions}*}
            {*            <p>{$conditions}</p>*}
            {*            {/if}*}
            {if $msg}
                <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
                    {$msg}
                </p>
            {/if}
            {if isset($id_module)}
                {hook h='displayGDPRConsent' id_module=$id_module}
            {/if}
            <form action="{$urls.pages.index}#footer" method="post">
                <div class="input-wrapper">
                    <input name="email" type="email" value="{$value}" placeholder="{l s='Email' d='Shop.Forms.Labels'}">
                    <button class="footer_newsletter-btn" name="submitNewsletter" type="submit" value="">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.67439 11.6413C7.09632 9.56819 22.7242 3.18945 22.7242 3.18945L19.6146 21.2094C19.4551 22.0865 18.4186 22.4054 17.7807 21.8473L12.9169 17.7808L9.48835 20.9702L10.0465 15.628L20.4119 5.82068L7.65446 13.7941L8.4518 18.339L5.82057 14.113L1.83386 12.8373C1.19599 12.5981 1.11625 11.8007 1.67439 11.6413Z" stroke="white" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <input type="hidden" name="action" value="0">
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>