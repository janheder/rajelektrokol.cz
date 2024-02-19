{*
* 2015-2020 Bonpresta
*
* Bonpresta Free Shipping Notice
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
{if $items && isset($items)}
    <div id="bon_ship" class="bon_ship_{$front_class} bon-shipping active" style="background: {$front_background|escape:'htmlall':'UTF-8'}; opacity: {$front_opacity|escape:'htmlall':'UTF-8'}">

    {if $items[0].description && isset($items[0].description)}
    <div class="bon_free_ship">
        {$items[0].description nofilter}<span id="close_bon_ship" class="bon-shipping-close"></span>
    </div>
    {/if}

</div>
{/if}