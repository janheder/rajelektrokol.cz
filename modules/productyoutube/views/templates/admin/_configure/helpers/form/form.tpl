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

{extends file="helpers/form/form.tpl"}
{block name="field"}
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
    {if $input.type == 'files_lang'}
        <div class="row">
            {foreach from=$languages item=language}
                {if $languages|count > 1}
                    <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang !=$defaultFormLanguage}style="display:none" {/if}>
                    {/if}
                    <div class="col-lg-6">
                        <div class="dummyfile input-group">
                            <input id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" type="file" name="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="hide-file-upload" />
                            <span class="input-group-addon">
                                <i class="icon-file"></i>
                            </span>
                            <input id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-name" type="text" class="disabled" name="filename" readonly />
                            <span class="input-group-btn">
                                <button id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
                                    <i class="icon-folder-open"></i>
                                    {l s='Choose a file' mod='productyoutube'}
                                </button>
                            </span>
                        </div>
                        {if isset($fields[0]['form']['images'])}
                            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$fields[0]['form']['images'][$language.id_lang|escape:'htmlall':'UTF-8']}" class="img-thumbnail" />
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
                                        <a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'});" tabindex="-1">{$lang.name|escape:'htmlall':'UTF-8'}</a>
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
    {$smarty.block.parent}
{/block}