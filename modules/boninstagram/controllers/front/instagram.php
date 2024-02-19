<?php

/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Instagram Gallery Feed Photos & Videos User
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
 *  @copyright 2015-2022 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

class BoninstagramInstagramModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $mc = new Boninstagram();
        parent::initContent();

        if (Configuration::get('BONINSTAGRAM_CACHE')) {
            $images = Configuration::get('BONINSTAGRAM_CACHE_'.$this->context->language->id);
            $date = json_decode(Configuration::get('BONINSTAGRAM_DATE_CACHE_'.$this->context->language->id));

            if ($date == '') {
                $date = true;
            } else {
                // converting the received date from a string to a date object
                $date_cache = datetime::createfromformat('Y-m-d-h-i-s', $date);
                // the current date
                $now_date = date_create_from_format('Y-m-d-h-i-s', date('Y-m-d-h-i-s'));
                // comparing dates
                $diff = (array) date_diff($date_cache, $now_date);

                if ($diff['d'] >= 1) {
                    $date = true;
                } else {
                    $date = false;
                }
            }

            if ($images == '' || $date)
            {
                // cache creation date
                $date_cache = date_create_from_format('Y-m-d-h-i-s', date('Y-m-d-h-i-s'));
                // convert date to cache entry format
                $date_cache = json_encode($date_cache->format('Y-m-d-h-i-s'));
                $images = json_encode($mc->getInstagramImages());

                Configuration::updateValue('BONINSTAGRAM_CACHE_'.$this->context->language->id, $images);
                Configuration::updateValue('BONINSTAGRAM_DATE_CACHE_'.$this->context->language->id, $date_cache);
            }

            $images = json_decode($images, true);

        } else {
            $images = $mc->getInstagramImages();
        }

        if (Configuration::get('BONINSTAGRAM_DISPLAY')) {
            $this->context->smarty->assign('limit', Configuration::get('BONINSTAGRAM_LIMIT'));
            $this->context->smarty->assign('instagram_type', Configuration::get('BONINSTAGRAM_TYPE'));
            $this->context->smarty->assign('display_carousel', Configuration::get('BONINSTAGRAM_DISPLAY_CAROUSEL'));
            $this->context->smarty->assign('user_tag', Configuration::get('BONINSTAGRAM_TAG'));
            $this->context->smarty->assign('show_user', Configuration::get('BONINSTAGRAM_USER'));
            $this->context->smarty->assign('show_date', Configuration::get('BONINSTAGRAM_DATE'));
            $this->context->smarty->assign('show_icon', Configuration::get('BONINSTAGRAM_ICON'));
            $this->context->smarty->assign('user_id', Configuration::get('BONINSTAGRAM_USERID'));
            $this->context->smarty->assign('images', $images);
        }
        $this->context->smarty->assign('baseurl', _MODULE_DIR_ . '/boninstagram/views/');

        if (_PS_VERSION_ >= 1.7) {
            $this->setTemplate('module:boninstagram/views/templates/front/instagram_1_7.tpl');
        } else {
            $this->setTemplate('instagram.tpl');
        }
    }
}
