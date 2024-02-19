/**
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
 */

var FSCH = FSCH || { };
FSCH.filter = $({ });

FSCH.filter.submit = function(name) {
    var filter_group_id = 'fsch-filter-group-'+name;
    var filter_id = 'fsch-filter-'+name;
    var filter_group_count = 1;

    var inputs = '';
    $('.'+filter_group_id).each(function(){
        $('.'+filter_id, $(this)).each(function(){
            inputs += '<input type="hidden" name="'+name+'['+filter_group_count+'][]" ';
            inputs += 'value="'+FSCH.filter.escapeJsonString(JSON.stringify($(this).data('filter')))+'">';
        });
        filter_group_count += 1;
    });

    $('.fsch-filter-inputs-'+name).html(inputs);
};

FSCH.filter.escapeJsonString = function(json_string) {
    var entity_map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
        '/': '&#x2F;',
        '`': '&#x60;',
        '=': '&#x3D;'
    };

    return String(json_string).replace(/[&<>"'`=\/]/g, function (s) {
        return entity_map[s];
    });
};

FSCH.filter.removeFilter = function(name, row_id) {
    var filter = $('.fsch-filters-'+name+' .fsch-filter-row-'+row_id);
    var group = filter.parent();

    filter.remove();

    if (group.find('.fsch-filter').length < 1) {
        group.remove();
    }
};

FSCH.filter.addFilterHtml = function(name, row_id) {
    var html = $('.fsch-filter-clone-'+name).html();
    $('.fsch-filters-'+name+' .fsch-filter-row-'+row_id).after(html);

    $.ajax({
        url: FSCH.filterGenerateUrl,
        data: {
            input_name: name
        },
        async: true,
        dataType: 'json',
        cache: false,
        success: function(data) {
            $('.fsch-filters-'+name+' .fsch-filter-cloned-placeholder').replaceWith(data.content);
        }
    });
};

FSCH.filter.addGroupHtml = function(name) {
    var html = $('.fsch-filter-group-clone-'+name).html();
    $('.fsch-filters-'+name).append(html);

    $.ajax({
        url: FSCH.filterGenerateUrl,
        data: {
            input_name: name
        },
        async: true,
        dataType: 'json',
        cache: false,
        success: function(data) {
            $('.fsch-filters-'+name+' .fsch-filter-group-cloned-placeholder').replaceWith(data.content);
        }
    });
};

$(document).ready(function(){
    FSCH.filter.on('change', function(event, params){
        if (params.row_id && params.name) {
            var row_id = 'fsch-filter-row-'+params.row_id;

            var filter = {};
            filter.type = $('.'+row_id+' .fsch-filter-rule-type').val();
            filter.parameter = $('.'+row_id+' .fsch-filter-rule-parameter').val();
            filter.condition = $('.'+row_id+' .fsch-filter-rule-condition').val();
            filter.value = $('.'+row_id+' .fsch-filter-rule-value').val();

            $('.'+row_id).data('filter', filter);
        }
    });

    FSCH.filter.on('reload', function(event, params){
        if (params.row_id && params.name) {
            var row_id = 'fsch-filter-row-'+params.row_id;
            $('.'+row_id).addClass('fsch-loading')

            $.ajax({
                url: FSCH.filterGenerateUrl,
                data: {
                    filter_type: params.type,
                    input_name: params.name
                },
                async: true,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $('.'+row_id).replaceWith(data.content);
                }
            });
        }
    });
});