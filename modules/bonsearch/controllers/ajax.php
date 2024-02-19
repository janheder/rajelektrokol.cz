<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Advanced Ajax Live Search Product
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

require_once('../../../config/config.inc.php');
require_once('../../../init.php');
require_once(_PS_MODULE_DIR_.'/bonsearch/bonsearch.php');

$bonsearch = new Bonsearch();
$results = [];
$bonsearch_key = Tools::getValue('search_key');
$id_category = Tools::getValue('id_category');
$context = Context::getContext();
$count = Configuration::get('BON_SEARCH_COUNT');
$total = [];
$product_link = $context->link;
if (Tools::strlen($bonsearch_key) >= 3) {
    $results = Search::find($context->language->id, $bonsearch_key, $page_number = 1, $page_size = $count);
    $total = array_pop($results);
    $category = new Category($id_category);
    $total_products = count($results);
    $currensy = $context->currency->sign;
    $context->smarty->assign(array(
        'enable_image' => Configuration::get('BON_SEARCH_IMAGE'),
        'enable_price' => Configuration::get('BON_SEARCH_PRICE'),
        'enable_name' => Configuration::get('BON_SEARCH_NAME'),
        'enable_reference' => Configuration::get('BON_SEARCH_REFERENCE'),
        'search_alert' => $bonsearch->no_product,
        'link' => $context->link,
        'currensy' => $currensy,
        'products' => $total,
        'category' => $category,
        'lang_id' => $context->language->id,
        'id_choose_category' => $id_category,
    ));
    $context->smarty->display(_PS_MODULE_DIR_.'/bonsearch/views/templates/hook/popupsearch.tpl');
} else {
    $context->smarty->display(_PS_MODULE_DIR_.'/bonsearch/views/templates/hook/three_character.tpl');
}
