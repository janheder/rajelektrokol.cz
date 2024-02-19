<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Frequently Asked Questions
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

use PrestaShop\PrestaShop\Core\Product\Search\Pagination;

class BonportfolioMainModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->context = Context::getContext();
        $this->id_shop = Context::getContext()->shop->id;
        $perPage = Configuration::get('BON_NUMBER_PORTFOLIO');
        
        $bonportfolio_front = new ClassBonportfolio();
        $total = count($bonportfolio_front->getTopFrontItems($this->id_shop, true));

        $breadcrumb = $this->getBreadcrumbLinks();

        $tabs = $bonportfolio_front->getTopMainItems($this->id_shop, true);

        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['title'] = mb_strimwidth($tab['title'], 0, 30, '...');
            $result[$key]['id'] = $tab['id_tab'];
            $result[$key]['quantity_sub'] = count(ClassBonportfolioSubcategory::getTopFrontItems($tab['id_tab']));
            $result[$key]['items'] = ClassBonportfolioSubcategory::getTopFrontItems((int)$tab['id_tab']);
        }

        $this->context->smarty->assign(array(
            'categories'=> array_reverse($result, true),
            'categories_all'=> $result,
            'image_baseurl'=> _MODULE_DIR_ . '/bonportfolio/views/img/',
            'limit'=> Configuration::get('BON_PORTFOLIO_LIMIT'),
            'add_sharebuttons'=> Configuration::get('BONPORTFOLIO_ADD_SHAREBUTTONS'),
        ));

        $this->setTemplate('module:bonportfolio/views/templates/front/bonportfolio_main.tpl');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['count'] = 2;
        $breadcrumb['links'][] = array(
            'title' => $this->l('Portfolios'),
            'url' => $this->context->link->getModuleLink(
                'bonportfolio',
                'main'
            ),
        );
        return $breadcrumb;
    }
}
