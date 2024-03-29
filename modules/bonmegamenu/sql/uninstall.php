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

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu_lang`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu_sub`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu_sub_lang`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu_sub_view`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenulinks`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenulinks_lang`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu_sub_prod`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu_sub_prod_lang`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu_sub_label`';

$sql[] = 'DROP TABLE IF EXISTS`'._DB_PREFIX_.'bonmegamenu_sub_label_lang`';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
