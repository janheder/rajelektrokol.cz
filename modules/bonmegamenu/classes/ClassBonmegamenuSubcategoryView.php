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

class ClassBonmegamenuSubcategoryView extends ObjectModel
{
    public $id_sub;
    public $id_tab;
    public $id_shop;
    public $status;
    public $id_category;
    public $sort_order;
    public $column_width;
    public $view_type;
    public $enable_category_description;

    public static $definition = array(
        'table' => 'bonmegamenu_sub_view',
        'primary' => 'id_sub',
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_tab' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'column_width' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'view_type' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'id_category' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'enable_category_description' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
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
        $sql = 'SELECT bons.*
                FROM ' . _DB_PREFIX_ . 'bonmegamenu_sub_view bons
                WHERE bons.id_tab =' . (int)$id_tab . '
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
            FROM `' . _DB_PREFIX_ . 'bonmegamenu_sub_view`
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
                FROM ' . _DB_PREFIX_ . 'bonmegamenu_sub_view bons
                WHERE bons.id_tab =' . (int)$id_tab;

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
