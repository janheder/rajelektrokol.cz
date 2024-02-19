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

class BoncollectionMainModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->context = Context::getContext();
        $this->id_shop = Context::getContext()->shop->id;
        $perPage = Configuration::get('BON_NUMBER_COLLECTION');

        $boncollection_front = new ClassBoncollection();
        $total = count($boncollection_front->getTopFrontItems($this->id_shop, true));

        $breadcrumb = $this->getBreadcrumbLinks();
        $pagination = $this->getTemplateVarPagination($total, $perPage);

        $tabs = $boncollection_front->getTopMainItems($this->id_shop, true, (int)$pagination['items_shown_from'] - 1, (int)$perPage);

        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['title'] = mb_strimwidth($tab['title'], 0, 30, '...');;
            $result[$key]['description'] = mb_strimwidth($tab['description'], 0, 155, '...');
            $result[$key]['image'] = $tab['image'];
            $result[$key]['url'] = str_replace(' ', '_', $tab['url']);
            $result[$key]['id'] = $tab['id_tab'];
            $result[$key]['author_name'] = $tab['author_name'];
            $result[$key]['date_public'] = $tab['date_public'];
            $result[$key]['author_img'] = $tab['author_img'];
            $result[$key]['quantity_sub'] = count(ClassBoncollectionSubcategory::getTopFrontItems($tab['id_tab']));
        }

        $this->context->smarty->assign(array(
            'display_carousel' => Configuration::get('BON_COLLECTION_DISPLAY_CAROUSEL'),
            'pagination'=> $pagination,
            'items'=> $result,
            'image_baseurl'=> _MODULE_DIR_ . '/boncollection/views/img/',
            'limit'=> Configuration::get('BON_COLLECTION_LIMIT')
        ));

        $this->setTemplate('module:boncollection/views/templates/front/boncollection_main.tpl');
    }

    protected function getTemplateVarPagination($total = 0, $perPage = 5)
    {
        $totalItems = (int)$total;
        $page = (int)Tools::getValue('page');

        $page = (int)Tools::getValue('page') ? (int)Tools::getValue('page') : 1;
        
        $itemsPerPage = (int)$perPage;

        $pagination = new Pagination();
        $pagination
            ->setPage($page)
            ->setPagesCount(
                (int)ceil($totalItems / $itemsPerPage)
            );
        $pages = array_map(function ($link) {
            $link['url'] = $this->updateQueryString(array(
                'page' => $link['page'] > 1 ? $link['page'] : null,
            ));

            return $link;
        }, $pagination->buildLinks());

        $itemsShownFrom = ($itemsPerPage * ($page - 1)) + 1;
        $itemsShownTo = $itemsPerPage * $page;

        $pages = array_filter($pages, function ($page) use ($pagination) {
            if ('previous' === $page['type'] && 1 === $pagination->getPage()) {
                return false;
            }
            if ('next' === $page['type'] && $pagination->getPagesCount() === $pagination->getPage()) {
                return false;
            }
            return true;
        });

        return array(
            'total_items' => $totalItems,
            'items_shown_from' => $itemsShownFrom,
            'items_shown_to' => ($itemsShownTo <= $totalItems) ? $itemsShownTo : $totalItems,
            'current_page' => $pagination->getPage(),
            'pages_count' => $pagination->getPagesCount(),
            'pages' => $pages,
            // Compare to 3 because there are the next and previous links
            'should_be_displayed' => (count($pagination->buildLinks()) > 3),
        );
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['count'] = 2;
        $breadcrumb['links'][] = array(
            'title' => $this->l('Collections'),
            'url' => $this->context->link->getModuleLink(
                'boncollection',
                'main'
            ),
        );
        return $breadcrumb;
    }
}
