{*
 * 2015-2021 Bonpresta
 *
 * Bonpresta Whatsapp Chat
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
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{if isset($items) && $items && $bonwhatsapp_enable}
	<section id="bonwhatsappchat">
		<div id="bonwhatsappchat-open" class="bonwhatsappchat-open_img {$bonwhatsapp_position}"></div>
		<div class="whatsappchat-wrapper {$bonwhatsapp_position}">
			<div class="whatsappchat-description">
				<p>{l s='Chat with us on WhatsApp' mod='bonwhatsappchat'}</p>
			</div>
			<div class="whatsappchat-body">
				<div class="row m-0">
					<span class="{$bonwhatsapp_enable} {$bonwhatsapp_position} {$bonwhatsapp_color} {$bonwhatsapp_background}"></span>
					{foreach from=$items item=item name=item}
						<div class="col-xs-12 col-sm-12 col-md-12 p-0{if isset($item.specific_class) && $item.specific_class} {$item.specific_class|escape:'htmlall':'UTF-8'}{/if}">
							{if $whatsapp_device == 'desktop'}
							<a class="whatsappchat-link" href="https://web.whatsapp.com/send?l=en&phone={$item.url|escape:'htmlall':'UTF-8'}" {if $item.blank == '1'}target="_blank"{/if}>
								{else}
								<a class="whatsappchat-link" href="https://api.whatsapp.com/send?l=en&phone={$item.url|escape:'htmlall':'UTF-8'}" {if $item.blank == '1'}target="_blank"{/if}>
									{/if}
									<img class="img-responsive" src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}" alt="{$item.title|escape:'htmlall':'UTF-8'}" />
									<div class="whatsappchat-inner">
										<h2 class="whatsappchat-title">
											{if isset($item.title) && $item.title}
												{$item.title nofilter}
											{/if}
										</h2>
										<h1 class="whatsappchat-subtitle">
											{if isset($item.subtitle) && $item.subtitle}
												{$item.subtitle nofilter}
											{/if}
										</h1>
										<h3 class="whatsappchat-descr">
											{if isset($item.description) && $item.description}
												{$item.description nofilter}
											{/if}
										</h3>
									</div>
								</a>
						</div>
					{/foreach}
				</div>
			</div>
		</div>
	</section>
{/if}