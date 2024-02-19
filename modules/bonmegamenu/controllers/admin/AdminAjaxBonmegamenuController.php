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

class AdminAjaxBonmegamenuController extends ModuleAdminController
{
    public function ajaxProcessUpdatePositionForm()
    {
        $items = Tools::getValue('item');
        $total = count($items);
        $id_shop = (int)$this->context->shop->id;
        $success = true;

        for ($i = 1; $i <= $total; $i++) {
            $success &= Db::getInstance()->update(
                'bonmegamenu',
                array('sort_order' => (int)$i),
                '`id_tab` = '.(int)preg_replace('/(item_)([0-9]+)/', '${2}', $items[$i - 1]).'
                AND `id_shop` ='.(int)$id_shop
            );
        }
        if (!$success) {
            die(json_encode(array('error' => 'Update Fail')));
        }
        die(json_encode(array('success' => 'Update Success !', 'error' => false)));
    }
    public function ajaxProcessUpdatePositionSubForm()
    {
        $items = Tools::getValue('item');
        $total = count($items);
        $success = true;
        $id_tab = (int)Tools::getValue('id_tab');

        for ($i = 1; $i <= $total; $i++) {
            $success &= Db::getInstance()->update(
                'bonmegamenu_sub',
                array('sort_order' => (int)$i),
                '`id_sub` = '.(int)preg_replace('/(item_)([0-9]+)/', '${2}', $items[$i - 1]).'
                AND `id_tab` ='. (int)$id_tab
            );
        }
        if (!$success) {
            die(json_encode(array('error' => 'Update Fail')));
        }
        die(json_encode(array('success' => 'Update Success !', 'error' => false)));
    }
    public function ajaxProcessUpdatePositionSubProductForm()
    {
        $items = Tools::getValue('item');
        $total = count($items);
        $success = true;
        $id_tab = (int)Tools::getValue('id_tab');

        for ($i = 1; $i <= $total; $i++) {
            $success &= Db::getInstance()->update(
                'bonmegamenu_sub_prod',
                array('sort_order' => (int)$i),
                '`id_sub` = '.(int)preg_replace('/(item_)([0-9]+)/', '${2}', $items[$i - 1]).'
                AND `id_tab` ='. (int)$id_tab
            );
        }
        if (!$success) {
            die(json_encode(array('error' => 'Update Fail')));
        }
        die(json_encode(array('success' => 'Update Success !', 'error' => false)));
    }
    public function ajaxProcessUpdatePositionSubLabelForm()
    {
        $items = Tools::getValue('item');
        $total = count($items);
        $success = true;
        $id_tab = (int)Tools::getValue('id_tab');

        for ($i = 1; $i <= $total; $i++) {
            $success &= Db::getInstance()->update(
                'bonmegamenu_sub_label',
                array('sort_order' => (int)$i),
                '`id_sub` = '.(int)preg_replace('/(item_)([0-9]+)/', '${2}', $items[$i - 1]).'
                AND `id_tab` ='. (int)$id_tab
            );
        }
        if (!$success) {
            die(json_encode(array('error' => 'Update Fail')));
        }
        die(json_encode(array('success' => 'Update Success !', 'error' => false)));
    }
    public function ajaxProcessUpdatePositionSubViewForm()
    {
        $items = Tools::getValue('item');
        $total = count($items);
        $success = true;
        $id_tab = (int)Tools::getValue('id_tab');

        for ($i = 1; $i <= $total; $i++) {
            $success &= Db::getInstance()->update(
                'bonmegamenu_sub_view',
                array('sort_order' => (int)$i),
                '`id_sub` = '.(int)preg_replace('/(item_)([0-9]+)/', '${2}', $items[$i - 1]).'
                AND `id_tab` ='. (int)$id_tab
            );
        }
        if (!$success) {
            die(json_encode(array('error' => 'Update Fail')));
        }
        die(json_encode(array('success' => 'Update Success !', 'error' => false)));
    }
}
