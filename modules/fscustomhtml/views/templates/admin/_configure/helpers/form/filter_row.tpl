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

{if !isset($selected_type)}
{assign var="selected_type" value="page_type"}
{/if}

{if !isset($selected_condition)}
{assign var="selected_condition" value="equals"}
{/if}

{if !isset($selected_parameter)}
{assign var="selected_parameter" value=""}
{/if}

{if !isset($selected_value)}
{if $selected_type == "page_type"}
{assign var="selected_value" value="all"}
{else}
{assign var="selected_value" value=""}
{/if}
{/if}

{if !isset($filter_row_id)}
{assign var="filter_row_id" value=uniqid('fr')}
{/if}

{capture name="filter_json"}{literal}{{/literal}"type":"{$selected_type|escape:'html':'UTF-8'|fschCorrectTheMess}","parameter":"{$selected_parameter|escape:'html':'UTF-8'|fschCorrectTheMess}","condition":"{$selected_condition|escape:'html':'UTF-8'|fschCorrectTheMess}","value":"{$selected_value|escape:'html':'UTF-8'|fschCorrectTheMess}"{literal}}{/literal}{/capture}
<div class="form-group fsch-filter fsch-filter-{$input_name|escape:'html':'UTF-8'} fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}" data-filter="{$smarty.capture.filter_json|escape:'html':'UTF-8'}">
    <div class="col-md-3">
        <select class="fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-type-select2 fsch-filter-rule-type">
            {foreach $fsch_filter_rules as $filter_rule_group}
            <optgroup label="{$filter_rule_group.label|escape:'html':'UTF-8'}">
                {foreach $filter_rule_group.rules as $rule_id => $rule}
                <option value="{$rule_id|escape:'html':'UTF-8'}"{if $selected_type == $rule_id} selected="selected"{/if}>{$rule.label|escape:'html':'UTF-8'}</option>
                {/foreach}
            </optgroup>
            {/foreach}
        </select>
    </div>
    <div class="col-md-9 fsch-show-on-loading">
        <img src="{$fsch_module_base_url|escape:'html':'UTF-8'|fschCorrectTheMess}views/img/filter-loader.gif">
    </div>
    <div class="col-md-9 fsch-hide-when-loading">
        {foreach $fsch_filter_rules as $filter_rule_group}
            {foreach $filter_rule_group.rules as $rule_id => $rule}
                {if $selected_type == $rule_id}
                <div class="row">
                    {if isset($rule.parameter) && $rule.parameter}
                    <div class="col-md-3">
                        <input type="text" placeholder="{l s='parameter name' mod='fscustomhtml'}" value="{$selected_parameter|escape:'html':'UTF-8'}" class="fsch-filter-rule-parameter">
                        <script>
                            $(document).ready(function(){
                                $('.fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'} .fsch-filter-rule-parameter').on('keyup', function(){
                                    var params = {
                                        row_id: '{$filter_row_id|escape:'html':'UTF-8'}',
                                        name: '{$input_name|escape:'html':'UTF-8'}'
                                    };
                                    FSCH.filter.trigger('change', params);
                                });
                            });
                        </script>
                    </div>
                    {else}
                    <input type="hidden" value="" class="fsch-filter-rule-parameter">
                    {/if}
                    <div class="col-md-2">
                        <select class="fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-select2 fsch-filter-rule-condition">
                            {foreach $rule.conditions as $conditions_value => $conditions_label}
                                <option value="{$conditions_value|escape:'html':'UTF-8'}"{if $selected_condition == $conditions_value} selected="selected"{/if}>{$conditions_label|escape:'html':'UTF-8'}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-md-{if isset($rule.parameter) && $rule.parameter}4{else}7{/if}">
                        {if $rule.input.type == 'text'}
                            <input type="text" placeholder="{$rule.input.placeholder|escape:'html':'UTF-8'}" value="{$selected_value|escape:'html':'UTF-8'}" class="fsch-filter-rule-value">
                            <script>
                                $(document).ready(function(){
                                    $('.fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'} .fsch-filter-rule-value').on('keyup', function(){
                                        var params = {
                                            row_id: '{$filter_row_id|escape:'html':'UTF-8'}',
                                            name: '{$input_name|escape:'html':'UTF-8'}'
                                        };
                                        FSCH.filter.trigger('change', params);
                                    });
                                });
                            </script>
                        {elseif $rule.input.type == 'autocomplete'}
                            <select class="fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-autocomplete-select2 fsch-filter-rule-value">
                                {if $selected_value}
                                <option value="{$selected_value|escape:'html':'UTF-8'}">{$selected_value|fschFilterContentText:$rule.input.content_type|escape:'html':'UTF-8'}</option>
                                {/if}
                            </select>
                            <script>
                                $(document).ready(function(){
                                    $('.fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-autocomplete-select2').select2({
                                        ajax: {
                                            url: '{$rule.input.url|escape:'html':'UTF-8'|fschCorrectTheMess}',
                                            dataType: 'json',
                                            delay: 250,
                                            data: function (params) {
                                                return {
                                                    q: params.term,
                                                    page: params.page
                                                };
                                            },
                                            processResults: function (data, params) {
                                                params.page = params.page || 1;

                                                return {
                                                    results: data.content.items,
                                                    pagination: {
                                                        more: (params.page * 10) < data.content.total_count
                                                    }
                                                };
                                            },
                                            cache: true
                                        },
                                        minimumInputLength: 1,
                                        escapeMarkup: function (markup) { return markup; },
                                        templateResult: function(item) {
                                            if (item.loading) { return item.text; }
                                            return FSCH.select2.markMatch(item.text, $('.select2-search__field').val());
                                        }
                                        {if isset($rule.input.placeholder) && $rule.input.placeholder}
                                        ,placeholder: '{$rule.input.placeholder|escape:'html':'UTF-8'}'
                                        {/if}
                                    }).on('change', function(){
                                        var params = {
                                            row_id: '{$filter_row_id|escape:'html':'UTF-8'}',
                                            name: '{$input_name|escape:'html':'UTF-8'}'
                                        };
                                        FSCH.filter.trigger('change', params);
                                    });
                                });
                            </script>
                        {elseif $rule.input.type == 'select'}
                            <select class="fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-select2 fsch-filter-rule-value">
                                {if isset($rule.input.options.default)}
                                    <option value="{$rule.input.options.default.value|escape:'html':'UTF-8'}">{$rule.input.options.default.label|escape:'html':'UTF-8'}</option>
                                {/if}
                                {if isset($rule.input.options.optiongroup)}
                                    {foreach $rule.input.options.optiongroup.query as $optiongroup}
                                        <optgroup label="{$optiongroup[$rule.input.options.optiongroup.label]|escape:'html':'UTF-8'}">
                                            {foreach $optiongroup[$rule.input.options.options.query] as $option}
                                                <option value="{$option[$rule.input.options.options.id]|escape:'html':'UTF-8'}"{if $selected_value == $option[$rule.input.options.options.id]} selected="selected"{/if}>{$option[$rule.input.options.options.name]}</option>
                                            {/foreach}
                                        </optgroup>
                                    {/foreach}
                                {else}
                                    {foreach $rule.input.options.query AS $option}
                                        <option value="{$option[$rule.input.options.id]|escape:'html':'UTF-8'}"{if $selected_value == $option[$rule.input.options.id]} selected="selected"{/if}>{$option[$rule.input.options.name]}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        {elseif $rule.input.type == 'date_time'}
                            <input type="text" placeholder="{$rule.input.placeholder|escape:'html':'UTF-8'}" value="{$selected_value|escape:'html':'UTF-8'}" class="fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-datetimepicker fsch-filter-rule-value">
                        {elseif $rule.input.type == 'date'}
                            <input type="text" placeholder="{$rule.input.placeholder|escape:'html':'UTF-8'}" value="{$selected_value|escape:'html':'UTF-8'}" class="fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-datepicker fsch-filter-rule-value">
                        {elseif $rule.input.type == 'time'}
                            <input type="text" placeholder="{$rule.input.placeholder|escape:'html':'UTF-8'}" value="{$selected_value|escape:'html':'UTF-8'}" class="fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-timepicker fsch-filter-rule-value">
                        {/if}
                    </div>
                    <div class="col-md-2" style="white-space: nowrap;">
                        <a href="javascript:;" onclick="FSCH.filter.addFilterHtml('{$input_name|escape:'html':'UTF-8'}', '{$filter_row_id|escape:'html':'UTF-8'}')" class="btn btn-primary">
                            {l s='+ AND' mod='fscustomhtml'}
                        </a>
                        <a href="javascript:;" onclick="FSCH.filter.removeFilter('{$input_name|escape:'html':'UTF-8'}', '{$filter_row_id|escape:'html':'UTF-8'}')" class="btn btn-danger">
                            {l s='--' mod='fscustomhtml'}
                        </a>
                    </div>
                    {if isset($rule.help) && trim($rule.help)}
                    <div class="col-md-1" style="text-align:right;">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fsch-modal-help-{$filter_row_id|escape:'html':'UTF-8'}">?</button>
                    </div>
                    <div id="fsch-modal-help-{$filter_row_id|escape:'html':'UTF-8'}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn btn-danger btn-xs" style="float:right;" data-dismiss="modal">{l s='Close' mod='fscustomhtml'}</button>
                                    <span class="fsch-bold">{$rule.label|escape:'html':'UTF-8'}</span>
                                </div>
                                <div class="modal-body">
                                    {$rule.help|escape:'html':'UTF-8'|fschCorrectTheMess}
                                </div>
                            </div>
                        </div>
                    </div>
                    {/if}
                </div>
                {/if}
            {/foreach}
        {/foreach}
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-type-select2').select2({
            escapeMarkup: function (markup) { return markup; },
            templateResult: function(item) {
                if (item.loading) { return item.text; }
                return FSCH.select2.markMatch(item.text, $('.select2-search__field').val());
            }}).on('change', function(){
            var params = {
                row_id: '{$filter_row_id|escape:'html':'UTF-8'}',
                type: $(this).val(),
                name: '{$input_name|escape:'html':'UTF-8'}'
            };
            FSCH.filter.trigger('reload', params);
        });

        $('.fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-select2').select2({
            escapeMarkup: function (markup) { return markup; },
            templateResult: function(item) {
                if (item.loading) { return item.text; }
                return FSCH.select2.markMatch(item.text, $('.select2-search__field').val());
            }}).on('change', function(){
            var params = {
                row_id: '{$filter_row_id|escape:'html':'UTF-8'}',
                name: '{$input_name|escape:'html':'UTF-8'}'
            };
            FSCH.filter.trigger('change', params);
        });

        $('.fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-datetimepicker').datetimepicker({
            prevText: '',
            nextText: '',
            dateFormat: 'yy-mm-dd'
        }).on('change', function(){
            var params = {
                row_id: '{$filter_row_id|escape:'html':'UTF-8'}',
                name: '{$input_name|escape:'html':'UTF-8'}'
            };
            FSCH.filter.trigger('change', params);
        });

        $('.fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-datepicker').datepicker({
            prevText: '',
            nextText: '',
            dateFormat: 'yy-mm-dd'
        }).on('change', function(){
            var params = {
                row_id: '{$filter_row_id|escape:'html':'UTF-8'}',
                name: '{$input_name|escape:'html':'UTF-8'}'
            };
            FSCH.filter.trigger('change', params);
        });

        $('.fsch-filter-row-{$filter_row_id|escape:'html':'UTF-8'}-timepicker').timepicker({
            prevText: '',
            nextText: '',
        }).on('change', function(){
            var params = {
                row_id: '{$filter_row_id|escape:'html':'UTF-8'}',
                name: '{$input_name|escape:'html':'UTF-8'}'
            };
            FSCH.filter.trigger('change', params);
        });
    });
</script>