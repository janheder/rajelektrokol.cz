{*
* 2015-2020 Bonpresta
*
* Bonpresta Product Video Youtube
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
{foreach from=$items item=item name=item}
<section class="page-product-box">
    {if isset($item.title) && $item.title}
    <h3 class="page-product-heading">{$item.title|escape:'htmlall':'UTF-8'}</h3>
    {/if}
    <div class="box-video">
        {if isset($item.image) && $item.image}
        <div class="bg-video" style="background-image: url({$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'});">
            <div class="bt-play">{l s='Play' mod='productyoutube'}</div>
        </div>
        {/if}
        <div class="video-container">
            <iframe src="https://www.youtube.com/embed/{$item.url|escape:'htmlall':'UTF-8'}?iv_load_policy=3;controls=0;rel=0;theme={$item_theme|escape:'htmlall':'UTF-8'}&amp;loop={if isset($item_loop) && $item_loop}1{else}0{/if}&amp;rel=0&amp;showinfo={if isset($item_info) && $item_info}1{else}0{/if}&amp;controls={if isset($item_controls) && $item_controls}1{else}0{/if}" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
        </div>
    </div>
    <div class="rte">{$item.description nofilter}</div>
</section>
{/foreach}
{/if}