<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Wishlist
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
require_once(_PS_MODULE_DIR_.'/bonwishlist/bonwishlist.php');
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

$bonsearch = new Bonwishlist();
$context = Context::getContext();
$result = array();

//if (Configuration::get('PS_TOKEN_ENABLE') == 1 &&
//    strcmp(Tools::getToken(false), Tools::getValue('token')) &&
//    Tools::getToken(false) == Tools::getValue('static_token_bon_wishlist') &&
//    Tools::getValue('ajax') == 1) {
    if (Tools::getValue('wishlist_key')) { 
        $array = explode(",", Tools::getValue('wishlist_key'));
        $bonwishlist_key = array();

        foreach ($array as $key => $arr) {
            $bonwishlist_key[$key]['id_product'] = $arr;
        }

        foreach ($bonwishlist_key as $key => $tab) {
            $image = new Image();
            $product = (new ProductAssembler($context))->assembleProduct(array('id_product' => $tab['id_product']));
            $presenterFactory = new ProductPresenterFactory($context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(new ImageRetriever($context->link), $context->link, new PriceFormatter(), new ProductColorsRetriever(), $context->getTranslator());
            $result[$key]['info'] = $presenter->present($presentationSettings, $product, $context->language);
            $result[$key]['image'] = $image->getCover($tab['id_product']);
        }
        $context->smarty->assign(array(
            'link' => $context->link,
            'products' => $result,
            'bonwishlist_count' => count($bonwishlist_key),
            'static_token' => Tools::getToken(false),
            'url' => Tools::getHttpHost(true).__PS_BASE_URI__,
        ));
    }
    $context->smarty->display((_PS_MODULE_DIR_.'/bonwishlist/views/templates/hook/bonwishlist-content.tpl'));
//}