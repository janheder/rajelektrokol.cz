<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta News Manager with Videos and Comments
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

class ClassBonnews extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $image;
    public $cover;
    public $author_img;
    public $description;
    public $content_post;
    public $status;
    public $sort_order;
    public $url;
    public $type;
    public $date_post;
    public $author_name;

    public static $definition = array(
        'table' => 'bonnews',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'image' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
            'cover' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
            'author_img' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => true, 'size' => 255),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
            'content_post' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'author_name' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'date_post' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function delete()
    {
        $res = true;
        $images = $this->image;

        if ($images) {
            foreach ($images as $image) {
                if ($image && file_exists(_PS_MODULE_DIR_ . 'bonnews/views/img/' . $image)) {
                    $res &= @unlink(_PS_MODULE_DIR_ . 'bonnews/views/img/' . $image);
                }
            }
        }

        $res &= parent::delete();
        return $res;
    }

    public static function getBonnewsList()
    {
        $sql = 'SELECT bonn.*, bonnl.`title`, bonnl.`url`, bonnl.`image`
                FROM ' . _DB_PREFIX_ . 'bonnews bonn
                JOIN ' . _DB_PREFIX_ . 'bonnews_lang bonnl
                ON (bonn.`id_tab` = bonnl.`id_tab`)
                AND bonn.`id_shop` = ' . (int)Context::getContext()->shop->id . '
                AND bonnl.`id_lang` = ' . (int)Context::getContext()->language->id . '
                ORDER BY bonn.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `' . _DB_PREFIX_ . 'bonnews`
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
                FROM ' . _DB_PREFIX_ . 'bonnews bonn
                JOIN ' . _DB_PREFIX_ . 'bonnews_lang bonnl
                ON bonn.id_tab = bonnl.id_tab
                AND bonnl.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bonn.`date_post` <= \'' . $now . '\'
                AND bonn.id_shop =' . (int)$id_shop;

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
                FROM ' . _DB_PREFIX_ . 'bonnews bonn
                JOIN ' . _DB_PREFIX_ . 'bonnews_lang bonnl
                ON bonn.id_tab = bonnl.id_tab
                AND bonnl.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bonn.`date_post` <= \'' . $now . '\'
                AND bonn.id_shop =' . (int)$id_shop;

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
