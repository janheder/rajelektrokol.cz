<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Category Products with Tabs and Carousel on Home Page
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

class ClassBoncategoryproduct extends ObjectModel
{
    public $id_shop;
    public $id_category;
    public $sort_order;
    public $status;
    public $title;

    public static $definition = array(
        'table'  => 'boncategoryproduct',
        'primary' => 'id_item',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_category'=> array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'title' => array('type' => self::TYPE_STRING,
                'lang' => true, 'size' => 255),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
        ),
    );

    public function delete()
    {
        $res = true;

        $res &= parent::delete();
        return $res;
    }

    public static function getCategoryList()
    {
        $sql = 'SELECT pc.*, cl.`name`
                FROM '._DB_PREFIX_.'boncategoryproduct pc
                LEFT JOIN '._DB_PREFIX_.'boncategoryproduct_lang pcl
                ON (pc.`id_item` = pcl.`id_item`)
                LEFT JOIN '._DB_PREFIX_.'category_lang cl
                ON (pc.`id_category` = cl.`id_category`)
                WHERE cl.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND cl.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND pcl.`id_lang` = '.(int)Context::getContext()->language->id.'
                ORDER BY pc.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getFrontCategory()
    {
        $sql = 'SELECT pc.*, cl.`name`, pcl.`title`
                FROM '._DB_PREFIX_.'boncategoryproduct pc
                LEFT JOIN '._DB_PREFIX_.'boncategoryproduct_lang pcl
                ON (pc.`id_item` = pcl.`id_item`)
                LEFT JOIN '._DB_PREFIX_.'category_lang cl
                ON (pc.`id_category` = cl.`id_category`)
                WHERE cl.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND cl.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND pcl.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND pc.`status` = 1
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
            FROM `'._DB_PREFIX_.'boncategoryproduct`
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

    public static function getDeletedCategory($id_category)
    {
        $data = array();

        $sql = 'SELECT `id_item`
                FROM '._DB_PREFIX_.'boncategoryproduct
                WHERE `id_category` = '.(int)$id_category;

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        foreach ($result as $res) {
            $data[] = $res['id_item'];
        }

        return $data;
    }
}
