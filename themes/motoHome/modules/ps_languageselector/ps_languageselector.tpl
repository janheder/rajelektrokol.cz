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
    <div id="_desktop_language_selector">
        <div class="language-selector-wrapper">
            <div class="language-selector">
                <ul class="d-none d-lg-block">
                    {foreach from=$languages item=language}
                        <li {if $language.id_lang==$current_language.id_lang} class="current" {/if}>
                            <a href="{url entity='language' id=$language.id_lang}" data-iso-code="{$language.iso_code}">
                                <img src="{$urls.img_lang_url}{$language.id_lang}.jpg" alt="{$language.iso_code}" />
                            </a>
                        </li>
                    {/foreach}
                </ul>
                <select class="link d-lg-none">
                    {foreach from=$languages item=language}
                        <option value="{url entity='language' id=$language.id_lang}" {if $language.id_lang==$current_language.id_lang} selected="selected" {/if} data-iso-code="{$language.iso_code}">
                            {$language.name_simple}
                        </option>
                    {/foreach}
                </select>
            </div>
        </div>
    </div>