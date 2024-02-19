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

<div id="fsch_help_custom_hook" class="panel">
    <div class="panel-heading">
        <span>{l s='How To Use Custom Hooks' mod='fscustomhtml'}</span>
    </div>
    <div class="form-wrapper clearfix">
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
    </div>
</div>
