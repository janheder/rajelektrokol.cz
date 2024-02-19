{**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Call
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
 * @author    Bonpresta
 * @copyright 2015-2020 Bonpresta
 * @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 *}

<section id="btn-boncall">
    <button class="boncall-open {$bon_call_position}">
        <div class="boncall-open_img">
        {* <i class="fl-outicons-phone14"></i> *}
        </div>
    </button>
    <div class="boncall-wrapper {$bon_call_position}">
        <div class="boncall-header-title">
            <p>{l s='Call Our Store' mod='boncall'}</p>
        </div>
        <div class="boncall-body">
        <p>
        <a href="tel:{$bon_call_phone|escape:'htmlall':'UTF-8'}" class="boncall-link-phone">
            <i class="fl-outicons-phone14"></i><span>{$bon_call_phone|escape:'htmlall':'UTF-8'}</span>
        </a>
    </p>

    {if $bon_call_email_display && $bon_call_email}
        <p>
            <a class="boncall-link-email" href="mailto:{$bon_call_email}">
                <i class="fl-outicons-mail2"></i>{$bon_call_email}
            </a>
        </p>
    {/if}
    <form method="post" class="boncall_form" action="#">
        <fieldset>
            <div class="clearfix">
                <p class="boncall-title">{l s='Working hours of our store:' mod='boncall'}</p>
                <div class="wh">
                    <div class="wh-d">
                        <p>{l s='On weekdays:' mod='boncall'}</p>
                        <p>{l s='Saturday:' mod='boncall'}</p>
                        <p>{l s='Sunday:' mod='boncall'}</p>
                    </div>
                    <div class="wh-t">
                        <p>{l s='from 8:00 to 21:00' mod='boncall'}</p>
                        <p>{l s='from 9:00 to 20:00' mod='boncall'}</p>
                        <p>{l s='from 10:00 to 19:00' mod='boncall'}</p>
                    </div>
                </div>

                <div class="form-group bon_call_box">
                    <label for="bon_call_name">{l s='Your name' mod='boncall'}: <sup>*</sup></label>
                    <input class="form-control" type="text" id="bon_call_name" name="bon_call_name" />
                </div>

                <div class="form-group bon_call_box">
                    <label for="bon_call_email">{l s='Your email' mod='boncall'}: <sup>*</sup></label>
                    <input class="form-control" type="text" id="bon_call_email" name="bon_call_mail" value="" />
                </div>

                <div class="form-group bon_call_box">
                    <label for="bon_call_phone">{l s='Your phone number' mod='boncall'}:
                        <sup>*</sup></label>
                    <input class="form-control" type="text" id="bon_call_phone" name="bon_call_phone" />
                </div>

                <div class="bon-call-success"></div>

            </div>
            <div class="submit">
                <input type="submit" class="btn btn-primary button button-small boncall_send"
                    value="{l s='Wait call' mod='boncall'}" />
            </div>
        </fieldset>
    </form>
        </div>
       

    </div>



</section>