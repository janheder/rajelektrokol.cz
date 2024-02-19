<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class ClassBonmegamenuSubcategoryProduct extends ObjectModel
{
    public $id_sub;
    public $id_tab;
    public $id_shop;
    public $title;
    public $status;
    public $id_category;
    public $product_width;
    public $sort_order;
    public $id_product;

    public static $definition = array(
        'table' => 'bonmegamenu_sub_prod',
        'primary' => 'id_sub',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_tab' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'id_category' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'product_width' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
        ),
    );

    public function delete()
    {
        $res = true;
        $res &= parent::delete();
        return $res;
    }

    public static function getBonmegamenuSubcategoryList($id_tab)
    {
        $sql = 'SELECT bons.*, bonsl.`title`, bonspl.`link_rewrite`
                FROM ' . _DB_PREFIX_ . 'bonmegamenu_sub_prod bons
                JOIN '._DB_PREFIX_.'product_lang bonspl
                ON (bonspl.`id_product` = bons.`id_product`)
                JOIN ' . _DB_PREFIX_ . 'bonmegamenu_sub_prod_lang bonsl
                ON (bons.`id_sub` = bonsl.`id_sub`)
                WHERE bons.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND bons.id_tab =' . (int)$id_tab . '
                AND bonsl.`id_lang` = ' . (int)Context::getContext()->language->id . '
                AND bonspl.`id_lang` = ' . (int)Context::getContext()->language->id . '
                AND bonspl.`id_shop` = '.(int)Context::getContext()->shop->id.'
                ORDER BY bons.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_tab)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `' . _DB_PREFIX_ . 'bonmegamenu_sub_prod`
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

    public static function getTopFrontItems($id_tab, $only_active = true)
    {
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonmegamenu_sub_prod bons
                JOIN ' . _DB_PREFIX_ . 'bonmegamenu_sub_prod_lang bonsl
                ON bons.id_sub = bonsl.id_sub
                AND bonsl.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bons.id_tab =' . (int)$id_tab;

        if ($only_active) {
            $sql .= ' AND `status` = 1';
        }
        $sql .= ' ORDER BY `sort_order`';

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }

        return $result;
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
}
