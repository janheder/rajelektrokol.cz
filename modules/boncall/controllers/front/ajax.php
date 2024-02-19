<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Quick Question
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
 */

require_once('../../../../config/config.inc.php');
require_once('../../../../init.php');
require_once(_PS_MODULE_DIR_.'/boncall/boncall.php');

$module = new Boncall();

if (Configuration::get('PS_TOKEN_ENABLE') == 1 &&
    strcmp(Tools::getToken(false), Tools::getValue('token')) &&
    Tools::getToken(false) == Tools::getValue('static_token_bon_call') &&
    Tools::getValue('ajax') == 1) {
        $bon_call_name = pSQL(trim(Tools::getValue('bon_call_name', '')));
        $bon_call_phone = pSQL(trim(Tools::getValue('bon_call_phone', '')));
        $bon_call_mail = pSQL(trim(Tools::getValue('bon_call_mail', '')));
        $bon_call = Module::getInstanceByName('boncall');
    if (Tools::isEmpty($bon_call_name) || !Validate::isGenericName($bon_call_name)) {
        die(json_encode(array(
            'success' => 3,
            'error' => $module->invalidName
        )));
    } elseif (Tools::isEmpty($bon_call_mail) || !Validate::isEmail($bon_call_mail)) {
        die(json_encode(array(
            'success' => 4,
            'error' => $module->invalidEmail
        )));
    } elseif (Tools::isEmpty($bon_call_phone) || !Validate::isPhoneNumber($bon_call_phone)) {
        die(json_encode(array(
            'success' => 2,
            'error' => $module->invalidPhone
        )));
    } else {
        Context::getContext()->cookie->bon_call_phone = $bon_call_phone;
        Context::getContext()->cookie->bon_call_mail = $bon_call_mail;
        Context::getContext()->cookie->bon_call_name = $bon_call_name;
        $template = 'boncall';
        $template_vars = array(
            '{name}' => $bon_call_name,
            '{bonemail}' => $bon_call_mail,
            '{phone}' => $bon_call_phone
        );
        $email = Configuration::get('BON_CALL_EMAIL');
        
        $to = array(
            $email
        );
        
        if (!Mail::Send((int) Configuration::get('PS_LANG_DEFAULT'), $template, $bon_call->l('Call Back', 'ajax'), $template_vars, $to, null, Configuration::get('BON_CALL_EMAIL'), Configuration::get('PS_SHOP_NAME'), null, null, dirname(__FILE__) . '/mails/')) {
            die(json_encode(array(
                'success' => 1,
                'alert' => $module->successAlert
            )));
        } else {
            die(json_encode(array(
                'success' => 1,
                'alert' => $module->successAlert
            )));
        }
    }
}
