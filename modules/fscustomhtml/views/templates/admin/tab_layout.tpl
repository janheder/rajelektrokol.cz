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

<div class="row">
    <div id="fsch_tabs" class="col-lg-2 col-md-3">
        <div class="list-group">
            {foreach from=$fsch_tab_layout item=fsch_tab}
                <a class="list-group-item{if $fsch_active_tab == $fsch_tab.id} active{/if}"
                   href="#{$fsch_tab.id|escape:'htmlall':'UTF-8'}"
                   aria-controls="{$fsch_tab.id|escape:'htmlall':'UTF-8'}" role="tab" data-toggle="tab">
                    {$fsch_tab.title|escape:'htmlall':'UTF-8'}
                </a>
            {/foreach}
        </div>
        <div class="fsch-side-menu-container">
            <div class="fsch-brand-container">
                <div class="fsch-brand-col c-1"></div>
                <div class="fsch-brand-col c-2"></div>
                <div class="fsch-brand-col c-3"></div>
                <div class="fsch-brand-col c-4"></div>
            </div>
            <div class="fsch-need-help-container">
                <i class="fsch-fa fsch-fa-question-circle fsch-need-help-question-mark" aria-hidden="true"></i>
                <a class="fsch-need-help-link" href="{$fsch_contact_us_url|escape:'html':'UTF-8'|fschCorrectTheMess}" target="_blank">
                    Need help? <i class="fsch-fa fsch-fa-external-link" aria-hidden="true"></i>
                </a>
            </div>
            <div class="fsch-more-modules-container">
                <img src="{$fsch_module_base_url|escape:'html':'UTF-8'}views/img/modules-link-logo-40.jpg">
                <a class="fsch-more-modules-link" href="https://addons.prestashop.com/en/2_community-developer?contributor=271190" target="_blank">
                    Our modules! <i class="fsch-fa fsch-fa-external-link" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-md-9">
        <div class="tab-content">
            {foreach from=$fsch_tab_layout item=fsch_tab}
                <div role="tabpanel" class="tab-pane{if $fsch_active_tab == $fsch_tab.id} active{/if}" id="{$fsch_tab.id|escape:'htmlall':'UTF-8'}">
                    {$fsch_tab.content|escape:'html':'UTF-8'|fschCorrectTheMess|fschResolveEscape}
                </div>
            {/foreach}
        </div>
    </div>
    <div class="clearfix"></div>
</div>