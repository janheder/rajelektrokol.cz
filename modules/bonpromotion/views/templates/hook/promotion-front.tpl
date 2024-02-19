{*
 * 2015-2019 Bonpresta
 *
 * Promotion Discount Countdown Banner & Slider
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
 *  @copyright 2015-2019 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{if isset($items) && $items}
    <section id="bonpromotion" class="spaced-section">
        <ul class="mb-0">
            {foreach from=$items item=item name=item}
                {if $smarty.foreach.item.iteration <= $limit}
                    {if $item.type == 'video'}
                        <li class="video">
                            <a class="link-promotion" href="{$item.url|escape:'htmlall':'UTF-8'}">
                                <video loop="loop" autoplay muted class="bonpromotion-video"></video>
                                <div class="box-promotion">
                                <div class="bonpromotion-countdown revealOnScroll animated fadeInUp" data-animation="fadeInUp" data-countdown="{$item.data_end|escape:'htmlall':'UTF-8'}"></div>
                                    {if isset($item.description) && $item.description}
                                        <div class="box-promotion-desc revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                                            {$item.description nofilter}
                                        </div>
                                    {/if}
                                    <div class="bonpromotion-countdown-btn-wrapper">
                                        <span class="btn-primary revealOnScroll animated fadeInUp" data-animation="fadeInUp">{l s='Shop Now!' mod='bonpromotion'}</span>
                                        <div class="btn-see-more"><div class="triangle-wrapper"><div class="triangle"></div></div>See More</div>
                                    </div>
                                </div>                           
                            </a>
                        </li>
                    {elseif $item.type == 'image'}
                        <li class="image" style="background-image: url('{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}')">
                            <a class="link-promotion container" href="{$item.url|escape:'htmlall':'UTF-8'}">
                                <div class="box-promotion">
                                    {if isset($item.description) && $item.description}
                                        <div class="box-promotion-desc revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                                            {$item.description nofilter}
                                        </div>
                                    {/if}
                                    <div class="bonpromotion-countdown revealOnScroll animated fadeInUp d-sm-none" data-animation="fadeInUp" data-promotioncountdown="{$item.data_end|escape:'htmlall':'UTF-8'}"></div>
                                    <div class="bonpromotion-countdown-btn-wrapper revealOnScroll animated fadeInUp" data-animation="fadeInUp">
                                        <span class="padding-primary btn btn-primary">{l s='Shop Now!' mod='bonpromotion'}</span>
                                    </div>
                                </div>
                                <div class="box-timer">
                                    <div class="bonpromotion-countdown revealOnScroll animated fadeInUp d-none d-sm-flex" data-animation="fadeInUp" data-promotioncountdown="{$item.data_end|escape:'htmlall':'UTF-8'}"></div>
                                </div>
                            </a>
                        </li>                     
                    {/if}
                {/if}   
            {/foreach}
        </ul>
    </section>
{/if}
