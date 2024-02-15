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
{block name='header_banner'}
    <div class="header-banner">
        <div class="container header-contact-info">
            <div class="d-block d-lg-none" id="_mobile_logo">
                <h1>
                    <a href="{$urls.base_url}">
                        <img class="logo" src=" {$shop.logo}" alt="{$shop.name}">
                    </a>
                </h1>
            </div>
            <div class="header-contact left-block">
                {hook h='displayBanner'}
            </div>
            <ul class="header-contact right-block">
                <li>{hook h='displayBonCallBack'}</li>
            </ul>
        </div>
    </div>
{/block}
{block name='header_top'}
    <div class="header-top">
        <div class="container revealOnScroll animated fadeInUp" data-animation="fadeInUp">
            <div class="row">
                <div class="col-12 position-static">
                    <div class="d-lg-none" id="menu-icon">
                        <svg width="20" height="20" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.10352e-05 1C6.10352e-05 0.447715 0.447776 0 1.00006 0H13.0001C13.5524 0 14.0001 0.447715 14.0001 1C14.0001 1.55228 13.5524 2 13.0001 2H1.00006C0.447776 2 6.10352e-05 1.55228 6.10352e-05 1Z" fill="#374151"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.10352e-05 6C6.10352e-05 5.44772 0.447776 5 1.00006 5H13.0001C13.5524 5 14.0001 5.44772 14.0001 6C14.0001 6.55228 13.5524 7 13.0001 7H1.00006C0.447776 7 6.10352e-05 6.55228 6.10352e-05 6Z" fill="#374151"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.10352e-05 11C6.10352e-05 10.4477 0.447776 10 1.00006 10H7.00006C7.55235 10 8.00006 10.4477 8.00006 11C8.00006 11.5523 7.55235 12 7.00006 12H1.00006C0.447776 12 6.10352e-05 11.5523 6.10352e-05 11Z" fill="#374151"/>
                        </svg>
                    </div>
                    <div class="d-none d-lg-block" id="_desktop_logo">
                        <h1>
                            <a href="{$urls.base_url}">
                                <img class="logo" src=" {$shop.logo}" alt="{$shop.name}">
                            </a>
                        </h1>
                    </div>
                    <div class="bon-nav-bar">
                        {hook h='displayBonSearch'}
                    </div>
                    <div class="bon-nav-bar right">
                        <div class="bon-search-icon">
                            <svg width="22" height="25" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00006 2C3.79092 2 2.00006 3.79086 2.00006 6C2.00006 8.20914 3.79092 10 6.00006 10C8.2092 10 10.0001 8.20914 10.0001 6C10.0001 3.79086 8.2092 2 6.00006 2ZM6.10352e-05 6C6.10352e-05 2.68629 2.68635 0 6.00006 0C9.31377 0 12.0001 2.68629 12.0001 6C12.0001 7.29583 11.5893 8.49572 10.8908 9.47653L15.7072 14.2929C16.0977 14.6834 16.0977 15.3166 15.7072 15.7071C15.3166 16.0976 14.6835 16.0976 14.293 15.7071L9.4766 10.8907C8.49578 11.5892 7.29589 12 6.00006 12C2.68635 12 6.10352e-05 9.31371 6.10352e-05 6Z" fill="#374151"/>
                            </svg>
                            {*                                <span class="icon-text">{l s='Search' d='Shop.Theme.Actions'}</span>*}
                        </div>
                        {hook h='displayTop'}
                    </div>
                </div>
            </div>
            <div id="mobile_top_menu_wrapper" class="d-block d-lg-none">
                <div class="js-top-menu mobile" id="_mobile_top_menu"></div>
                <div class="js-top-menu-bottom">
                    <div id="_mobile_currency_selector"></div>
                    <div id="_mobile_language_selector"></div>
                    <div id="_mobile_contact_link"></div>
                </div>
            </div>
        </div>
    </div>
    {hook h='displayNavFullWidth'}
{/block}