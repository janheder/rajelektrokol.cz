{*
 * 2015-2017 Bonpresta
 *
 * Bonpresta Frequently Asked Questions
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
 *  @author    Bonpresta
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

<section id="bonfaq">
    {capture name=path}
        {l s='Faq' mod='bonfaq'}
    {/capture}
    <h1 class="page-heading">
       {l s='Faq' mod='bonfaq'}
    </h1>
    {if $items}
        <div class="panel-group row" id="faqAccordion">
            {foreach from=$items item=item name=item}
                <div class="panel panel-default col-6">
                    {if isset($item.title) && $item.title}
                        <div class="panel-heading accordion-toggle question-toggle collapsed" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question{$smarty.foreach.item.iteration|escape:'htmlall':'UTF-8'}" aria-expanded="false">
                            <h2 class="panel-title">
                                <a href="#" class="ing"><span>{$smarty.foreach.item.iteration|escape:'htmlall':'UTF-8'}. </span>{$item.title|escape:'htmlall':'UTF-8'}</a>
                            </h2>
                        </div>
                    {/if}
                    {if isset($item.description) && $item.description}
                        <div id="question{$smarty.foreach.item.iteration|escape:'htmlall':'UTF-8'}" class="panel-collapse collapse" style="height: 0px;" aria-expanded="false">
                            <div class="panel-body">
                                {$item.description nofilter}
                            </div>
                        </div>
                    {/if}
                </div>
            {/foreach}
        </div>
    {else}
        <p class="alert alert-warning">{l s='No faq item.' mod='bonfaq'}</p>
    {/if}
</section>
