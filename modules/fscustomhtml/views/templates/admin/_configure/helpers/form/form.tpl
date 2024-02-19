{**
 * Copyright 2022 ModuleFactory
 *
 * @author    ModuleFactory
 * @copyright ModuleFactory all rights reserved.
 * @license   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *}

{extends file="helpers/form/form.tpl"}
{block name="input"}
    {if $input.type == 'fsch_filter'}
        <div class="fsch-filter-inputs-{$input.name|escape:'html':'UTF-8'}"></div>
        <div class="fsch-filters fsch-filters-{$input.name|escape:'html':'UTF-8'}">
            {if $fields_value[$input.name]}
            {foreach $fields_value[$input.name] as $filter_group}
                <div class="fsch-filter-group fsch-filter-group-{$input.name|escape:'html':'UTF-8'}">
                    {foreach $filter_group as $filter}
                        {include file="./filter_row.tpl" input_name=$input.name selected_type=$filter.type selected_parameter=$filter.parameter selected_condition=$filter.condition selected_value=$filter.value}
                    {/foreach}
                    <div class="form-or">
                        <div class="form-or-line-text">
                            <span>{l s='OR' mod='fscustomhtml'}</span>
                        </div>
                        <div class="form-or-line-button">
                            <a href="javascript:;" onclick="FSCH.filter.addGroupHtml('{$input.name|escape:'html':'UTF-8'}')" class="btn btn-primary">
                                {l s='+ OR' mod='fscustomhtml'}
                            </a>
                        </div>
                    </div>
                </div>
            {/foreach}
            {else}
                <div class="fsch-filter-group fsch-filter-group-{$input.name|escape:'html':'UTF-8'}">
                    {include file="./filter_row.tpl" input_name=$input.name}
                    <div class="form-or">
                        <div class="form-or-line-text">
                            <span>{l s='OR' mod='fscustomhtml'}</span>
                        </div>
                        <div class="form-or-line-button">
                            <a href="javascript:;" onclick="FSCH.filter.addGroupHtml('{$input.name|escape:'html':'UTF-8'}')" class="btn btn-primary">
                                {l s='+ OR' mod='fscustomhtml'}
                            </a>
                        </div>
                    </div>
                </div>
            {/if}
        </div>
        <div class="fsch-filter-group-clone fsch-filter-group-clone-{$input.name|escape:'html':'UTF-8'}">
            <div class="fsch-filter-group fsch-filter-group-{$input.name|escape:'html':'UTF-8'}">
                <div class="fsch-filter-group-cloned-placeholder">
                    <img src="{$fsch_module_base_url|escape:'html':'UTF-8'|fschCorrectTheMess}views/img/filter-loader.gif">
                </div>
                <div class="form-or">
                    <div class="form-or-line-text">
                        <span>{l s='OR' mod='fscustomhtml'}</span>
                    </div>
                    <div class="form-or-line-button">
                        <a href="javascript:;" onclick="FSCH.filter.addGroupHtml('{$input.name|escape:'html':'UTF-8'}')" class="btn btn-primary">
                            {l s='+ OR' mod='fscustomhtml'}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="fsch-filter-clone fsch-filter-clone-{$input.name|escape:'html':'UTF-8'}">
            <div class="form-group fsch-filter-cloned-placeholder">
                <img src="{$fsch_module_base_url|escape:'html':'UTF-8'|fschCorrectTheMess}views/img/filter-loader.gif">
            </div>
        </div>
        <script>
            var FSCH = FSCH || { };
            FSCH.filterGenerateUrl = '{$fsch_filter_generate_url|escape:'html':'UTF-8'|fschCorrectTheMess}';

            $(document).ready(function(){
                $('#{$table|escape:'html':'UTF-8'}_form').submit(function(){
                    FSCH.filter.submit('{$input.name|escape:'html':'UTF-8'}');
                });
            });
        </script>
    {elseif $input.type == 'select'}
        {if isset($input.select2) && $input.select2}
            {capture name="parent_select"}
                {$smarty.block.parent}
            {/capture}
            {$smarty.capture.parent_select|escape:'html':'UTF-8'|fschCorrectTheMess|fschRemoveClass:'fixed-width-xl'}
            <script type="text/javascript">
                $(document).ready(function(){
                    $('select#{$input.name|escape:'html':'UTF-8'}').select2({
                        escapeMarkup: function (markup) { return markup; },
                        templateResult: function(item) {
                            if (item.loading) { return item.text; }
                            return FSCH.select2.markMatch(item.text, $('.select2-search__field').val());
                        }
                    });
                });
            </script>
        {else}
            {$smarty.block.parent}
        {/if}
    {elseif $input.type == 'textarea'}
        {if isset($input.editors) && $input.editors}
            {capture name="parent_textarea"}
                {$smarty.block.parent}
            {/capture}
            {$smarty.capture.parent_textarea|escape:'html':'UTF-8'|fschCorrectTheMess|fschOnLangChange:'FSCH.helperForm.languageChanged()'}
            {if !(isset($input.lang) && $input.lang)}<br />{/if}
            <div class="btn-group" data-toggle="buttons"{if isset($input.hide_selector) && $input.hide_selector} style="display:none;"{/if}>
                <label class="btn btn-default active" onclick="switch_editor_{$input.name|escape:'html':'UTF-8'}('none')">
                    <input type="radio" name="{$input.name|escape:'html':'UTF-8'}_editor" id="{$input.name|escape:'html':'UTF-8'}_editor_none" value="none" autocomplete="off"> {l s='Plain Text (No Editor)' mod='fscustomhtml'}
                </label>
                {if isset($input.editors.tinymce.basic) && $input.editors.tinymce.basic}
                    <label class="btn btn-default" onclick="switch_editor_{$input.name|escape:'html':'UTF-8'}('tinymce')">
                        <input type="radio" name="{$input.name|escape:'html':'UTF-8'}_editor" id="{$input.name|escape:'html':'UTF-8'}_editor_tinymce" value="tinymce" autocomplete="off"> {l s='Basic WYSIWYG editor' mod='fscustomhtml'}
                    </label>
                {/if}
                {if isset($input.editors.tinymce.advanced) && $input.editors.tinymce.advanced}
                    <label class="btn btn-default" onclick="switch_editor_{$input.name|escape:'html':'UTF-8'}('tinymceadvanced')">
                        <input type="radio" name="{$input.name|escape:'html':'UTF-8'}_editor" id="{$input.name|escape:'html':'UTF-8'}_editor_tinymceadvanced" value="tinymceadvanced" autocomplete="off"> {l s='Advanced WYSIWYG editor' mod='fscustomhtml'}
                    </label>
                {/if}
                {if isset($input.editors.codemirror) && $input.editors.codemirror}
                    <label class="btn btn-default" onclick="switch_editor_{$input.name|escape:'html':'UTF-8'}('codemirror')">
                        <input type="radio" name="{$input.name|escape:'html':'UTF-8'}_editor" id="{$input.name|escape:'html':'UTF-8'}_editor_codemirror" value="codemirror" autocomplete="off"> {l s='Code Editor' mod='fscustomhtml'}
                    </label>
                {/if}
            </div>
            {if isset($input.desc) && !(isset($input.hide_selector) && $input.hide_selector)}
            <br /><br />
            {/if}
            <script type="text/javascript">
                function switch_editor_{$input.name|escape:'html':'UTF-8'}(editor) {
                    var selector = '{$input.selector|escape:'html':'UTF-8'}';
                    FSCH.helperForm.trigger('switch_editor', {
                        selector: selector,
                        editor: editor,
                        {if isset($input.editors.tinymce)}
                        tinymce: {$input.editors.tinymce|fschJsonEncode|escape:'html':'UTF-8'|fschCorrectTheMess},
                        {/if}
                        {if isset($input.editors.codemirror)}
                        codemirror: {$input.editors.codemirror|fschJsonEncode|escape:'html':'UTF-8'|fschCorrectTheMess},
                        {/if}
                    });
                }

                {assign var='editor_field' value=implode('_', array($input['name'], 'editor'))}
                {if isset($input.editors) && $input.editors}
                $(document).ready(function(){
                    $('#{$input.name|escape:'html':'UTF-8'}_editor_{if isset($fields_value[$editor_field]) && $fields_value[$editor_field]}{$fields_value[$editor_field]|escape:'html':'UTF-8'}{else}none{/if}').parent().click();
                });
                {/if}
            </script>
        {else}
            {$smarty.block.parent}
        {/if}
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name="label"}
    {$smarty.block.parent}
{/block}

{block name="legend"}
    {$smarty.block.parent}
    {if isset($field.show_multishop_header) && $field.show_multishop_header}
        <div class="well clearfix">
            <label class="control-label col-lg-3">
                <i class="icon-sitemap"></i> {l s='Multistore' mod='fscustomhtml'}
            </label>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="help-block">
                            <strong>{l s='You are editing this page for a specific shop or group.' mod='fscustomhtml'}</strong><br />
                            {l s='If you check a field, change its value, and save, the multistore behavior will not apply to this shop (or group), for this particular parameter.' mod='fscustomhtml'}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    {/if}
{/block}
