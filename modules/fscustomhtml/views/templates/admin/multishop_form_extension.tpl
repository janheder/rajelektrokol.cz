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

<input type="checkbox" name="{$params.multishop_group_prefix|escape:'htmlall':'UTF-8'}_multishop_override_enabled[]" value="{$params.name|escape:'htmlall':'UTF-8'}"
       id="conf_helper_{$params.name|escape:'htmlall':'UTF-8'}" {if !$params.disabled} checked="checked"{/if}
       onclick="{$params.name|escape:'htmlall':'UTF-8'}_toggleMultishopDefaultValue()">
<script>
    $(document).ready(function(){
        {$params.name|escape:'htmlall':'UTF-8'}_toggleMultishopDefaultValue();
    });

    function {$params.name|escape:'htmlall':'UTF-8'}_toggleMultishopDefaultValue() {
        var obj = $('#conf_helper_{$params.name|escape:'htmlall':'UTF-8'}');
        var key = '{$params.name|escape:'htmlall':'UTF-8'}';

        if (!$(obj).prop('checked') || $('.'+key).hasClass('isInvisible')) {
            $('.conf_id_'+key+' input, .conf_id_'+key+' textarea, .conf_id_'+key+' select, .conf_id_'+key+' button').attr('disabled', true);
            $('.conf_id_'+key+' label.conf_title').addClass('isDisabled');
        } else {
            $('.conf_id_'+key+' input, .conf_id_'+key+' textarea, .conf_id_'+key+' select, .conf_id_'+key+' button').attr('disabled', false);
            $('.conf_id_'+key+' label.conf_title').removeClass('isDisabled');
        }
        $('.conf_id_'+key+' input[name^=\'{$params.multishop_group_prefix|escape:'htmlall':'UTF-8'}_multishop_override_enabled\']').attr('disabled', false);
    }
</script>