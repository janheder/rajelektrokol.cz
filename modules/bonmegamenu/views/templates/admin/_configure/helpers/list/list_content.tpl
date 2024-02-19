{*
* Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
*}

{extends file="helpers/list/list_content.tpl"}

{block name="td_content"}
    {if isset($params.type) && $params.type == 'box_image'}
        {if $tr['content_type'] == "banner" || $tr['content_type'] == "background_image"}
            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$tr.image|escape:'htmlall':'UTF-8'}" class="img-bonmegamenu" />
        {elseif $tr['content_type'] == "video"}
            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}video.png" class="img-bonmegamenu" />
        {elseif $tr['content_type'] == "category_image"}
            {assign var='link_rewrite' value=Category::getLinkRewrite($tr.id_category|replace:'category-':'', $id_language)}
            <img src="{$base_dir|escape:'htmlall':'UTF-8'}{$link->getCatImageLink($link_rewrite, $tr.id_category|replace:'category-':'')|escape:'html':'UTF-8'}" class="img-bonmegamenu"/>
        {/if}
    {elseif isset($params.type) && $params.type == 'block_image'}
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
    {elseif isset($params.type) && $params.type == 'view_type'}
        {if $tr['view_type'] == "type_1"}
            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}view_type_1.png" class="img-bonmegamenu" />
        {elseif $tr['view_type'] == "type_2"}
            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}view_type_2.png" class="img-bonmegamenu" />
        {elseif $tr['view_type'] == "type_3"}
            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}view_type_3.png" class="img-bonmegamenu" />
        {elseif $tr['view_type'] == "type_4"}
            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}view_type_4.png" class="img-bonmegamenu" />
        {/if}
    {else}
        {$smarty.block.parent}
    {/if}
{/block}