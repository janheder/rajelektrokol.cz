{*
* 2015-2022 Bonpresta
*
* Bonpresta Lookbook gallery with products and slider
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
* @copyright 2015-2022 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{extends file="helpers/form/form.tpl"}

{block name="field"}
    {if $input.name == "id_tab"}
        {if isset($fields[0]['form']['images']) && $fields[0]['form']['images']}
            <div class="bonimage-container col-lg-12" data-width="{$fields[0]['form']['images_size'][0]|escape:'htmlall':'UTF-8'}" data-height="{$fields[0]['form']['images_size'][1]|escape:'htmlall':'UTF-8'}">
                {if $role == "child"}
                    <div class="bonpoint-wrapper" style='background-image: url("{$image_baseurl|escape:'htmlall':'UTF-8'}{$fields[0]['form']['images']|escape:'htmlall':'UTF-8'}"); height: {$fields[0]['form']['images_size'][1]|escape:'htmlall':'UTF-8'}px;width:{$fields[0]['form']['images_size'][0]|escape:'htmlall':'UTF-8'}px;'>
                        <div class="bonpoint" data-top="{if isset($point_top) && $point_top}{$point_top|escape:'htmlall':'UTF-8'}{else}50{/if}" data-left="{if isset($point_left) && $point_left}{$point_left|escape:'htmlall':'UTF-8'}{else}50{/if}" style="position: absolute; top: {if isset($point_top) && $point_top}{$point_top}{else}50{/if}px;left: {if isset($point_left) && $point_left}{$point_left|escape:'htmlall':'UTF-8'}{else}50{/if}px;"></div>
                    </div>
                {/if}
            </div>
        {else}
            <div class="bonimage-container col-lg-12" style="border: none;" data-width="" data-height="">
                <p class="bonlookbook-info"><img src="{$image_baseurl|escape:'htmlall':'UTF-8'}label-warning.svg" alt="label-warning">{l s='Please add an image to the parent element so that you can mark a point on the image.' mod='bonlookbook'}</p>
                <div class="bonpoint hidden" data-top="{if isset($point_top) && $point_top}{$point_top|escape:'htmlall':'UTF-8'}{else}50{/if}" data-left="{if isset($point_left) && $point_left}{$point_left|escape:'htmlall':'UTF-8'}{else}50{/if}"></div>
            </div>
        {/if}
    {elseif $input.type == 'files_lang'}
        <div class="row bonmp-files-upload">
                    <div class="{if $input.name|escape:'htmlall':'UTF-8' == "image"}col-lg-3{else}col-lg-6{/if}">
                        <div class="dummyfile input-group">
                            <input id="{$input.name|escape:'htmlall':'UTF-8'}"
                                type="file"
                                name="{$input.name|escape:'htmlall':'UTF-8'}"
                                class="hide-file-upload" />
                            <span class="input-group-addon">
                                <i class="icon-file"></i>
                            </span>
                            <input id="{$input.name|escape:'htmlall':'UTF-8'}-name"
                                type="text" class="disabled" name="filename" readonly />
                            <span class="input-group-btn">
                                <button
                                    id="{$input.name|escape:'htmlall':'UTF-8'}-selectbutton"
                                    type="button" name="submitAddAttachments" class="btn btn-default">
                                    <i class="icon-folder-open"></i>
                                    {l s='Choose a file' mod='bonlookbook'}
                                </button>
                            </span>
                        </div>
                        {if $input.name|escape:'htmlall':'UTF-8' == "image"}
                            <p>{l s='Format file .png, .jpg, .gif.' mod='bonlookbook'}</p>
                            {if isset($fields[0]['form']['images']) && $fields[0]['form']['images']}
                                <img width="100%" height="auto" src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$fields[0]['form']['images']|escape:'htmlall':'UTF-8'}" style="margin-top: 10px" alt="Boninput-img">
                            {/if}
                        {/if}
                    </div>
                <script>
                    $(document).ready(function() {
                        $('#{$input.name|escape:"htmlall":"UTF-8"}-selectbutton').click(function(e){
                        $('#{$input.name|escape:"htmlall":"UTF-8"}').trigger('click');
                    });
                    $('#{$input.name|escape:"htmlall":"UTF-8"}').change(function(e){
                    var val = $(this).val();
                    var file = val.split(/[\\/]/);
                    $('#{$input.name|escape:"htmlall":"UTF-8"}-name').val(file[file.length-1]);
                    });
                    });
                </script>
        </div>
    {elseif $input.type == 'select_product'}
        <div class="row">
            <div class="form-wrapper">
                <div class="form-group">
                    <div class="col-lg-2" style="margin-top: -14px;">
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
        {$smarty.block.parent}
{/block}