{*
* 2015-2020 Bonpresta
*
* Bonpresta Advanced Newsletter Popup
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


{if $items && isset($items)}
<div class="bon-newsletter">
    <div class="bon-newsletter-wrapper" style="background-image: url('{$image_baseurl|escape:'htmlall':'UTF-8'}{$items[0].image|escape:'htmlall':'UTF-8'}');">
        <span class="popup-close" id="close"></span>
        <div class="col-12 bon-newsletter-content">
            <div class="innerbox-newsletter">
                {if $items[0].description && isset($items[0].description)}
                <div class="newsletter-content">
                    {$items[0].description nofilter}
                </div>
                {/if}
                <form method="post" class="bonnewsletter_form" action="">
                    <fieldset>
                        <div class="clearfix">
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <input class="form-control bon_newsletter_email" type="text" id="bon_newsletter_email" name="bon_newsletter_email" placeholder="{l s='Enter your email...' mod='bonnewsletter'}" value="">
                                </div>
                                <button type="submit" class="padding-primary btn btn-primary float-xs-right bonnewsletter_send">
                                    <span>{l s='Subscribe' mod='bonnewsletter'}</span>
                                </button>
                            </div>
                            <p class="bon_newsletter_errors alert alert-danger"></p>
                            <p class="bon_newsletter_success alert alert-success"></p>
                        </div>
                    </fieldset>
                </form>
                <div class="bon-newsletter-coupon">
                    <p>{l s='Your sale coupon here!' mod='bonnewsletter'}</p>
                </div>
            </div>
            <a class="bon-newsletter-dont" href="#" id="dont-show">{l s="Don't show again"
                mod="bonnewsletter"}</a>
        </div>
    </div>
</div>
{/if}