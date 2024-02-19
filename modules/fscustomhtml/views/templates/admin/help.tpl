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

<div id="fsch_help" class="panel">
    <div class="panel-heading">
        <span>{l s='Help' mod='fscustomhtml'}</span>
    </div>
    <div class="form-wrapper clearfix">
        Thank you for using our module. For the best user experience we provide some examples and information.
        If you need more help, please feel free to <a href="{$fsch_contact_us_url|escape:'html':'UTF-8'|fschCorrectTheMess}" target="_blank">contact us</a>.
        <br />
        <h2>Getting Started</h2>
        <p>
            When you install the module everything is ready to create your first HTML BLock. But before please go through this help page.
        </p>
        <br />
        <h2>HTML Blocks</h2>
        <p>
            HTML Blocks are the contents you want to display in the Front Office. When you creating a HTML Block, the first thing you need to do is
            select a hook for the block. The module provides <strong>35+</strong> built-in hooks to place content. This will specify the position of the
            HTML Block in the Front Office like "displayFooter" which can display content in the footer.
        </p>
        <p>
            With the display rules, you can fine tune the visibility of the HTML Block. The module provides <strong>30+</strong> display rules like Page Type,
            Specific Category page, Specific Product page etc.
        </p>
        <p>
            <strong>Some examples what this module capable:</strong>
        </p>
        <ul>
            <li>
                Adding extra HTML Block Tab for a specific product.
            </li>
            <li>
                Adding extra HTML Block to products filtered by a category, manufacturer etc. So the HTML Block only displays on the product page if the product assigned to a
                specific category or manufacturer etc.
            </li>
            <li>
                Create low stock notification on product pages based on the quantity threshold you set up.
            </li>
            <li>
                Adding extra information on the login / registration page.
            </li>
            <li>
                Display targeted information for the customers who already bought a specific product or product from specific categories.
            </li>
        </ul>
        <br />
        <h2>Hooks</h2>
        <div>
            <div class="col-md-6">
                {foreach $fsch_hooks_first_half as $fsch_hook_group}
                    <h4 class="fsch-help-title spacer">{$fsch_hook_group.title|escape:'html':'UTF-8'} ({$fsch_hook_group.hooks|count|escape:'html':'UTF-8'})</h4>
                    <div class="fsch-help-body fsch-hide">
                        {foreach $fsch_hook_group.hooks as $fsch_hook}
                            <span class="fsch-bold">{$fsch_hook.title|escape:'html':'UTF-8'}</span> - <code>{$fsch_hook.name|escape:'html':'UTF-8'}</code>
                            <p>
                                {$fsch_hook.desc|escape:'html':'UTF-8'}
                            </p>
                        {/foreach}
                    </div>
                {/foreach}
            </div>
            <div class="col-md-6">
                {foreach $fsch_hooks_second_half as $fsch_hook_group}
                    <h4 class="fsch-help-title spacer">{$fsch_hook_group.title|escape:'html':'UTF-8'} ({$fsch_hook_group.hooks|count|escape:'html':'UTF-8'})</h4>
                    <div class="fsch-help-body fsch-hide">
                        {foreach $fsch_hook_group.hooks as $fsch_hook}
                            <span class="fsch-bold">{$fsch_hook.title|escape:'html':'UTF-8'}</span> - <code>{$fsch_hook.name|escape:'html':'UTF-8'}</code>
                            <p>
                                {$fsch_hook.desc|escape:'html':'UTF-8'}
                            </p>
                        {/foreach}
                    </div>
                {/foreach}
            </div>
            <div class="fsch-clear"></div>
        </div>
        <br />
        <h2>Display Rules</h2>
        <div>
            <div class="col-md-6">
                {foreach $fsch_filter_rules_first_half as $fsch_filter_rule}
                    <h4 class="fsch-help-title spacer">{$fsch_filter_rule.label|escape:'html':'UTF-8'}</h4>
                    <div class="fsch-help-body fsch-hide">
                        {$fsch_filter_rule.help|escape:'html':'UTF-8'|fschCorrectTheMess}
                    </div>
                {/foreach}
            </div>
            <div class="col-md-6">
                {foreach $fsch_filter_rules_second_half as $fsch_filter_rule}
                    <h4 class="fsch-help-title spacer">{$fsch_filter_rule.label|escape:'html':'UTF-8'}</h4>
                    <div class="fsch-help-body fsch-hide">
                        {$fsch_filter_rule.help|escape:'html':'UTF-8'|fschCorrectTheMess}
                    </div>
                {/foreach}
            </div>
            <div class="fsch-clear"></div>
        </div>
        <br />
        <h2>Custom Hooks</h2>
        <p>
            To use custom hooks, you need to edit the template file and place proper widget code where you want to display the custom hook.
        </p>
        <p>
            <span class="fsch-bold">Built-in widget code:</span>
        </p>
        <p>
            <code>{literal}{widget name="fscustomhtml" hook='displayMyHookName'}{/literal}</code>
        </p>
        <p>
            <span class="fsch-bold">Custom widget code:</span>
        </p>
        <p>
            <code>{literal}{fscustomhtml hook='displayMyHookName'}{/literal}</code>
        </p>
        <p class="fsch-mb-0">
            In these widgets codes you need to set up your custom hook name. The hook value can be one of the previously created custom hook name.
        </p>
        <br />
        <h2>Dynamic Variables in Contents and Templates</h2>
        <div>
            <div class="col-md-6">
                <h4 class="fsch-help-title">{literal}{id_html_block}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{id_html_block}{/literal}</code></p>
                    <p>
                        Every HTML Block has a unique identifier which is an unsigned integer value. This helps you to create Block specific CSS and Javascript, really helpful in templates.
                    </p>
                    <p><span class="fsch-bold">Example:</span> Create unique ID for a wrapper div</p>
                    {capture name="fsch_html_code"}
                        <div id="my-block-{literal}{id_html_block}{/literal}"></div>
                    {/capture}
                    <p>
                        <code>{$smarty.capture.fsch_html_code|escape:'html':'UTF-8'|fschKeepEscape}</code>
                    </p>
                    <p>
                        So, if the Block ID is 14, then the rendered HTML code is:
                    </p>
                    {capture name="fsch_html_code"}
                        <div id="my-block-14"></div>
                    {/capture}
                    <p>
                        <code>{$smarty.capture.fsch_html_code|escape:'html':'UTF-8'|fschKeepEscape}</code>
                    </p>
                </div>
                <h4 class="fsch-help-title spacer">{literal}{id_lang}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{id_lang}{/literal}</code></p>
                    <p>
                        Language is a global variable in the system and the Language ID is an unsigned integer value. This helps you to create language specific CSS and Javascript, really helpful in templates.
                    </p>
                    <p><span class="fsch-bold">Example:</span> Create div with a current language class selector</p>
                    {capture name="fsch_html_code"}
                        <div class="my-lang-{literal}{id_lang}{/literal}"></div>
                    {/capture}
                    <p>
                        <code>{$smarty.capture.fsch_html_code|escape:'html':'UTF-8'|fschKeepEscape}</code>
                    </p>
                    <p>
                        So, if the Language ID is 1, then the rendered HTML code is:
                    </p>
                    {capture name="fsch_html_code"}
                        <div class="my-lang-1"></div>
                    {/capture}
                    <p>
                        <code>{$smarty.capture.fsch_html_code|escape:'html':'UTF-8'|fschKeepEscape}</code>
                    </p>
                </div>
                <h4 class="fsch-help-title spacer">{literal}{lang_iso_code}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{lang_iso_code}{/literal}</code></p>
                    <p>
                        Language is a global variable in the system and the Language ISO CODE is a two-letter formatted language value (ISO 639-1). This helps you to create language specific CSS and Javascript, really helpful in templates.
                    </p>
                    <p><span class="fsch-bold">Example:</span> Create div with a current language class selector with ISO code</p>
                    {capture name="fsch_html_code"}
                        <div class="my-lang-{literal}{lang_iso_code}{/literal}"></div>
                    {/capture}
                    <p>
                        <code>{$smarty.capture.fsch_html_code|escape:'html':'UTF-8'|fschKeepEscape}</code>
                    </p>
                    <p>
                        So, if the Language is English, then the rendered HTML code is:
                    </p>
                    {capture name="fsch_html_code"}
                        <div class="my-lang-en"></div>
                    {/capture}
                    <p>
                        <code>{$smarty.capture.fsch_html_code|escape:'html':'UTF-8'|fschKeepEscape}</code>
                    </p>
                </div>
                <h4 class="fsch-help-title spacer">{literal}{content_only_url_param}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{content_only_url_param}{/literal}</code></p>
                    <p>
                        This is equals to "?content_only=1" if the Block displayed in the content only context.
                    </p>
                    <p><span class="fsch-bold">Example:</span> YOu know that you block can displayed in a content only context and you have link to other content in the block.</p>
                    <p>
                        If you want that the links in the content respects the content only context, append this variable to the links
                    </p>
                    <p>
                        <code>https://www.domain.com/my-content-url.html{literal}{content_only_url_param}{/literal}</code>
                    </p>
                    <p>
                        So, if the context is content only, then the URL is:
                    </p>
                    <p>
                        <code>https://www.domain.com/my-content-url.html?content_only=1</code>
                    </p>
                </div>
                <h4 class="fsch-help-title spacer">{literal}{page_name}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{page_name}{/literal}</code></p>
                    <p>
                        Every page type has a unique page name, even module pages.
                    </p>
                    <p><span class="fsch-bold">Example:</span> Create div with a current page class selector</p>
                    {capture name="fsch_html_code"}
                        <div class="my-page-{literal}{page_name}{/literal}"></div>
                    {/capture}
                    <p>
                        <code>{$smarty.capture.fsch_html_code|escape:'html':'UTF-8'|fschKeepEscape}</code>
                    </p>
                    <p>
                        So, if the page is a Product page, then the rendered HTML code is:
                    </p>
                    {capture name="fsch_html_code"}
                        <div class="my-page-product"></div>
                    {/capture}
                    <p>
                        <code>{$smarty.capture.fsch_html_code|escape:'html':'UTF-8'|fschKeepEscape}</code>
                    </p>

                    <p><span class="fsch-bold">Page names:</span>
                        {foreach $fsch_page_names as $fsch_page_id => $fsch_page_name}
                            <code>{$fsch_page_id|escape:'html':'UTF-8'}</code>
                        {/foreach}
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="fsch-help-title spacer">{literal}{shop_url}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{shop_url}{/literal}</code></p>
                    <p>
                        The current shop's base URL.
                    </p>
                    <p>
                        <code>https://www.domain.com/</code>
                    </p>
                </div>
                <h4 class="fsch-help-title spacer">{literal}{shop_name}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{shop_name}{/literal}</code></p>
                    <p>
                        The current shop name.
                    </p>
                    <p>
                        <code>My Shop Name</code>
                    </p>
                </div>
                <h4 class="fsch-help-title spacer">{literal}{customer_lastname}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{customer_lastname}{/literal}</code></p>
                    <p>
                        If the customer logged in, then displays the customer's last name.
                    </p>
                    <p>
                        <code>Doe</code>
                    </p>
                </div>
                <h4 class="fsch-help-title spacer">{literal}{customer_firstname}{/literal}</h4>
                <div class="fsch-help-body fsch-hide">
                    <p><code>{literal}{customer_firstname}{/literal}</code></p>
                    <p>
                        If the customer logged in, then displays the customer's first name.
                    </p>
                    <p>
                        <code>John</code>
                    </p>
                </div>
            </div>
            <div class="fsch-clear"></div>
        </div>
        <br />
        <h2>Additional Dynamic Variables in Templates</h2>
        <h4 class="fsch-help-title">{literal}{title}{/literal}</h4>
        <div class="fsch-help-body fsch-hide">
            <p><code>{literal}{title}{/literal}</code></p>
            <p>
                If you use a template for a HTML Block and you want to display the HTML Block title in the template, you need to place the <code>{literal}{title}{/literal}</code> variable in the template.
            </p>
        </div>
        <h4 class="fsch-help-title spacer">{literal}{content}{/literal}</h4>
        <div class="fsch-help-body fsch-hide">
            <p><code>{literal}{content}{/literal}</code></p>
            <p>
                If you use a template for a HTML Block and you want to display the HTML Block content in the template, you need to place the <code>{literal}{content}{/literal}</code> variable in the template.
            </p>
        </div>
        <br />
        <div class="fsch-brand-container">
            <div class="fsch-brand-col c-1"></div>
            <div class="fsch-brand-col c-2"></div>
            <div class="fsch-brand-col c-3"></div>
            <div class="fsch-brand-col c-4"></div>
        </div>
    </div>
</div>
