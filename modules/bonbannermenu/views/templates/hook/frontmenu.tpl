{*
* 2015-2020 Bonpresta
*
* Bonpresta Responsive banners
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
<section id="bonbannersmenu">
    <ul class="bonbannersmenu-wrapper">
        {foreach from=$items item=item name=item}
        <li class="bonbannersmanu-item {if isset($item.specific_class) && $item.specific_class}{$item.specific_class|escape:'htmlall':'UTF-8'}{/if}">
            <a href="{$item.url|escape:'htmlall':'UTF-8'}" {if $item.blank}target="_blank" {/if}> <img class="img-responsive" src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}" alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                <div class="banner-inner">
                    {if isset($item.description) && $item.description}
                    {$item.description nofilter}
                    {/if}
                </div>
            </a>
        </li>
        {/foreach}
    </ul>
</section>
{/if}