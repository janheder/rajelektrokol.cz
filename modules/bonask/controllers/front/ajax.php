<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Bonask
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
require_once(_PS_MODULE_DIR_.'/bonask/bonask.php');

$module = new Bonask();

if (Configuration::get('PS_TOKEN_ENABLE') == 1 &&
    strcmp(Tools::getToken(false), Tools::getValue('token')) &&
    Tools::getToken(false) == Tools::getValue('static_token_bon_ask') &&
    Tools::getValue('ajax') == 1) {
    $bon_ask_name = pSQL(trim(Tools::getValue('bon_ask_name', '')));
    $bon_ask_phone = pSQL(trim(Tools::getValue('bon_ask_phone', '')));
    $bon_ask_mail = pSQL(trim(Tools::getValue('bon_ask_mail', '')));
    $bon_ask_question = pSQL(trim(Tools::getValue('bon_ask_question', '')));
    $id_product = (int)trim(Tools::getValue('bon_ask_id_product', ''));
    $product = new Product($id_product);
    $bon_ask = Module::getInstanceByName('bonask');

    if (Tools::isEmpty($bon_ask_name) || !Validate::isGenericName($bon_ask_name)) {
        die(json_encode(array('success' => 3, 'error' => $module->invalidName)));
    } elseif (Tools::isEmpty($bon_ask_phone) || !Validate::isPhoneNumber($bon_ask_phone)) {
        die(json_encode(array('success' => 2, 'error' => $module->invalidPhone)));
    } elseif (Tools::isEmpty($bon_ask_mail) || !Validate::isEmail($bon_ask_mail)) {
            die(json_encode(array('success' => 4, 'error' => $module->invalidEmail)));
    } elseif (Tools::isEmpty($bon_ask_question)) {
        die(json_encode(array('success' => 5, 'error' => $module->invalidQuestion)));
    } else {
        Context::getContext()->cookie->bon_ask_phone = $bon_ask_phone;
        Context::getContext()->cookie->bon_ask_mail = $bon_ask_mail;
        Context::getContext()->cookie->bon_ask_name = $bon_ask_name;
        Context::getContext()->cookie->bon_ask_question = $bon_ask_question;
        $template = 'bonask';
        $template_vars = array(
            '{name}' => $bon_ask_name,
            '{bonemail}' => $bon_ask_mail,
            '{phone}' => $bon_ask_phone,
            '{question}' => $bon_ask_question,
            '{product_name}' => Product::getProductName($id_product) . ', ' . $product->reference,
            '{product_link}' => Context::getContext()->link->getProductLink($id_product),
        );
        $email = Configuration::get('BON_ASK_EMAIL');

        $to = array(
            $email,
        );

        if (!Mail::Send(
            (int)Configuration::get('PS_LANG_DEFAULT'),
            $template,
            $bon_ask->l('ASK', 'ajax'),
            $template_vars,
            $to,
            null,
            Configuration::get('BON_ASK_EMAIL'),
            Configuration::get('PS_SHOP_NAME'),
            null,
            null,
            dirname(__FILE__) . '/mails/'
        )) {
            die(json_encode(array('success' => 1, 'alert' => $module->successAlert)));
        } else {
            die(json_encode(array('success' => 1, 'alert' => $module->successAlert)));
        }
    }
}
