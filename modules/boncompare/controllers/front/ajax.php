<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Product Compare
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

require_once('../../../../config/config.inc.php');
require_once('../../../../init.php');
require_once(_PS_MODULE_DIR_.'/boncompare/boncompare.php');
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

$bonsearch = new Boncompare();
$context = Context::getContext();
$products = array();

//if (Configuration::get('PS_TOKEN_ENABLE') == 1 &&
//    strcmp(Tools::getToken(false), Tools::getValue('token')) &&
//    Tools::getToken(false) == Tools::getValue('static_token_bon_compare') &&
//    Tools::getValue('ajax') == 1) {
    if (Tools::getValue('compare_key')) {
        $array = explode(",", Tools::getValue('compare_key'));
        $boncompare_key = array();
        
        foreach ($array as $key => $arr) {
            $boncompare_key[$key]['id_product'] = $arr;
        }
        
        foreach ($boncompare_key as $key => $tab) {
            $product_full = (new ProductAssembler($context))->assembleProduct(array('id_product' => $tab['id_product']));
            $presenterFactory = new ProductPresenterFactory($context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(new ImageRetriever($context->link), $context->link, new PriceFormatter(), new ProductColorsRetriever(), $context->getTranslator());
            $product = new Product($tab['id_product'], true, (int)$context->language->id);
            $products[$key]['info'] = $presenter->present($presentationSettings, $product_full, $context->language);
            $products[$key]['manufacturer_name'] = $product->manufacturer_name;
            $products[$key]['description_short'] = mb_strimwidth($product->description_short, 0, 200, '...');
            $products[$key]['reference'] = $product->reference;
            $products[$key]['available_for_order'] = $product->available_for_order;
            $products[$key]['category'] = $product->category;
            $products[$key]['features'] = $product->getFeatures($tab['id_product']);

            $product_attr = [];
            $attributes_group = $product->getAttributesGroups($context->language->id);
            foreach ($attributes_group as $item => $attribute) {
                array_push($product_attr, $attribute['attribute_name']);
            }
            $products[$key]['attributes'] = array_unique($product_attr);
        }

        $context->smarty->assign(array(
            'link' => $context->link,
            'products' => $products,
            'static_token' => Tools::getToken(false),
            'url' => Tools::getHttpHost(true).__PS_BASE_URI__,
        ));
    }
    $context->smarty->display((_PS_MODULE_DIR_.'/boncompare/views/templates/hook/boncompare-content.tpl'));
//}