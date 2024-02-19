<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Information Banner
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

class InfoBan extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $image;
    public $cover;
    public $description;
    public $status;
    public $sort_order;
    public $url;
    public $type;
    
    public static $definition = array(
        'table' => 'boninfoban',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'image' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
            'cover' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
            'url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => true, 'size' => 255),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 255),
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
                if ($image && file_exists(_PS_MODULE_DIR_.'boninfoban/views/img/'.$image)) {
                    $res &= @unlink(_PS_MODULE_DIR_.'boninfoban/views/img/'.$image);
                }
            }
        }

        $res &= parent::delete();
        return $res;
    }

    public static function getInfoBanList()
    {
        $sql = 'SELECT bonb.*, bonbl.`title`, bonbl.`url`, bonbl.`image`
                FROM '._DB_PREFIX_.'boninfoban bonb
                JOIN '._DB_PREFIX_.'boninfoban_lang bonbl
                ON (bonb.`id_tab` = bonbl.`id_tab`)
                AND bonb.`id_shop` = '.(int)Context::getContext()->shop->id.'
                AND bonbl.`id_lang` = '.(int)Context::getContext()->language->id.'
                ORDER BY bonb.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `'._DB_PREFIX_.'boninfoban`
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
                FROM ' . _DB_PREFIX_ . 'boninfoban bonb
                JOIN ' . _DB_PREFIX_ . 'boninfoban_lang bonbl
                ON bonb.id_tab = bonbl.id_tab
                AND bonbl.id_lang = '.(int)Context::getContext()->language->id.'
                AND bonb.id_shop ='.(int)$id_shop;

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
