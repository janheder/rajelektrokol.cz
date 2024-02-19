{*
 * 2015-2020 Bonpresta
 *
 * Bonpresta Brand Manager
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

{if $manufacturers}
    <div id="bon_manufacturers_block" class="spaced-section clearfix col-12">
        <ul class="{if !$display_caroucel}row {else}bonbrand-slider{/if}">
            {foreach from=$manufacturers item=manufacturer name=manufacturers}
                {if $smarty.foreach.manufacturers.iteration <= $nb_display}
                    <li class="manufacturer_item revealOnScroll animated zoomIn {if !$display_caroucel}col-xs-6 col-sm-3{/if}" data-animation="zoomIn">
                        {if isset($display_name) && $display_name}
                            <a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}" title="{l s='More about %s' sprintf=[$manufacturer.name] mod='bonbrand'}">
                               {$manufacturer.name|escape:'html':'UTF-8'}
                            </a>
                        {/if}
                        {if isset($display_image) && $display_image}
                            <a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}" title="{l s='More about %s' sprintf=[$manufacturer.name] mod='bonbrand'}">
                                <img class="img-responsive" src="{$img_manu_dir|escape:'html':'UTF-8'}{$manufacturer.id_manufacturer|escape:'html':'UTF-8'}-{$image_type|escape:'html':'UTF-8'}.jpg" alt="{$manufacturer.image|escape:'html':'UTF-8'}" />
                            </a>
                        {/if}
                    </li>
                {/if}
            {/foreach}
        </ul>
    </div>
    <script type="text/javascript">
       var m_display_caroucel = {$display_caroucel|intval};
    </script>
    {if $display_caroucel}
        <script type="text/javascript">
            var m_caroucel_nb = {$caroucel_nb|intval};
            var m_caroucel_loop = {$caroucel_loop|intval};
            var m_caroucel_nav = {$caroucel_nav|intval};
            var m_caroucel_dots = {$caroucel_dots|intval};
        </script>
    {/if}
{/if}