{*
 * 2015-2020 Bonpresta
 *
 * Bonpresta Menu with Custom Font Icons
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
 *  @copyright 2015-2020 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{extends file="helpers/list/list_content.tpl"}

{block name="td_content"}
    {if isset($params.type) && $params.type == 'box_icon'}
        <i class="icon-bonreassurance {$tr.icon|escape:'htmlall':'UTF-8'}">{if $tr.type_icon=='material_icons'}{$tr.icon|escape:'htmlall':'UTF-8'|replace:'material-icons':''}{/if}</i>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
