<?php
/**
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
 *  @author    Bonpresta
 *  @copyright 2015-2020 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

require_once('../../../../config/config.inc.php');
require_once('../../../../init.php');
include_once(_PS_MODULE_DIR_.'boncall/classes/ClassNewsletterCall.php');
include_once(_PS_MODULE_DIR_.'boncall/boncall.php');

$module = new Boncall();
if (Configuration::get('PS_TOKEN_ENABLE') == 1 &&
    strcmp(Tools::getToken(false), Tools::getValue('token')) &&
    Tools::getToken(false) == Tools::getValue('static_token') &&
    Tools::getValue('ajax') == 1) {
    $email = pSQL(trim(Tools::getValue('boncall_newsletter_email', '')));
    $check = ClassNewsletterCall::isNewsletterRegistered($email);
    if (Tools::isEmpty($email) || !Validate::isEmail($email)) {
        die(json_encode(array('success' => 3, 'error' => $module->invalidAdress)));
    } else {
        if ($check > 0) {
            die(json_encode(array('success' => 1, 'error' => $module->adressRegistered)));
        } else {
            if (!ClassNewsletterCall::isRegistered($check)) {
                if (Configuration::get('NW_VERIFICATION_EMAIL')) {
                    if ($check == ClassNewsletterCall::GUEST_NOT_REGISTERED) {
                        ClassNewsletterCall::registerGuest($email, false);
                    }
                } else {
                    ClassNewsletterCall::register($email, $check);
                }
                die(json_encode(array('success' => 0, 'error' => $module->successfullySubscrib)));
            }
        }
    }
}
