{*
* 2015-2020 Bonpresta
*
* Bonpresta Product Video Youtube
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
* @copyright 2015-2020 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{if isset($items) && $items}
{foreach from=$items item=item name=item}
<li class="nav-item">
    {if isset($item.id_tab) && $item.id_tab}
    <a class="nav-link" data-toggle="tab" href="#tab-{$item.id_tab|escape:'htmlall':'UTF-8'}">
        {$item.title|escape:'htmlall':'UTF-8'}
    </a>
    {/if}
</li>
{/foreach}
{/if}