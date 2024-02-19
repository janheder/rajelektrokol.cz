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

class ClassBonmegamenu extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $title;
    public $image;
    public $status;
    public $sort_order;
    public $type;
    public $position_desktop;
    public $position_mobile;
    public $menu_width;
    public $max_depth;
    public $hidde_vertical_menu;
    public $brands_image;
    public $brands_name;
    public $brands_img_type;
    public $enable_category_images;
    public $enable_category_images_hover;
    public $menu_alignment;
    public $color_background;
    public $color_link;
    public $color_link_hover;
    public $menu_font_family;
    public $menu_font_size;
    public $sub_color_background;
    public $sub_direction_type;
    public $collapse_sub;
    public $sub_menu_width;
    public $sub_menu_popup_width;
    public $sub_color_link;
    public $sub_color_link_hover;
    public $sub_color_titles;
    public $sub_color_titles_hover;
    public $sub_menu_font;
    public $sub_menu_font_size;
    public $mobile_view;
    public $hide_on_mobile;
    public $mobile_background;
    public $text_transform;
    public $main_hover_effect;
    public $color_hover_effect;
    public $mobile_links_color;
    public $enable_contact_info;
    public $custom_text;
    public $menu_items;
    public $social_facebook;
    public $social_instagram;
    public $social_youtube;
    public $social_twitter;

    public static $definition = array(
        'table' => 'bonmegamenu',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'position_desktop' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'position_mobile' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'menu_width' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'max_depth' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'hidde_vertical_menu' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'brands_image' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'brands_name' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'brands_img_type' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'enable_category_images' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'enable_category_images_hover' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'status' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'menu_items' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'image' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'menu_alignment' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'color_background' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'color_link' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'color_link_hover' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'menu_font_family' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'menu_font_size' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_color_background' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_direction_type' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'collapse_sub' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sub_menu_width' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_menu_popup_width' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_color_link' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_color_link_hover' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_color_titles' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_color_titles_hover' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_menu_font' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'sub_menu_font_size' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'mobile_view' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'hide_on_mobile' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'mobile_background' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'text_transform' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'main_hover_effect' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'color_hover_effect' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'mobile_links_color' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'custom_text' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'enable_contact_info' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'sort_order' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'social_twitter' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 500),
            'social_facebook' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 500),
            'social_instagram' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 500),
            'social_youtube' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 500),
        ),
    );

    public function delete()
    {
        $res = true;
        $images = $this->image;

        if ($images) {
            foreach ($images as $image) {
                if ($image && file_exists(_PS_MODULE_DIR_ . 'bonmegamenu/views/img/' . $image)) {
                    $res &= @unlink(_PS_MODULE_DIR_ . 'bonmegamenu/views/img/' . $image);
                }
            }
        }

        $res &= parent::delete();
        return $res;
    }

    public static function getBonmegamenuCategoryList()
    {
        $sql = 'SELECT bons.*, bonsl.`title`, bonsl.`social_facebook`, bonsl.`social_instagram`, bonsl.`social_youtube`, bonsl.`social_twitter`, bonsl.`image`, bonsl.`custom_text`
                FROM ' . _DB_PREFIX_ . 'bonmegamenu bons
                JOIN ' . _DB_PREFIX_ . 'bonmegamenu_lang bonsl
                ON (bons.`id_tab` = bonsl.`id_tab`)
                AND bons.`id_shop` = ' . (int)Context::getContext()->shop->id . '
                AND bonsl.`id_lang` = ' . (int)Context::getContext()->language->id . '
                ORDER BY bons.`sort_order`';

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public static function getMaxSortOrder($id_shop)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT MAX(sort_order) AS sort_order
            FROM `' . _DB_PREFIX_ . 'bonmegamenu`
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

    public static function getTopFrontItems($id_shop, $only_active = true)
    {
        $now = date('Y-m-d H:i:00');
        
        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonmegamenu bons
                JOIN ' . _DB_PREFIX_ . 'bonmegamenu_lang bonsl
                ON bons.id_tab = bonsl.id_tab
                AND bonsl.id_lang = ' . (int)Context::getContext()->language->id . '
                AND bons.id_shop =' . (int)$id_shop;

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
