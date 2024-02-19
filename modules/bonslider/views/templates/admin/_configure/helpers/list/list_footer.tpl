{*
* 2015-2021 Bonpresta
*
* Bonpresta Slider Manager with Photos and Videos
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
* @copyright 2015-2021 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{extends file="helpers/list/list_footer.tpl"}
{block name="footer"}
    {if $list_id == 'bonslider'}
        <div class="panel-footer">
            <a href="" class="btn btn-default pull-right"
                onclick="sendBulkAction($(this).closest('form').get(0), 'addbonslider'); return false;">
                <i class="process-icon-plus"></i> <span>{l s='Add new item' mod='bonslider'}</span>
            </a>
        </div>
    {/if}
    {if $list_id == 'bonslider_sub'}
        <div class="panel-footer">
            <a href="" class="btn btn-default pull-right"
                onclick="sendBulkAction($(this).closest('form').get(0), 'addsubbonslider'); return false;">
                <i class="process-icon-plus"></i> <span>{l s='Add new item' mod='bonslider'}</span>
            </a>
        </div>
    {/if}
    {$smarty.block.parent}
{/block}