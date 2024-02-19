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

class ClassBonlookbookfwPoint extends ObjectModel
{
    public $id_sub;
    public $id_tab;
    public $id_shop;
    public $top;
    public $id_product;
    public $left;
    public $status;
    public $sort_order;
    public $title;
    public $description;

    public static $definition = array(
        'table' => 'bonlookbookfw_point',
        'primary' => 'id_sub',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_tab' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'title' => array('type' => self::TYPE_STRING,
                'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'top' => array('type' => self::TYPE_INT, 'required' => true),
            'left' => array('type' => self::TYPE_INT, 'required' => true),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt')
        ),
    );

    public function delete()
    {
        $res = true;
        $res &= parent::delete();

        return $res;
    }

    public static function getProductName($id_product)
    {
        $sql = 'SELECT pl.`name`
				FROM '._DB_PREFIX_.'product_lang pl
				WHERE `id_product` = '.(int)$id_product.'
				AND pl.`id_shop` = '.(int)Context::getContext()->shop->id;
        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getProductLinkRewrite($id_product)
    {
        $sql = 'SELECT pl.`link_rewrite`
				FROM '._DB_PREFIX_.'product_lang pl
				WHERE `id_product` = '.(int)$id_product.'
				AND pl.`id_shop` = '.(int)Context::getContext()->shop->id;
        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getBonlookbookfwPointList($id_tab)
    {
        $sql = 'SELECT bonl.*
                FROM ' . _DB_PREFIX_ . 'bonlookbookfw_point bonl
                JOIN ' . _DB_PREFIX_ . 'bonlookbookfw_point_lang bonlb
                ON (bonl.`id_sub` = bonlb.`id_sub`)
                AND bonl.id_tab =' . (int)$id_tab . '
                AND bonlb.`id_lang` = ' . (int)Context::getContext()->language->id . '
                ORDER BY bonl.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_tab)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `' . _DB_PREFIX_ . 'bonlookbookfw_point`
            WHERE id_tab = ' . (int)$id_tab);

        if (!$result) {
            return false;
        }

        foreach ($result as $res) {
            $result = $res['sort_order'];
        }

        $result = $result + 1;

        return $result;
    }

    public static function getTopFrontItems($id_tab, $only_active = false)
    {
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonlookbookfw_point bonl
                JOIN ' . _DB_PREFIX_ . 'bonlookbookfw_point_lang bonlb
                ON bonl.id_sub = bonlb.id_sub
                AND bonlb.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bonl.id_tab =' . (int)$id_tab;

        if ($only_active) {
            $sql .= ' AND `status` = 1';
        }
        $sql .= ' ORDER BY `sort_order`';

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }

        return $result;
    }
    public static function getTopMainItems($id_tab, $only_active = false, $offset = 0, $limit = 2)
    {
        $now = date('Y-m-d H:i:00');
        
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonlookbookfw_point bonl
                JOIN ' . _DB_PREFIX_ . 'bonlookbookfw_point_lang bonlb
                ON bonl.id_sub = bonlb.id_sub
                AND bonlb.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bonl.id_tab =' . (int)$id_tab;

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
