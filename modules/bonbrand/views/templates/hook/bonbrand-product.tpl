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

{if isset($bon_display_box) && $bon_display_box}
    {if isset($product->id_manufacturer) && $product->id_manufacturer}
        <div class="bon_manufacture_product">
        {if isset($bon_display_name) && $bon_display_name}
            <h5>
                <a itemprop="brand" href="{$link->getmanufacturerLink($product->id_manufacturer)|escape:'html':'UTF-8'}" title="{$product->manufacturer_name|escape:'htmlall':'UTF-8'}">
                    {$product->manufacturer_name|escape:'htmlall':'UTF-8'}
                </a>
            </h5>
        {/if}
            {if $bon_ps_version >= 1.7}
                {if isset($bon_display_image) && $bon_display_image}
                    {if isset($manufacturer_image_url)}
                        <a itemprop="brand"  class="bon_manufacture_product_image" href="{$link->getmanufacturerLink($product->id_manufacturer)|escape:'html':'UTF-8'}" title="{$product->manufacturer_name|escape:'htmlall':'UTF-8'}">
                            <img src="{$manufacturer_image_url|escape:'html':'UTF-8'}" alt="{$product->manufacturer_name|escape:'html':'UTF-8'}" title="{$product->manufacturer_name|escape:'html':'UTF-8'}" />
                        </a>
                    {/if}
                {/if}
            {else}
                {if isset($bon_display_image) && $bon_display_image}
                    <a itemprop="brand" class="bon_manufacture_product_image" href="{$link->getmanufacturerLink($product->id_manufacturer)|escape:'html':'UTF-8'}" title="{$product->manufacturer_name|escape:'htmlall':'UTF-8'}">
                        <img src="{$img_manu_dir|escape:'htmlall':'UTF-8'}{$product->id_manufacturer|escape:'html':'UTF-8'}-{$bon_display_type|escape:'html':'UTF-8'}.jpg" alt="{$product->manufacturer_name|escape:'html':'UTF-8'}" title="{$product->manufacturer_name|escape:'html':'UTF-8'}" />
                    </a>
                {/if}
            {/if}
        </div>
    {/if}
{/if}

