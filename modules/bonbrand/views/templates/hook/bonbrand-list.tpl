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

    {if isset($bon_list_box) && $bon_list_box}
        {if isset($products_list->id_manufacturer) && $products_list->id_manufacturer}
            <div class="bon_manufacture_list">
            {if isset($bon_list_name) && $bon_list_name}
                <h4>
                    <a itemprop="brand" content="{$products_list->manufacturer_name|escape:'htmlall':'UTF-8'}" href="{$link->getmanufacturerLink($products_list->id_manufacturer)|escape:'html':'UTF-8'}" title="{$products_list->manufacturer_name|escape:'htmlall':'UTF-8'}">
                        {$products_list->manufacturer_name|escape:'htmlall':'UTF-8'}
                    </a>
                </h4>
            {/if}
            {if $bon_ps_version >= 1.7}
                {if isset($bon_list_image) && $bon_list_image}
                    <a itemprop="brand" content="{$products_list->manufacturer_name|escape:'htmlall':'UTF-8'}"  class="bon_manufacture_product_image" href="{$link->getmanufacturerLink($products_list->id_manufacturer)|escape:'html':'UTF-8'}" title="{$products_list->manufacturer_name|escape:'htmlall':'UTF-8'}">
                        <img src="{$img_manu_dir|escape:'htmlall':'UTF-8'}{$products_list->id_manufacturer|escape:'html':'UTF-8'}.jpg" alt="{$products_list->manufacturer_name|escape:'html':'UTF-8'}" title="{$products_list->manufacturer_name|escape:'html':'UTF-8'}" />
                    </a>
                {/if}
            {else}
                {if isset($bon_list_image) && $bon_list_image}
                    <a itemprop="brand" content="{$products_list->manufacturer_name|escape:'htmlall':'UTF-8'}" class="bon_manufacture_product_image" href="{$link->getmanufacturerLink($products_list->id_manufacturer)|escape:'html':'UTF-8'}" title="{$products_list->manufacturer_name|escape:'htmlall':'UTF-8'}">
                        <img src="{$img_manu_dir|escape:'htmlall':'UTF-8'}{$products_list->id_manufacturer|escape:'html':'UTF-8'}-{$bon_list_type|escape:'html':'UTF-8'}.jpg" alt="{$products_list->manufacturer_name|escape:'html':'UTF-8'}" title="{$products_list->manufacturer_name|escape:'html':'UTF-8'}" />
                    </a>
                {/if}
            {/if}
            </div>
        {/if}
    {/if}



