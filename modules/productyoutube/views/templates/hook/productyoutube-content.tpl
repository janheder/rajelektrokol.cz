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
{if isset($item.title) && $item.title}
{if isset($item.id_tab) && $item.id_tab}
<div id="tab-{$item.id_tab|escape:'htmlall':'UTF-8'}" class="tab-pane fade in revealOnScroll animated fadeInUp">
    <div class="box-video">
        {if isset($item.image) && $item.image}
        <div class="bg-video" style="background-image: url({$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'});">
            <div class="bt-play">{l s='Play' mod='productyoutube'}</div>
        </div>
        {/if}
        <div class="video-container">
            <iframe src="https://www.youtube.com/embed/{$item.url|escape:'htmlall':'UTF-8'}?rel=0&amp;fs=0&amp;iv_load_policy=3&amp;modestbranding=1&amp;controls=0&amp;" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
        </div>
    </div>
    <div class="rte">{$item.description nofilter}</div>
</div>
{/if}
{/if}
{/foreach}
{/if}