{*
* 2015-2021 Bonpresta
*
* Bonpresta Information Banner
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

{if isset($items) && $items}
    <div class="clearfix"></div>
    <section id="boninfoban">
        <h2 class="title_block boninfoban-title revealOnScroll animated fadeInUp" data-animation="fadeInUp">
            {l s='Information Banner' mod='boninfoban'}
        </h2>
        <ul class="new-slider revealOnScroll animated fadeInUp" data-animation="fadeInUp">
            {foreach from=$items item=item name=item}
                {if $smarty.foreach.item.iteration <= $limit}
                    <li class="boninfoban-item">
                        <div class="row">
                            {if $item.type == 'image'}
                                {if isset($item.image) && $item.image}
                                    <a class="boninfoban-image col-sm-12" href="{$item.url}">
                                        <img class="img-responsive" src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}" alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                        {if isset($item.description) && $item.description}
                                            <div class="box-infoban col-sm-12">
                                                <div class="boninfoban-item-description">
                                                    {$item.description nofilter}
                                                </div>
                                            </div>
                                        {/if}
                                    </a>
                                {/if}
                            {elseif $item.type == 'video'}
                                {if substr($item.image, -3) == "gif"}
                                    <a class="boninfoban-image col-sm-12" href="{$item.url}">
                                        <img class="img-responsive" src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}" alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                    </a>
                                {/if}
                                {if isset($item.cover) && $item.cover && substr($item.image, -3) !== "gif"}
                                    <div class="boninfoban-video col-sm-12">
                                        <div class="boninfoban-cover-img">
                                            <img class="img-responsive" src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.cover|escape:'htmlall':'UTF-8'}" alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                            <a href="#" class="boninfoban-video-link" data-toggle="modal" data-target="#boninfoban-video"> </a>
                                        </div>
                                    </div>
                                {else}
                                    {if substr($item.image, -3) !== "gif"}
                                        <div class="box-video col-sm-12">
                                            <video id="video-element" class="" loop="loop">
                                                <source src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}" type="video/mp4">
                                            </video>
                                            <a href="#" class="boninfoban-video-link" data-toggle="modal" data-target="#boninfoban-video"> </a>
                                        </div>
                                    {/if}
                                {/if}
                                {if isset($item.description) && $item.description}
                                    <div class="box-ban col-sm-12 col-lg-6">
                                        <div class="boninfoban-item-description">
                                            {$item.description nofilter}
                                        </div>
                                    </div>
                                {/if}
                            {/if}
                        </div>
                    </li>
                {/if}
            {/foreach}
        </ul>
        {foreach from=$items item=item name=item}
            {if $smarty.foreach.item.iteration <= $limit}
                <div class="modal fade" id="boninfoban-video" tabindex="-1" role="dialog" aria-labelledby="boninfoban-video" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video id="boninfoban-video-element" class="" loop="loop" controls>
                                    <source src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        {/foreach}
    </section>
{/if}