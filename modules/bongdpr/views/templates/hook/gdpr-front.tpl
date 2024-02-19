{*
* 2015-2020 Bonpresta
*
* Bonpresta GDPR EU Cookie Law Banner
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
<div id="bongdpr" class="bongdpr_{$front_class|escape:'htmlall':'UTF-8'} bongdpr bongdpr_style_2" style="background: {$front_background|escape:'htmlall':'UTF-8'}; opacity: {$front_opacity|escape:'htmlall':'UTF-8'};{if $front_position == 'top'}top:0;{else}bottom:0;{/if}">
    {if $items[0].description && isset($items[0].description)}
    <div class="container-fluid">
        <div class="row">
            <div class="bongdpr_box">
                {$items[0].description nofilter}
                <div class="bongdpr-footer">
                    <a href="{$items[0].link nofilter}">{l s='privacy police' mod='bongdpr'}</a>
                    <span id="button_gdpr" class="bongdpr-button">
                        <span>{l s='ACCEPT' mod='bongdpr'}</span>
                        <i class="material-icons">done</i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    {/if}
</div>
{/if}