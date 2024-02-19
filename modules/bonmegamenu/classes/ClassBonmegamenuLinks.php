<?php
/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

class ClassBonmegamenuLinks extends ObjectModel
{
    public $id_tab;
    public $id_sub;
    public $id_shop;
    public $label;
    public $link;
    public $new_window;

    public static $definition = array(
        'table' => 'bonmegamenulinks',
        'primary' => 'id_sub',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'id_tab' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'label' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'link' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => true, 'size' => 255),
            'new_window' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
        ),
    );

    public static function getBonmegamenuLinksList($id_tab)
    {
        $sql = 'SELECT bons.*, bonsl.`label`, bonsl.`link`
                FROM ' . _DB_PREFIX_ . 'bonmegamenulinks bons
                JOIN ' . _DB_PREFIX_ . 'bonmegamenulinks_lang bonsl
                ON (bons.`id_sub` = bonsl.`id_sub`)
                AND bons.id_tab =' . (int)$id_tab . '
                AND bonsl.`id_lang` = ' . (int)Context::getContext()->language->id;

        if (!$result = Db::getInstance()->executeS($sql)) {
            return false;
        }

        return $result;
    }


    public static function getBonmegamenuLink($id_sub = null)
    {
        $sql = 'SELECT l.id_sub, l.new_window, ll.link, ll.label
				FROM ' . _DB_PREFIX_ . 'bonmegamenulinks l
				LEFT JOIN ' . _DB_PREFIX_ . 'bonmegamenulinks_lang ll ON (l.id_sub = ll.id_sub AND ll.id_lang = ' . (int)Context::getContext()->language->id . ')
				WHERE 1 ' . ((!is_null($id_sub)) ? ' AND l.id_sub = "' . (int) $id_sub . '"' : '') . '
				AND l.id_shop IN (0, ' . (int) Context::getContext()->shop->id . ')';

        return Db::getInstance()->executeS($sql);
    }

    public function delete()
    {
        $res = true;

        $res &= parent::delete();
        return $res;
    }
}
