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

$sql = array();

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'boncollection`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'boncollection_lang`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'boncollection_sub`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'boncollection_sub_lang`';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
