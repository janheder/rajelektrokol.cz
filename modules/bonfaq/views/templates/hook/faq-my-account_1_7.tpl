{*
* 2015-2017 Bonpresta
*
* Bonpresta Frequently Asked Questions
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
*  @copyright 2015-2017 Bonpresta
*  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{if $page.page_name == 'my-account'}
    <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="lnk_faq" href="{$link->getModuleLink('bonfaq', 'faq', array(), true)|escape:'htmlall':'UTF-8'}">
            <span class="link-item">
                <i class="material-icons">&#xE887;</i>
                {l s='Faq' mod='bonfaq'}
            </span>
    </a>
{else}
    <li>
        <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="lnk_faq" href="{$link->getModuleLink('bonfaq', 'faq', array(), true)|escape:'htmlall':'UTF-8'}">
        <span class="link-item">
            {l s='Faq' mod='bonfaq'}
        </span>
        </a>
    </li>
{/if}