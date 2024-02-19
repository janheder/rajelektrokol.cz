<?php

/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Lookbook gallery with products and slider
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

if (!defined('_PS_VERSION_')) {
    exit;
}

class ClassBonlookbookfw extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $image;
    public $description;
    public $status;
    public $sort_order;

    public static $definition = array(
        'table' => 'bonlookbookfw',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING,
                'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'image' => array('type' => self::TYPE_STRING,
                'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
        ),
    );

    public function delete()
    {
        $res = true;
        $image = $this->image;

        if ($image) {
            if ($image && file_exists(_PS_MODULE_DIR_ . 'bonlookbookfw/views/img/' . $image)) {
                $res &= @unlink(_PS_MODULE_DIR_ . 'bonlookbookfw/views/img/' . $image);
            }
        }

        $res &= parent::delete();
        return $res;
    }

    public static function getBonlookbookfwList()
    {
        $sql = 'SELECT bonl.*, bonlb.`title`
                FROM ' . _DB_PREFIX_ . 'bonlookbookfw bonl
                JOIN ' . _DB_PREFIX_ . 'bonlookbookfw_lang bonlb
                ON (bonl.`id_tab` = bonlb.`id_tab`)
                AND bonl.`id_shop` = ' . (int)Context::getContext()->shop->id . '
                AND bonlb.`id_lang` = ' . (int)Context::getContext()->language->id . '
                ORDER BY bonl.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `' . _DB_PREFIX_ . 'bonlookbookfw`
            WHERE id_shop = ' . (int)$id_shop);

        if (!$result) {
            return false;
        }

        foreach ($result as $res) {
            $result = $res['sort_order'];
        }

        $result = $result + 1;

        return $result;
    }

    public static function getTopFrontItems($id_shop, $only_active = false)
    {
        $now = date('Y-m-d H:i:00');
        
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonlookbookfw bonl
                JOIN ' . _DB_PREFIX_ . 'bonlookbookfw_lang bonlb
                ON bonl.id_tab = bonlb.id_tab
                AND bonlb.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bonl.id_shop =' . (int)$id_shop;

        if ($only_active) {
            $sql .= ' AND `status` = 1';
        }
        $sql .= ' ORDER BY `sort_order`';

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }

        return $result;
    }
    
    public function getTopMainItems($id_shop, $only_active = false, $offset = 0, $limit = 2)
    {
        $now = date('Y-m-d H:i:00');
        
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonlookbookfw bonl
                JOIN ' . _DB_PREFIX_ . 'bonlookbookfw_lang bonlb
                ON bonl.id_tab = bonlb.id_tab
                AND bonlb.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bonl.id_shop =' . (int)$id_shop;

        if ($only_active) {
            $sql .= ' AND `status` = 1';
        }
        $sql .= ' ORDER BY `sort_order` DESC LIMIT ' .  (int)$offset . ', ' . (int)$limit;

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }

        return $result;
    }
}
