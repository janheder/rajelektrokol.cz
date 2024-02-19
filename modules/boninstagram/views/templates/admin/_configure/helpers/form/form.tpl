{*
* 2015-2022 Bonpresta
*
* Bonpresta Instagram Gallery Feed Photos & Videos User
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
* @copyright 2015-2022 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{extends file="helpers/form/form.tpl"}

{block name="field"}
    {if $input.name == 'BONINSTAGRAM_ACCESS_TOKEN'}
        {$smarty.block.parent}
        <div class="footer_btn">
            <a target="_blank" class="btn btn-default" href="https://theme.bonpresta.com/documentation/#bon-instagram-token" type='button'>
                <span>{l s='How to get a token?' mod='boninstagram'}</span>
            </a>
            <button class="btn btn-default" onclick='refreshToken("{$linkAjax}");' type='button'>
                <span>{l s='Refresh Token' mod='boninstagram'}</span>
            </button>
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}