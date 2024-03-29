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

class AdminAjaxBonlookbookfwController extends ModuleAdminController
{
    public function ajaxProcessUpdatePositionForm()
    {
        $items = Tools::getValue('item');
        $total = count($items);
        $id_shop = (int)$this->context->shop->id;
        $success = true;

        for ($i = 1; $i <= $total; $i++) {
            $success &= Db::getInstance()->update(
                'bonlookbookfw',
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
                'bonlookbookfw_point',
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
