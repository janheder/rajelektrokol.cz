{*
* 2015-2020 Bonpresta
*
* Bonpresta Advanced Ajax Live Search Product
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


<div id="_desktop_search_widget" class="bonsearch"
    data-search-controller-url="{$link->getPageLink('search')|escape:'html':'UTF-8'}">
    <div class="bonsearch_box bon_drop_down" style="opacity: 0;">
        <form method="get" action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" id="searchbox">
            <div class="search-form-inner">
{*                {if isset($categories) && $categories}*}
{*                    <select class="bonsearch-option">*}
{*                        <option value="0"*}
{*                            title="{l s='All' mod='bonsearch'}">{l s='All' mod='bonsearch'}*}
{*                        </option>*}
{*                        {foreach from=$categories item=category name=category}*}
{*                            <option value="{$category.id|escape:'html':'UTF-8'}"*}
{*                                class="{if $category.level_depth > 2 && !Category::getChildren($category.id, 1, true, false)}subcategory{/if} level-{$category.level_depth}"*}
{*                                title="{$category.name|escape:'html':'UTF-8'}">{$category.name|escape:'html':'UTF-8'}*}
{*                            </option>*}
{*                        {/foreach}*}
{*                    </select>*}
{*                {/if}*}
                <input type="hidden" name="controller" value="search" />
                <input type="text" id="input_search" name="search_query" class="ui-autocomplete-input"
                    autocomplete="off" placeholder="{l s='Search' mod='bonsearch'}" />
{*                <div class="bonsearch-microphone" id="bonsearch-microphone" data-toggle="modal"*}
{*                    data-target="#bonsearch-popup-wrapper">*}
{*                    <i class="bonicon-microphone10"></i>*}
{*                </div>*}
                <button class="bonsearch_btn btn-unstyle" type="submit">
                    <svg width="22" height="25" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00006 2C3.79092 2 2.00006 3.79086 2.00006 6C2.00006 8.20914 3.79092 10 6.00006 10C8.2092 10 10.0001 8.20914 10.0001 6C10.0001 3.79086 8.2092 2 6.00006 2ZM6.10352e-05 6C6.10352e-05 2.68629 2.68635 0 6.00006 0C9.31377 0 12.0001 2.68629 12.0001 6C12.0001 7.29583 11.5893 8.49572 10.8908 9.47653L15.7072 14.2929C16.0977 14.6834 16.0977 15.3166 15.7072 15.7071C15.3166 16.0976 14.6835 16.0976 14.293 15.7071L9.4766 10.8907C8.49578 11.5892 7.29589 12 6.00006 12C2.68635 12 6.10352e-05 9.31371 6.10352e-05 6Z" fill="#374151"/>
                    </svg>
                </button>
            </div>
            <div id="search_popup"></div>
        </form>
    </div>

</div>
{*<div class="modal fade" id="bonsearch-popup-wrapper" tabindex="-1" role="dialog" aria-hidden="true">*}
{*    <div class="modal-dialog modal-dialog-centered" role="document">*}
{*        <div class="modal-content">*}
{*            <button type="button" class="popup-close" data-dismiss="modal" aria-label="Close"></button>*}
{*            <div class="modal-body">*}
{*                <div class="bonsearch-icon-speech">*}
{*                    <i class="bonicon-microphone10"></i>*}
{*                </div>*}
{*                <div class="bonsearch-speek-text">*}
{*                    <p>{l s='Say something...' mod='bonsearch'}</p>*}
{*                </div>*}
{*                <div class="bonsearch-error-text">*}
{*                    <p>{l s='Nothing found. Please repeat.' mod='bonsearch'}</p>*}
{*                </div>*}
{*                <div class="bonsearch-unsupport-text">*}
{*                    <p>{l s='Unsupported browser. Sorry...' mod='bonsearch'}</p>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}
{*    </div>*}
{*</div>*}
