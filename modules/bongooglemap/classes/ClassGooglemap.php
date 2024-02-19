<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Google Map
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

if (!defined('_PS_VERSION_')) {
    exit;
}

class ClassGooglemap extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $status;
    public $image;
    public $id_store;
    public $content;

    public static $definition = array(
        'table' => 'bongooglemap',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_store' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'id_shop' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'image' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255),
            'content' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),

        ),
    );

    public static function getGooglemapList()
    {
        if (_PS_VERSION_ >= 1.7) {
            $sql = 'SELECT bgm.*, s.`name`
            FROM ' . _DB_PREFIX_ . 'bongooglemap bgm
			LEFT JOIN ' . _DB_PREFIX_ . 'store_lang s
			ON(bgm.`id_store` = s.`id_store`)
			WHERE bgm.`id_shop` = ' . (int)Context::getContext()->shop->id . '
			AND s.`id_lang` = ' . (int)Context::getContext()->language->id . '
			ORDER BY bgm.`id_tab`';
        } else {
            $sql = 'SELECT bgm.*, s.`name`
            FROM ' . _DB_PREFIX_ . 'bongooglemap bgm
			LEFT JOIN ' . _DB_PREFIX_ . 'store s
			ON(bgm.`id_store` = s.`id_store`)
			WHERE bgm.`id_shop` = ' . (int)Context::getContext()->shop->id . '
			ORDER BY bgm.`id_tab`';
        }
        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }
    
    public static function getInfoStore()
    {
        if (_PS_VERSION_ >= 1.7) {
            $sql = 'SELECT bgm.*, s.`name` , bgml.`content`
                FROM ' . _DB_PREFIX_ . 'bongooglemap bgm
                LEFT JOIN ' . _DB_PREFIX_ . 'store_lang s
                ON(bgm.`id_store` = s.`id_store`)
                LEFT JOIN ' . _DB_PREFIX_ . 'bongooglemap_lang bgml
                ON(bgm.`id_tab` = bgml.`id_tab`)
                WHERE bgm.`id_shop` = ' . (int)Context::getContext()->shop->id . '
                AND bgm.`id_shop` = ' . (int)Context::getContext()->shop->id . '
                AND bgml.`id_lang` = ' . (int)Context::getContext()->language->id . '
                AND s.`id_lang` = ' . (int)Context::getContext()->language->id . '
                AND bgm.`status` = 1
                ORDER BY bgm.`id_tab`';
        } else {
            $sql = 'SELECT bgm.*, s.`name` , bgml.`content`
                FROM ' . _DB_PREFIX_ . 'bongooglemap bgm
                LEFT JOIN ' . _DB_PREFIX_ . 'store s
                ON(bgm.`id_store` = s.`id_store`)
                LEFT JOIN ' . _DB_PREFIX_ . 'bongooglemap_lang bgml
                ON(bgm.`id_tab` = bgml.`id_tab`)
                WHERE bgm.`id_shop` = ' . (int)Context::getContext()->shop->id . '
                AND bgm.`id_shop` = ' . (int)Context::getContext()->shop->id . '
                AND bgml.`id_lang` = ' . (int)Context::getContext()->language->id . '
                AND bgm.`status` = 1
                AND s.`active` = 1
                ORDER BY bgm.`id_tab`';
        }

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getIdStore($id)
    {
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bongooglemap
                WHERE `id_store` = '.(int)$id;

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getStoresId()
    {
        if (_PS_VERSION_ >= 1.7) {
            $sql = 'SELECT s.`id_store`, s.`name`
            FROM ' . _DB_PREFIX_ . 'store_lang s
            LEFT JOIN ' . _DB_PREFIX_ . 'store_shop ss
            ON(s.`id_store` = ss.`id_store`)
            WHERE ss.`id_shop` = ' . (int)Context::getContext()->shop->id.'
            AND s.`id_lang` = ' . (int)Context::getContext()->language->id;
        } else {
            $sql = 'SELECT s.`id_store`, s.`name`
            FROM ' . _DB_PREFIX_ . 'store s
            LEFT JOIN ' . _DB_PREFIX_ . 'store_shop ss
            ON(s.`id_store` = ss.`id_store`)
            WHERE ss.`id_shop` = ' . (int)Context::getContext()->shop->id;
        }
        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }
}
