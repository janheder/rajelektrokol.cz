{*
 * 2015-2017 Bonpresta
 *
 * Bonpresta Facebook Like Box
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

{if isset($configurations.status) && $configurations.status}
    <section class="footer-block col-xs-12 col-sm-4">
        <h4>{l s='Folow Us' mod='facebookwidget'}</h4>
        <div class="block_content toggle-footer">
            <div id="fb-root"></div>
            <div class="facebook-likebox">
                <div class="fb-page"
                     data-href="{$configurations.name|escape:'htmlall':'UTF-8'}"
                     data-tabs="{$configurations.tabs|escape:'htmlall':'UTF-8'}"
                     data-width="{$configurations.width|escape:'htmlall':'UTF-8'}"
                     data-height="{$configurations.height|escape:'htmlall':'UTF-8'}"
                     data-adapt-container-width="true"
                     data-small-header="{if $configurations.header}true{else}false{/if}"
                     data-show-facepile="{if $configurations.faces}true{else}false{/if}"
                     data-hide-cover="{if $configurations.cover}true{else}false{/if}">
                    <div class="fb-xfbml-parse-ignore"></div>
                </div>
            </div>
        </div>
    </section>
{/if}



