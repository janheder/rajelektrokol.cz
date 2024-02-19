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

class ClassBonmegamenuSubcategoryLabel extends ObjectModel
{
    public $id_sub;
    public $id_tab;
    public $id_shop;
    public $title;
    public $status;
    public $id_category;
    public $sort_order;
    public $label_switch_icon;
    public $label_name;
    public $type_label;
    public $label_bg_color;
    public $label_text_color;
    public $switch_icon;
    public $type_icon;
    public $icon;
    public $icon_color;
    public $icon_font_size;
    public $label_font_size;

    public static $definition = array(
        'table' => 'bonmegamenu_sub_label',
        'primary' => 'id_sub',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_tab' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'label_name' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml','size' => 255),
            'id_category' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'label_switch_icon' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'type_label' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'label_bg_color' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'label_text_color' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'switch_icon' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'type_icon' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'icon' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'icon_color' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'label_font_size' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'icon_font_size' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
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
        $sql = 'SELECT bons.*, bonsl.`title` 
                FROM ' . _DB_PREFIX_ . 'bonmegamenu_sub_label bons
                JOIN ' . _DB_PREFIX_ . 'bonmegamenu_sub_label_lang bonsl
                ON (bons.`id_sub` = bonsl.`id_sub`)
                WHERE bons.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND bons.id_tab =' . (int)$id_tab . '
                AND bonsl.`id_lang` = ' . (int)Context::getContext()->language->id . '
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
            FROM `' . _DB_PREFIX_ . 'bonmegamenu_sub_label`
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
                FROM ' . _DB_PREFIX_ . 'bonmegamenu_sub_label bons
                JOIN ' . _DB_PREFIX_ . 'bonmegamenu_sub_label_lang bonsl
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
}
