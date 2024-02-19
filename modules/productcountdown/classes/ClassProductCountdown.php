<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Discounts with Countdown
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

class ClassProductCountdown extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $id_product;
    public $data_start;
    public $data_end;
    public $status;
    public $sort_order;
    public $id_specific_price;
    public $discount_price;
    public $reduction_type;
    public $reduction_tax;

    public static $definition = array(
        'table' => 'productcountdown',
        'primary' => 'id_tab',
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
            'data_start' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'data_end' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'id_specific_price' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'size' => 128),
            'discount_price' => array('type' => self::TYPE_FLOAT,  'validate' => 'isUnsignedFloat', 'required' => true),
            'reduction_type' => array('type' => self::TYPE_STRING, 'validate' => 'isReductionType', 'required' => true),
            'reduction_tax' => array('type' => self::TYPE_INT, 'validate' => 'isBool', 'required' => true),
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

    public static function getProductCountdownList()
    {
        $sql = 'SELECT pc.*, ppl.`link_rewrite`
                FROM '._DB_PREFIX_.'productcountdown pc
                JOIN '._DB_PREFIX_.'product_lang ppl
                ON (ppl.`id_product` = pc.`id_product`)
                WHERE pc.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND ppl.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND ppl.`id_shop` = '.(int)Context::getContext()->shop->id.'
                ORDER BY pc.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `'._DB_PREFIX_.'productcountdown`
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

    public static function getFrontItems($id_product, $id_shop, $only_active = false)
    {
        $now = date('Y-m-d H:i:00');

        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'productcountdown pc
                WHERE pc.`id_product` = '.(int)$id_product.'
                AND pc.`data_end` >= \''.$now.'\'
                AND pc.`data_start` <= \''.$now.'\'
                AND pc.id_shop ='.(int)$id_shop;

        if ($only_active) {
            $sql .= ' AND `status` = 1';
        }

        $sql .= ' ORDER BY `sort_order`';

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }

        return $result;
    }
}
