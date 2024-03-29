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
<div class="variant-links">
    {foreach from=$variants item=variant}
        <a href="{$variant.url}" class="{$variant.type}" title="{$variant.name}" {* TODO: put color in a data attribute for use with attr() as soon as browsers support it, see https://developer.mozilla.org/en/docs/Web/CSS/attr *} {if $variant.html_color_code} style="background-color: {$variant.html_color_code}" {/if} {if $variant.texture} style="background-image: url({$variant.texture})" {/if}><span class="sr-only">{$variant.name}</span></a>
    {/foreach}
    <span class="js-count count"></span>
</div>