<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Responsive banners
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

class ClassBanners extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $subtitle;
    public $url;
    public $facebook_url;
    public $youtube_url;
    public $twitter_url;
    public $instagram_url;
    public $image;
    public $description;
    public $specific_class;
    public $status;
    public $sort_order;
    public $blank;

    public static $definition = array(
        'table' => 'bonbanner',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
            'subtitle' => array('type' => self::TYPE_STRING, 'lang' => true, 'size' => 128),
            'url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => true, 'size' => 255),
            'facebook_url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
            'youtube_url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
            'twitter_url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
            'instagram_url' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
            'image' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => true, 'size' => 255),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'specific_class' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 128),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'blank' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool')
        ),
    );

    public function delete()
    {
        $res = true;
        $images = $this->image;

        if ($images) {
            foreach ($images as $image) {
                if ($image && file_exists(_PS_MODULE_DIR_.'bonbanner/views/img/'.$image)) {
                    $res &= @unlink(_PS_MODULE_DIR_.'bonbanner/views/img/'.$image);
                }
            }
        }

        $res &= parent::delete();
        return $res;
    }

    public static function getBannerList()
    {
        $sql = 'SELECT bonb.*, bonbl.`title`, bonbl.`url`, bonbl.`image`
                FROM '._DB_PREFIX_.'bonbanner bonb
                JOIN '._DB_PREFIX_.'bonbanner_lang bonbl
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
            FROM `'._DB_PREFIX_.'bonbanner`
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

    public function getFrontItems($id_shop, $only_active = false)
    {
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonbanner bonb
                JOIN ' . _DB_PREFIX_ . 'bonbanner_lang bonbl
                ON bonb.id_tab = bonbl.id_tab
                WHERE bonbl.id_lang = '. Context::getContext()->language->id.'
                AND bonb.id_shop ='. (int) $id_shop;

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
