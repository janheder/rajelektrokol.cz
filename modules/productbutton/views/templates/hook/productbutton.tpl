{*
* 2015-2020 Bonpresta
*
* Bonpresta Previous and Next navigation buttons to the product page
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

{if isset($configurations.status) && $configurations.status}
{if $prev_link || $next_link}
<section id="product-button" class="clearfix">
    {if $prev_link}
    <div class="next-product-button">
        <a class="btn_next" href="{$prev_link|escape:'htmlall':'UTF-8'}" id="prev_link">
            <span>
                <i class="icon-chevron-left left"></i>
                <i class="material-icons">chevron_left</i>
                {l s='Prev' mod='productbutton'}
            </span>
        </a>
        {if isset($configurations.hover) && $configurations.hover}
        <div class="product-button-hover" style="width: {$configurations.width|escape:'htmlall':'UTF-8'}px">
            {assign var='id_image' value=Image::getCover($prev_id)}
            <a href="{$prev_link|escape:'htmlall':'UTF-8'}">
                <img class="replace-2x img-responsive" src="{$link->getImageLink($prev_link_rewrite, $id_image['id_image'], 'home_default')|escape:'htmlall':'UTF-8'}" alt="{$prev_name|escape:'htmlall':'UTF-8'}" />
            </a>
            <a href="{$prev_link|escape:'htmlall':'UTF-8'}">
                <h5 class="product-name">
                    <span class="product-name">
                        {$prev_name|escape:'htmlall':'UTF-8'}
                    </span>
                </h5>
            </a>
        </div>
        {/if}
    </div>
    {/if}
    {if $next_link}
    <div class="prev-product-button">
        <a class="btn_prev" href="{$next_link|escape:'htmlall':'UTF-8'}" id="next_link">
            <span>
                {l s='Next' mod='productbutton'}
                <i class="icon-chevron-right right"></i>
                <i class="material-icons">chevron_right</i>
            </span>
        </a>
        {if isset($configurations.hover) && $configurations.hover}
        <div class="product-button-hover" style="width: {$configurations.width|escape:'htmlall':'UTF-8'}px">
            {assign var='id_image' value=Image::getCover($next_id)}
            <a href="{$next_link|escape:'htmlall':'UTF-8'}">
                <img class="replace-2x img-responsive" src="{$link->getImageLink($next_link_rewrite, $id_image['id_image'], 'home_default')|escape:'htmlall':'UTF-8'}" alt="{$next_name|escape:'htmlall':'UTF-8'}" />
            </a>
            <a href="{$next_link|escape:'htmlall':'UTF-8'}">
                <h5 class="product-name">
                    <span class="product-name">
                        {$next_name|escape:'htmlall':'UTF-8'}
                    </span>
                </h5>
            </a>
        </div>
        {/if}
    </div>
    {/if}
</section>
{/if}
{/if}