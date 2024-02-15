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

<div data-animation="fadeInUp" class="revealOnScroll block-contact col-md-3 links wrapper animated fadeInUp">
    <a class="block-contact-logo d-none d-md-block" href="{$urls.base_url}">
        <img class="logo" src="{$shop.logo}" alt="{$shop.name}">
        {* <img class="logo" src="{$urls.base_url}/img/footer_logo.png" alt="{$shop.name}"> *}
    </a>
    <div class="title clearfix d-block d-md-none" data-target="#footer_contact" data-toggle="collapse">
        <span class="h3 block-newsletter-title">{l s='Store information'
                d='Shop.Theme.Global'}</span>
        <span class="float-xs-right">
            <span class="navbar-toggler collapse-icons">
                <i class="mercury-icon-angle-bottom add"></i>
                <i class="mercury-icon-angle-up remove"></i>
            </span>
        </span>
    </div>
    <div id="footer_contact" class="collapse">
        <ul>
            {if $contact_infos.address}
                <li>
                    <svg width="20" height="20">
                        <use xlink:href="{$urls.img_url}svg-icons.svg#footer-svg_address" />
                    </svg>
                    <span class="footer_adsress">{$contact_infos.address.formatted nofilter}</span>
                </li>
            {/if}
            {if $contact_infos.phone}
                <li>
                    <svg width="20" height="20">
                        <use xlink:href="{$urls.img_url}svg-icons.svg#footer-svg_phone" />
                    </svg>
                    <a href="tel:{$contact_infos.phone}" class="footer_phone">{$contact_infos.phone}</a>
                </li>
            {/if}
            {if $contact_infos.fax}
                <li>
                    <svg width="20" height="20">
                        <use xlink:href="{$urls.img_url}svg-icons.svg#footer-svg_fax" />
                    </svg>
                    <a href="tel:{$contact_infos.fax}" class="footer_fax">{$contact_infos.fax}</a>
                </li>
            {/if}
            {if $contact_infos.email}
                <li>
                    <svg width="20" height="17">
                        <use xlink:href="{$urls.img_url}svg-icons.svg#footer-svg_email" />
                    </svg>
                    <a href="mailto:{$contact_infos.email}" class="footer_email">{$contact_infos.email}</a>
                </li>
            {/if}
        </ul>
    </div>
</div>