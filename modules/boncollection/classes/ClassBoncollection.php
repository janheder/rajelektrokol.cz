<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Collection Manager with Photos and Videos
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

class ClassBoncollection extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $image;
    public $author_img;
    public $description;
    public $status;
    public $sort_order;
    public $url;
    public $date_public;
    public $author_name;

    public static $definition = array(
        'table' => 'boncollection',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'image' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
            'author_img' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => true, 'size' => 255),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'author_name' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'date_public' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function delete()
    {
        $res = true;
        $images = $this->image;

        if ($images) {
            foreach ($images as $image) {
                if ($image && file_exists(_PS_MODULE_DIR_ . 'boncollection/views/img/' . $image)) {
                    $res &= @unlink(_PS_MODULE_DIR_ . 'boncollection/views/img/' . $image);
                }
            }
        }

        $res &= parent::delete();
        return $res;
    }

    public static function getBoncollectionCategoryList()
    {
        $sql = 'SELECT bonc.*, boncl.`title`, boncl.`url`, boncl.`image`
                FROM ' . _DB_PREFIX_ . 'boncollection bonc
                JOIN ' . _DB_PREFIX_ . 'boncollection_lang boncl
                ON (bonc.`id_tab` = boncl.`id_tab`)
                AND bonc.`id_shop` = ' . (int)Context::getContext()->shop->id . '
                AND boncl.`id_lang` = ' . (int)Context::getContext()->language->id . '
                ORDER BY bonc.`sort_order` DESC';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `' . _DB_PREFIX_ . 'boncollection`
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
                FROM ' . _DB_PREFIX_ . 'boncollection bonc
                JOIN ' . _DB_PREFIX_ . 'boncollection_lang boncl
                ON bonc.id_tab = boncl.id_tab
                AND boncl.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bonc.`date_public` <= \'' . $now . '\'
                AND bonc.id_shop =' . (int)$id_shop;

        if ($only_active) {
            $sql .= ' AND `status` = 1';
        }
        $sql .= ' ORDER BY `sort_order` DESC';

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }

        return $result;
    }
    
    public function getTopMainItems($id_shop, $only_active = false, $offset = 0, $limit = 2)
    {
        $now = date('Y-m-d H:i:00');
        
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'boncollection bonc
                JOIN ' . _DB_PREFIX_ . 'boncollection_lang boncl
                ON bonc.id_tab = boncl.id_tab
                AND boncl.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bonc.`date_public` <= \'' . $now . '\'
                AND bonc.id_shop =' . (int)$id_shop;

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
