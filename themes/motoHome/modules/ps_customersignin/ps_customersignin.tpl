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
    <div id="_desktop_user_info">
        <div class="user-info">
            {if $logged}
                <a href="{$my_account_url}" rel="nofollow">
                    {hook h='displayBonLogFacebookImg'}
                </a>
                <a class="account bon-tooltip" href="{$my_account_url}" rel="nofollow">
                    <svg width="22" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.9999 10.4C14.6508 10.4 16.7999 8.25095 16.7999 5.59999C16.7999 2.94902 14.6508 0.799988 11.9999 0.799988C9.3489 0.799988 7.19987 2.94902 7.19987 5.59999C7.19987 8.25095 9.3489 10.4 11.9999 10.4Z" fill="#3a3a3a"/>
                        <path d="M0.799866 24.8C0.799866 18.6144 5.81428 13.6 11.9999 13.6C18.1855 13.6 23.1999 18.6144 23.1999 24.8H0.799866Z" fill="#3a3a3a"/>
                    </svg>
                </a>
            {else}
                <a class="bon-tooltip" href="{$my_account_url}" rel="nofollow">
                    <svg width="22" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.9999 10.4C14.6508 10.4 16.7999 8.25095 16.7999 5.59999C16.7999 2.94902 14.6508 0.799988 11.9999 0.799988C9.3489 0.799988 7.19987 2.94902 7.19987 5.59999C7.19987 8.25095 9.3489 10.4 11.9999 10.4Z" fill="#3a3a3a"/>
                        <path d="M0.799866 24.8C0.799866 18.6144 5.81428 13.6 11.9999 13.6C18.1855 13.6 23.1999 18.6144 23.1999 24.8H0.799866Z" fill="#3a3a3a"/>
                    </svg>
            {/if}
            <div class="bon-login-popup">
                <div class="bon-login-popup-button">
                    {if $logged}
                        <a class="bon-logout btn btn-primary" href="{$logout_url}" rel="nofollow">
                            {l s='Sign out' d='Shop.Theme.Actions'}
                        </a>
                    {else}
                        <a class="bon-login btn btn-primary" href="{$my_account_url}" rel="nofollow">{l s='Sign in'
                            d='Shop.Theme.Actions'}
                        </a>
                        <a class="bon-login btn btn-primary" href="{$urls.pages.register}" rel="nofollow">{l s='Create
                            account' d='Shop.Theme.Actions'}
                        </a>
                        {hook h='displayBonLogFacebook'}
                    {/if}
                </div>

            </div>
        </div>
{*        <span class="icon-text">{l s='Profile' d='Shop.Theme.Actions'}</span>*}
    </div>