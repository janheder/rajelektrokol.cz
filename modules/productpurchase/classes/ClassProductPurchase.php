<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Trends
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

class ClassProductPurchase extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $time;
    public $status;
    public $id_product;
    public $data_start;
    public $data_end;
    public $sort_order;

    public static $definition = array(
        'table' => 'productpurchase',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
            'time' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
            'data_start' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'data_end' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt')
        ),
    );


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

    public static function getProductPurchaseList()
    {
        $sql = 'SELECT pl.*, pll.`title`, ppl.`link_rewrite`
                FROM '._DB_PREFIX_.'productpurchase pl
                JOIN '._DB_PREFIX_.'product_lang ppl
                ON (ppl.`id_product` = pl.`id_product`)
                JOIN '._DB_PREFIX_.'productpurchase_lang pll
                ON (pl.`id_tab` = pll.`id_tab`)
                WHERE pl.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND pll.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND ppl.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND ppl.`id_shop` = '.(int)Context::getContext()->shop->id.'
                ORDER BY pl.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `'._DB_PREFIX_.'productpurchase`
            WHERE id_shop = '.(int)$id_shop);

        if (!$result) {
            return false;
        }

        foreach ($result as $res) {
            $result = $res['sort_order'];
        }

        $result = $result + 1;

        return $result;
    }

    public static function getFrontItems()
    {
        $now = date('Y-m-d H:i:00');

           $sql = 'SELECT pl.*, pll.`title`, pll.`time`
                FROM ' . _DB_PREFIX_ . 'productpurchase pl
                JOIN ' . _DB_PREFIX_ . 'productpurchase_lang pll
                ON pl.id_tab = pll.id_tab
                WHERE pl.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND pll.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND pl.`data_end` >= \''.$now.'\'
                AND pl.`data_start` <= \''.$now.'\'
                AND pl.`status` = 1';


        $sql .= ' ORDER BY `sort_order`';

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }

        return $result;
    }
}
