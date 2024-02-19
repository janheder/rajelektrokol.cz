<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Video Youtube
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

class ClassProductYoutube extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $url;
    public $image;
    public $id_product;
    public $description;
    public $status;
    public $sort_order;

    public static $definition = array(
        'table' => 'productyoutube',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
            'url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 256),
            'image' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
        ),
    );

    public function delete()
    {
        $res = true;
        $images = $this->image;

        if ($images) {
            foreach ($images as $image) {
                if ($image && file_exists(_PS_MODULE_DIR_.'productyoutube/images/'.$image)) {
                    $res &= @unlink(_PS_MODULE_DIR_.'productyoutube/images/'.$image);
                }
            }
        }

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

    public static function getProductYoutubeList()
    {
        $sql = 'SELECT py.*, pyl.`title`, pyl.`url`, pl.`link_rewrite`
                FROM '._DB_PREFIX_.'productyoutube py
                JOIN '._DB_PREFIX_.'product_lang pl
                ON (pl.`id_product` = py.`id_product`)
                JOIN '._DB_PREFIX_.'productyoutube_lang pyl
                ON (py.`id_tab` = pyl.`id_tab`)
                WHERE py.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND pyl.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND pl.`id_lang` = '.(int)Context::getContext()->language->id.'
                AND pl.`id_shop` = '.(int)Context::getContext()->shop->id.'
                ORDER BY py.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `'._DB_PREFIX_.'productyoutube`
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

    public function getFrontItems($id_product, $id_shop, $only_active = false)
    {
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'productyoutube py
                JOIN ' . _DB_PREFIX_ . 'productyoutube_lang pyl
                ON py.id_tab = pyl.id_tab
                WHERE py.`id_product` = '.(int)$id_product.'
                AND pyl.id_lang = '.(int)Context::getContext()->language->id.'
                AND py.id_shop ='.(int)$id_shop;

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
