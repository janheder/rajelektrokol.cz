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

    {assign var=_counter value=0}
    {function name="menu" nodes=[] depth=0 parent=null}
    {if $nodes|count}
    <ul class="top-menu" {if $depth==0}id="top-menu" {/if} data-depth="{$depth}">
        {foreach from=$nodes item=node name=node}
        <li class="{$node.type}{if $node.current} current {/if}" id="{$node.page_identifier}">
            {assign var=_counter value=$_counter+1}
            <a class="{if $depth >= 0}dropdown-item{/if}{if $depth === 1} dropdown-submenu{/if}{if $depth < 1}{if $smarty.foreach.node.iteration == 22} category-red{/if}{/if}" href="{$node.url}" data-depth="{$depth}" {if $node.open_in_new_window} target="_blank" {/if}>
                {if {$node.page_identifier} == 'category-19'}
                <span class="label-menu-sale">{l s='Sale' d='Shop.Theme.Global'}</span>
                {/if}
                {if {$node.page_identifier} == 'category-37'}
                <span class="label-menu-hot">{l s='Hot' d='Shop.Theme.Global'}</span>
                {/if}
                {if {$node.page_identifier} == 'category-45'}
                <span class="label-menu-new">{l s='New' d='Shop.Theme.Global'}</span>
                {/if}

                {$node.label}
            </a>
            {if $node.children|count}
            {* Cannot use page identifier as we can have the same page several times *}
            {assign var=_expand_id value=10|mt_rand:100000}
            <span class="d-lg-none">
                <span data-target="#top_sub_menu_{$_expand_id}" data-toggle="collapse" class="navbar-toggler collapse-icons collapsed">
                    <i class="mercury-icon-angle-bottom add"></i>
                    <i class="mercury-icon-angle-up remove"></i>
                </span>
            </span>
            {/if}
            {if $node.children|count}
            <div {if $depth===0} class="popover sub-menu js-sub-menu collapse" {else} class="collapse  " {/if} id="top_sub_menu_{$_expand_id}">
                <div class="container d-flex">
                    {menu nodes=$node.children depth=$node.depth parent=$node}
                </div>
            </div>
            {/if}
        </li>
        {/foreach}
    </ul>
    {if $depth === 1} {hook h='displayCustomBannerMenu'}{/if}
    {/if}
    {/function}
    <div class="menu js-top-menu position-static d-none d-lg-block" id="_desktop_top_menu">
        {menu nodes=$menu.children}
        <div class="clearfix"></div>
    </div>