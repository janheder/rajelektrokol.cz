<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Free Shipping Notice
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

class ClassNotice extends ObjectModel
{
    public $id_tab;
    public $id_shop;
    public $description;
    public $code;
    public $data_start;
    public $data_end;

    public static $definition = array(
        'table' => 'bonnotice',
        'primary' => 'id_tab',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'code' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'data_start' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'data_end' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function getTopFrontNotice($id_shop)
    {
        $now = date('Y-m-d H:i:00');

        $sql = 'SELECT *
                FROM ' . _DB_PREFIX_ . 'bonnotice bonn
                JOIN ' . _DB_PREFIX_ . 'bonnotice_lang bonnl
                ON bonn.id_tab = bonnl.id_tab
                WHERE bonnl.id_lang = '.(int)Context::getContext()->language->id.'
                AND bonn.`data_end` >= \''.$now.'\'
                AND bonn.`data_start` <= \''.$now.'\'
                AND bonn.id_shop ='.(int)$id_shop;

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return array();
        }

        return $result;
    }
}
