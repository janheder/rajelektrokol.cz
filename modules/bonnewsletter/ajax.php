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

include_once(dirname(__FILE__) . '/../../config/config.inc.php');
include_once(dirname(__FILE__) . '/../../init.php');
include_once(_PS_MODULE_DIR_.'bonnewsletter/classes/ClassNewsletter.php');
include_once(_PS_MODULE_DIR_.'bonnewsletter/bonnewsletter.php');

$module = new Bonnewsletter();
if (Configuration::get('PS_TOKEN_ENABLE') == 1 &&
    strcmp(Tools::getToken(false), Tools::getValue('token')) &&
    Tools::getToken(false) == Tools::getValue('static_token') &&
    Tools::getValue('ajax') == 1) {
    $email = pSQL(trim(Tools::getValue('bon_newsletter_email', '')));
    $check = ClassNewsletter::isNewsletterRegistered($email);
    if (Tools::isEmpty($email) || !Validate::isEmail($email)) {
        die(json_encode(array('success' => 3, 'error' => $module->invalidAdress)));
    } else {
        if ($check > 0) {
            die(json_encode(array('success' => 1, 'error' => $module->adressRegistered)));
        } else {
            if (!ClassNewsletter::isRegistered($check)) {
                if (Configuration::get('NW_VERIFICATION_EMAIL')) {
                    if ($check == ClassNewsletter::GUEST_NOT_REGISTERED) {
                        ClassNewsletter::registerGuest($email, false);
                    }
                } else {
                    ClassNewsletter::register($email, $check);
                }
                die(json_encode(array('success' => 0, 'error' => $module->successfullySubscrib)));
            }
        }
    }
}
