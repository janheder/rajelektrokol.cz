{*
* 2015-2020 Bonpresta
*
* Bonpresta Product Trends
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

{extends file="helpers/list/list_content.tpl"}

{block name="td_content"}
    {if isset($params.type) && $params.type == 'block_image'}
        {assign var='id_image' value=Image::getCover($tr.id_product)}
        {if isset($id_image['id_image']) && $id_image['id_image']}
            <img src="{$base_dir|escape:'htmlall':'UTF-8'}{$link->getImageLink($tr.link_rewrite, $id_image['id_image'], 'home_default')|escape:'htmlall':'UTF-8'}" class="img-thumbnail img-thumbnail-tab" />
        {else}
            {if $ps_version >= 1.7}
                <img src="{$pr_img_dir|escape:'htmlall':'UTF-8'}{$lang_iso|escape:'htmlall':'UTF-8'}.jpg" class="img-thumbnail img-thumbnail-tab" />
            {else}
                <img src="{$base_dir|escape:'htmlall':'UTF-8'}{$link->getImageLink($tr.link_rewrite, 'en-default', 'cart_default')|escape:'htmlall':'UTF-8'}" class="img-thumbnail img-thumbnail-tab" />
            {/if}
        {/if}
    {else}
        {$smarty.block.parent}
    {/if}
{/block}