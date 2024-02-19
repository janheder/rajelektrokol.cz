{*
* 2015-2020 Bonpresta
*
* Bonpresta Home Tab Content
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

{if isset($items_popups) && $items_popups}
    <div class="bon-product-popup">
        {foreach from=$items_popups item=items_popup name=items_popup}
            {if isset($items_popup.title) && $items_popup.title}
                <a class="title-popup-{$smarty.foreach.items_popup.iteration|escape:'htmlall':'UTF-8'}" data-toggle="modal" data-target="#modal-popup-{$smarty.foreach.items_popup.iteration|escape:'htmlall':'UTF-8'}"> {$items_popup.title|escape:'htmlall':'UTF-8'}</a>
            {/if}
            {if isset($items_popup.description) && $items_popup.description}
                <div class="desc-popup-{$smarty.foreach.items_popup.iteration|escape:'htmlall':'UTF-8'}">
                    <div class="modal fade" id="modal-popup-{$smarty.foreach.items_popup.iteration}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="popup-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {$items_popup.description nofilter}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        {/foreach}
    </div>
{/if}