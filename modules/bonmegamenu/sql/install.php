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

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu` (
  `id_tab` int(11) NOT NULL AUTO_INCREMENT,
	`id_shop` int(11) NOT NULL DEFAULT \'1\',
	`status` int(11) NOT NULL,
	`type` VARCHAR(100) NOT NULL,
	`position_desktop` VARCHAR(100) NOT NULL,
	`position_mobile` VARCHAR(100) NOT NULL,
	`max_depth` VARCHAR(100) NOT NULL,
	`hidde_vertical_menu` VARCHAR(100) NOT NULL,
	`menu_width` VARCHAR(100) NOT NULL,
	`brands_image` VARCHAR(100) NOT NULL,
	`brands_name` VARCHAR(100) NOT NULL,
	`brands_img_type` VARCHAR(100) NOT NULL,
	`enable_category_images` VARCHAR(100) NOT NULL,
	`enable_category_images_hover` VARCHAR(100) NOT NULL,
	`menu_alignment` VARCHAR(100) NOT NULL,
	`color_background` VARCHAR(100) NOT NULL,
	`color_link` VARCHAR(100) NOT NULL,
	`color_link_hover` VARCHAR(100) NOT NULL,
	`menu_font_family` VARCHAR(100) NOT NULL,
	`menu_font_size` VARCHAR(100) NOT NULL,
	`sub_color_background` VARCHAR(100) NOT NULL,
	`sub_direction_type` VARCHAR(100) NOT NULL,
	`collapse_sub` VARCHAR(100) NOT NULL,
	`sub_menu_width` VARCHAR(100) NOT NULL,
	`sub_menu_popup_width` VARCHAR(100) NOT NULL,
	`sub_color_link` VARCHAR(100) NOT NULL,
	`sub_color_link_hover` VARCHAR(100) NOT NULL,
	`sub_color_titles_hover` VARCHAR(100) NOT NULL,
	`sub_color_titles` VARCHAR(100) NOT NULL,
	`sub_menu_font` VARCHAR(100) NOT NULL,
	`sub_menu_font_size` VARCHAR(100) NOT NULL,
	`mobile_view` VARCHAR(100) NOT NULL,
	`hide_on_mobile` VARCHAR(100) NOT NULL,
	`mobile_background` VARCHAR(100) NOT NULL,
	`main_hover_effect` VARCHAR(100) NOT NULL,
	`color_hover_effect` VARCHAR(100) NOT NULL,
	`text_transform` VARCHAR(100) NOT NULL,
	`mobile_links_color` VARCHAR(100) NOT NULL,
	`enable_contact_info` VARCHAR(100) NOT NULL,
	`menu_items` text NOT NULL,
	`sort_order` int(11) NOT NULL,
    PRIMARY KEY (`id_tab`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu_lang` (
	`id_tab` int(10) unsigned NOT NULL,
	`id_lang` int(11) NOT NULL,
	`title` VARCHAR(100),
	`custom_text` VARCHAR(100),
	`social_facebook` VARCHAR(100),
	`social_instagram` VARCHAR(100),
	`social_youtube` VARCHAR(100),
	`social_twitter` VARCHAR(100),
	`image` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`id_tab`, `id_lang`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu_sub` (
	`id_sub` int(11) NOT NULL AUTO_INCREMENT,
	`id_tab` int(11) NOT NULL,
	`id_shop` int(11) NOT NULL DEFAULT \'1\',
	`status` int(11) NOT NULL,
	`content_type` VARCHAR(100) NOT NULL,
	`description_type` VARCHAR(100) NOT NULL,
	`banner_width` VARCHAR(100) NOT NULL,
	`id_category` VARCHAR(100) NOT NULL,
	`sort_order` int(11) NOT NULL,
	PRIMARY KEY (`id_sub`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu_sub_lang` (
	`id_sub` int(10) unsigned NOT NULL,
	`id_lang` int(11) NOT NULL,
	`title` VARCHAR(100),
	`youtube_video` VARCHAR(100),
	`banner_description` text NOT NULL,
	`image` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`id_sub`, `id_lang`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu_sub_view` (
	`id_sub` int(11) NOT NULL AUTO_INCREMENT,
	`id_tab` int(11) NOT NULL,
	`id_shop` int(11) NOT NULL DEFAULT \'1\',
	`status` int(11) NOT NULL,
	`column_width` VARCHAR(100) NOT NULL,
	`view_type` VARCHAR(100) NOT NULL,
	`id_category` VARCHAR(100) NOT NULL,
	`sort_order` int(11) NOT NULL,
	`enable_category_description` int(11) NOT NULL,
	PRIMARY KEY (`id_sub`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenulinks` (
`id_sub` int(11) NOT NULL AUTO_INCREMENT,
`id_tab` int(11) NOT NULL,
`id_shop` int(11) NOT NULL DEFAULT \'1\',
`new_window` TINYINT( 1 ) NOT NULL,
	PRIMARY KEY (`id_sub`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenulinks_lang` (
`id_sub` int(10) unsigned NOT NULL,
`id_lang` int(11) NOT NULL,
`label` VARCHAR( 128 ) NOT NULL ,
`link` VARCHAR( 128 ) NOT NULL ,
PRIMARY KEY (`id_sub`, `id_lang`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu_sub_prod` (
	`id_sub` int(11) NOT NULL AUTO_INCREMENT,
	`id_tab` int(11) NOT NULL,
	`id_shop` int(11) NOT NULL DEFAULT \'1\',
	`status` int(11) NOT NULL,
	`id_category` VARCHAR(100) NOT NULL,
	`product_width` VARCHAR(100) NOT NULL,
	`id_product` int(11) NOT NULL,
	`sort_order` int(11) NOT NULL,
	PRIMARY KEY (`id_sub`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu_sub_prod_lang` (
	`id_sub` int(10) unsigned NOT NULL,
	`id_lang` int(11) NOT NULL,
	`title` VARCHAR(100),
	PRIMARY KEY (`id_sub`, `id_lang`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu_sub_label` (
	`id_sub` int(11) NOT NULL AUTO_INCREMENT,
	`id_tab` int(11) NOT NULL,
	`id_shop` int(11) NOT NULL DEFAULT \'1\',
	`status` int(11) NOT NULL,
	`label_switch_icon` int(11) NOT NULL,
	`id_category` VARCHAR(100) NOT NULL,
	`type_label` VARCHAR(100) NOT NULL,
	`label_bg_color` VARCHAR(100) NOT NULL,
	`label_text_color` VARCHAR(100) NOT NULL,
	`switch_icon` VARCHAR(100) NOT NULL,
	`type_icon` VARCHAR(100) NOT NULL,
	`icon` VARCHAR(100) NOT NULL,
	`icon_color` VARCHAR(100) NOT NULL,
	`label_font_size` VARCHAR(100) NOT NULL,
	`icon_font_size` VARCHAR(100) NOT NULL,
	`sort_order` int(11) NOT NULL,
	PRIMARY KEY (`id_sub`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonmegamenu_sub_label_lang` (
	`id_sub` int(10) unsigned NOT NULL,
	`id_lang` int(11) NOT NULL,
	`title` VARCHAR(100),
	`label_name` VARCHAR(100),
	`label_text` VARCHAR(100),
	PRIMARY KEY (`id_sub`, `id_lang`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
