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

{extends file="helpers/form/form.tpl"}

{block name="field"}


    {* product select *}
    
    {if $input.type == 'select_product'}
        <div class="row">
            <div class="form-wrapper">
                <div class="form-group">
                    <div class="col-lg-2">
                        <input id="id_product" name="id_product" value="{if $fields_value.id_product}{$fields_value.id_product|escape:'html':'UTF-8'}{else}{/if}" type="hidden">
                        <input id="product_name" name="product_name" value="¤" type="hidden">
                        <div id="ajax_choose_product">
                            <div class="input-group">
                                <input type="text" id="product_autocomplete_input" name="product_autocomplete_input" />
                                <span class="input-group-addon"><i class="icon-search"></i></span>
                            </div>
                        </div>
                        <div id="divProduct">
                            {if $fields_value.id_product}
                                <div class="form-control-static">
                                    <button type="button" class="btn btn-default delProduct" name="{$fields_value.id_product|escape:'html':'UTF-8'}">
                                        <i class="icon-remove text-danger"></i>
                                    </button>
                                    <br />
                                    {$fields_value.product_name[0].name|escape:'html':'UTF-8'}
                                    <br />
                                    {assign var='id_image' value=Image::getCover($fields_value.id_product)}
                                    {if isset($id_image['id_image']) && $id_image['id_image']}
                                        <img src="{$base_dir|escape:'htmlall':'UTF-8'}{$link->getImageLink($fields_value.link_rewrite[0].link_rewrite, $id_image['id_image'], 'cart_default')|escape:'htmlall':'UTF-8'}" class="img-thumbnail img-thumbnail-tab" />
                                    {else}
                                        {if $ps_version >= 1.7}
                                            <img src="{$pr_img_dir|escape:'htmlall':'UTF-8'}{$lang_iso|escape:'htmlall':'UTF-8'}.jpg" class="img-thumbnail img-thumbnail-tab" />
                                        {else}
                                            <img src="{$base_dir|escape:'htmlall':'UTF-8'}{$link->getImageLink($fields_value.link_rewrite[0].link_rewrite, 'en-default', 'cart_default')|escape:'htmlall':'UTF-8'}" class="img-thumbnail img-thumbnail-tab" />
                                        {/if}
                                    {/if}
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
    {* categories form *}
    {if $input.type == 'link_choice'}
        <div class="wrapper">
            <div class="row">
                <div class="col-lg-1">
                    <h4 style="margin-top:5px;">{l s='Change position' d='Modules.Mainmenu.Admin'}</h4>
                    <a href="#" id="menuOrderUp" class="btn btn-default" style="font-size:20px;display:block;"><i
                            class="icon-chevron-up"></i></a><br />
                    <a href="#" id="menuOrderDown" class="btn btn-default" style="font-size:20px;display:block;"><i
                            class="icon-chevron-down"></i></a><br />
                </div>
                <div class="col-lg-4">
                    <h4 style="margin-top:5px;">{l s='Selected items' d='Modules.Mainmenu.Admin'}</h4>
                    {$selected_links}
                </div>
                <div class="col-lg-4">
                    <h4 style="margin-top:5px;">{l s='Available items' d='Modules.Mainmenu.Admin'}</h4>
                    {$choices}
                </div>

                <br />
                </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4"><a href="#" id="removeItem" style="margin-top:20px;" class="btn btn-default"><i class="icon-arrow-right"></i>
                            {l s='Remove' d='Modules.Mainmenu.Admin'}</a></div>
                    <div class="col-lg-4"><a href="#" id="addItem" style="margin-top:20px;" class="btn btn-default"><i class="icon-arrow-left"></i>
                            {l s='Add' d='Admin.Actions'}</a></div>
                </div>
        </div>
    {/if}

    {* image fields *}
    {if $input.type == 'files_lang' || $input.type == 'files_lang_sub'}
        <div class="row bonmp-files-upload">
            {foreach from=$languages item=language}
                {if $languages|count > 1}
                    <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}"
                        {if $language.id_lang !=$defaultFormLanguage}style="display:none" {/if}>
                    {/if}
                    <div class="col-lg-6">
                        <div class="dummyfile input-group">
                            <input id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}"
                                type="file"
                                name="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}"
                                class="hide-file-upload" />
                            <span class="input-group-addon">
                                <i class="icon-file"></i>
                            </span>
                            <input id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-name"
                                type="text" class="disabled" name="filename" readonly />
                            <span class="input-group-btn">
                                <button
                                    id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-selectbutton"
                                    type="button" name="submitAddAttachments" class="btn btn-default">
                                    <i class="icon-folder-open"></i>
                                    {l s='Choose a file' mod='bonmegamenu'}
                                </button>
                            </span>
                        </div>
                        {if $input.type == 'files_lang_sub'}
                            {if isset($fields[0]['form']['images'][$language.id_lang|escape:'htmlall':'UTF-8']) && $fields[0]['form']['images'][$language.id_lang|escape:'htmlall':'UTF-8']}
                                <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$fields[0]['form']['images'][$language.id_lang|escape:'htmlall':'UTF-8']}"
                                    class="img-thumbnail" />
                            {/if}
                        {else}
                            {if isset($fields[0]['form']['images'][$language.id_lang|escape:'htmlall':'UTF-8']) && $fields[0]['form']['images'][$language.id_lang|escape:'htmlall':'UTF-8']}
                                <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$fields[0]['form']['images'][$language.id_lang|escape:'htmlall':'UTF-8']}"
                                    class="img-thumbnail" />
                            {/if}
                        {/if}
                    </div>
                    {if $languages|count > 1}
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                {$language.iso_code|escape:'htmlall':'UTF-8'}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                {foreach from=$languages item=lang}
                                    <li>
                                        <a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'});"
                                            tabindex="-1">{$lang.name|escape:'htmlall':'UTF-8'}</a>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    {/if}
                    {if $languages|count > 1}
                    </div>
                {/if}
                <script>
                    $(document).ready(function() {
                        $('#{$input.name|escape:"htmlall":"UTF-8"}_{$language.id_lang|escape:"htmlall":"UTF-8"}-selectbutton').click(function(e){
                        $('#{$input.name|escape:"htmlall":"UTF-8"}_{$language.id_lang|escape:"htmlall":"UTF-8"}').trigger('click');
                    });
                    $('#{$input.name|escape:"htmlall":"UTF-8"}_{$language.id_lang|escape:"htmlall":"UTF-8"}').change(function(e){
                    var val = $(this).val();
                    var file = val.split(/[\\/]/);
                    $('#{$input.name|escape:"htmlall":"UTF-8"}_{$language.id_lang|escape:"htmlall":"UTF-8"}-name').val(file[file.length-1]);
                    });
                    });
                </script>
            {/foreach}
        </div>
    {/if}
    
    {* popup view select *}

    {if $input.type == 'radio' and $input.name == 'view_type'}
        <div class=" image-list">
            {foreach $input.values as $value}
                <div class="radio {if isset($input.class)}{$input.class|escape:'htmlall':'UTF-8'}{/if}">
                    {strip}
                        <label>
                            <input type="radio"	name="{$input.name|escape:'htmlall':'UTF-8'}" id="{$value.id|escape:'htmlall':'UTF-8'}" value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}/>
                            <img width="400px" height="auto" src="{$value.img_link|escape:'htmlall':'UTF-8'}" alt="">
                            {$value.label|escape:'htmlall':'UTF-8'}
                        </label>
                    {/strip}
                </div>
                {if isset($value.p) && $value.p}<p class="help-block">{$value.p|escape:'htmlall':'UTF-8'}</p>{/if}
            {/foreach}
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}