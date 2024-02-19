<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Slider Manager with Photos and Videos
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

class ClassBonsliderSubcategory extends ObjectModel
{
    public $id_sub;
    public $id_tab;
    public $id_shop;
    public $animation;
    public $title;
    public $top;
    public $right;
    public $description;
    public $zindex;
    public $animation_delay;
    public $status;
    public $sort_order;
    public $image;

    public static $definition = array(
        'table' => 'bonslider_sub',
        'primary' => 'id_sub',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_tab' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'top' => array('type' => self::TYPE_INT, 'required' => true),
            'right' => array('type' => self::TYPE_INT, 'required' => true),
            'zindex' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'animation_delay' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'animation' => array('type' => self::TYPE_STRING, 'size' => 255),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'image' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
        ),
    );

    public function delete()
    {
        $res = true;
        $images = $this->image;

        if ($images) {
            foreach ($images as $image) {
                if ($image && file_exists(_PS_MODULE_DIR_ . 'bonslider/views/img/' . $image)) {
                    $res &= @unlink(_PS_MODULE_DIR_ . 'bonslider/views/img/' . $image);
                }
            }
        }

        $res &= parent::delete();
        return $res;
    }

    public static function getBonsliderSubcategoryList($id_tab)
    {
        $sql = 'SELECT bons.*, bonsl.`title`, bonsl.`image`
                FROM ' . _DB_PREFIX_ . 'bonslider_sub bons
                JOIN ' . _DB_PREFIX_ . 'bonslider_sub_lang bonsl
                ON (bons.`id_sub` = bonsl.`id_sub`)
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
            FROM `' . _DB_PREFIX_ . 'bonslider_sub`
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

    public static function getTopFrontItems($id_tab, $only_active = false)
    {
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonslider_sub bons
                JOIN ' . _DB_PREFIX_ . 'bonslider_sub_lang bonsl
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
    public static function getTopMainItems($id_tab, $only_active = false, $offset = 0, $limit = 2)
    {
        $now = date('Y-m-d H:i:00');
        
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonslider_sub bons
                JOIN ' . _DB_PREFIX_ . 'bonslider_sub_lang bonsl
                ON bons.id_sub = bonsl.id_sub
                AND bonsl.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bons.id_tab =' . (int)$id_tab;

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
