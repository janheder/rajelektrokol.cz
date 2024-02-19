{*
 * 2015-2021 Bonpresta
 *
 * Bonpresta Customer Reassurance With Icons
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
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{if isset($items) && $items}
    <section id="bonreassurance">
        <div class="container">
            <ul
                class="{if !$display_carousel && $page.page_name == 'index'}bonreassurance-wrapper {else}slick-carousel-bonreassurance {/if}{if $page.page_name != 'index'}vertical {else}horizontal{/if}">
                {foreach from=$items item=item name=item}
                    {if $smarty.foreach.item.iteration <= $limit}
                        <li
                            class="{if !$display_carousel && $page.page_name == 'index'}bonreassurance-item{/if}{if isset($item.specific_class) && $item.specific_class} {$item.specific_class|escape:'htmlall':'UTF-8'}{/if}">
                            {if isset($item.url) && $item.url}
                                <a class="link-bonreassurance" href="{$item.url|escape:'htmlall':'UTF-8'}">
                                    {if isset($item.icon) && $item.icon}
                                        <div class="box-icon">
                                            <i {if isset($item.font_color) && $item.font_color && isset($item.font_size) && $item.font_size}
                                                    style="color: {$item.font_color|escape:'htmlall':'UTF-8'}; font-size: {$item.font_size|escape:'htmlall':'UTF-8'}px;"
                                                {/if}
                                                class="{$item.icon|escape:'htmlall':'UTF-8'}">{if $item.type_icon=='material_icons'}{$item.icon|escape:'htmlall':'UTF-8'|replace:'material-icons':''}{/if}</i>
                                        </div>
                                    {/if}
                                    {if isset($item.description) && $item.description}
                                        <div class="box-content">
                                            {$item.description nofilter}
                                        </div>
                                    {/if}
                                </a>
                            {/if}
                        </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    </section>
{/if}