<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Customer Reassurance With Icons
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
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class ClassBonreassurance extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $description;
    public $status;
    public $sort_order;
    public $url;
    public $specific_class;
    public $icon;
    public $type_icon;
    public $font_color;
    public $font_size;

    public static $definition = array(
        'table' => 'bonreassurance',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'type_icon' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 128),
            'specific_class' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 128),
            'font_size' => array('type' => self::TYPE_FLOAT,  'validate' => 'isUnsignedFloat', 'required' => true),
            'font_color' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 128),
            'icon' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 128),
        ),
    );

    public static function getBonreassuranceList()
    {
        $sql = 'SELECT bonr.*, bonrl.`title`, bonrl.`url`
                FROM '._DB_PREFIX_.'bonreassurance bonr
                JOIN '._DB_PREFIX_.'bonreassurance_lang bonrl
                ON (bonr.`id_tab` = bonrl.`id_tab`)
                AND bonr.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND bonrl.`id_lang` = '.(int)Context::getContext()->language->id.'
                ORDER BY bonr.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `'._DB_PREFIX_.'bonreassurance`
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

    public static function getTopFrontItems($id_shop, $only_active = false)
    {
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonreassurance bonr
                JOIN ' . _DB_PREFIX_ . 'bonreassurance_lang bonrl
                ON bonr.id_tab = bonrl.id_tab
                AND bonrl.id_lang = '.(int)Context::getContext()->language->id.'
                AND bonr.id_shop ='.(int)$id_shop;

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
