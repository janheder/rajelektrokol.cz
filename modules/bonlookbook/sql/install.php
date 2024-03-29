<?php

/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Lookbook gallery with products and slider
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
 *  @copyright 2015-2022 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonlookbook` (
    `id_tab` int(11) NOT NULL AUTO_INCREMENT,
	`id_shop` int(11) NOT NULL DEFAULT \'1\',
	`status` int(11) NOT NULL,
	`sort_order` int(11) NOT NULL,
	`image` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_tab`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonlookbook_lang` (
	`id_tab` int(10) unsigned NOT NULL,
	`id_lang` int(11) NOT NULL,
	`title` VARCHAR(100),
	`description` text NOT NULL,
	PRIMARY KEY (`id_tab`, `id_lang`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonlookbook_point` (
    `id_sub` int(11) NOT NULL AUTO_INCREMENT,
	`id_tab` int(11) NOT NULL,
	`id_shop` int(11) NOT NULL DEFAULT \'1\',
	`status` int(11) NOT NULL,
	`top` int(11) NOT NULL,
	`id_product` int(11) NOT NULL,
	`left` int(11) NOT NULL,
	`sort_order` int(11) NOT NULL,
	PRIMARY KEY (`id_sub`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'bonlookbook_point_lang` (
	`id_sub` int(10) unsigned NOT NULL,
	`id_lang` int(11) NOT NULL,
	PRIMARY KEY (`id_sub`, `id_lang`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
