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

class BoncollectioncollectionModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->context = Context::getContext();
        $this->id_shop = Context::getContext()->shop->id;
        
        $result = array();
        
        $collection = new ClassBoncollection(
            (int)Tools::getValue('id_tab'),
            (int)$this->context->language->id,
            (int)$this->context->shop->id
        );

        $result['title'] = $collection->title;
        $result['url'] = str_replace(' ', '_', $collection->url);
        $result['description'] = $collection->description;
        $result['date_public'] = $collection->date_public;
        $result['image'] = $collection->image;
        $result['id'] = $collection->id;
        $result['author_name'] = $collection->author_name;
        $result['author_img'] = $collection->author_img;

        $items = array();

        $subcategories = ClassBoncollectionSubcategory::getTopFrontItems((int)Tools::getValue('id_tab'));

        foreach ($subcategories as $key => $subcategory) {
            $items[$key]['title'] = $subcategory['title'];
            $items[$key]['description'] = $subcategory['description'];
            $items[$key]['image'] = $subcategory['image'];
            $items[$key]['type'] = $subcategory['type'];
            $items[$key]['cover'] = $subcategory['cover'];
            // $result[$key]['id'] = $tab['id_tab'];
        }

        $breadcrumb = $this->getBreadcrumbLinks();

        $prevNextcollection = $this->prevNextcollection();
        
        $this->context->smarty->assign(array(
            'display_carousel' => Configuration::get('BON_COLLECTION_DISPLAY_CAROUSEL'),
            'image_baseurl'=> _MODULE_DIR_.'boncollection/views/img/',
            'limit'=> Configuration::get('BON_COLLECTION_LIMIT'),
            'add_sharebuttons'=> Configuration::get('BON_ADD_SHAREBUTTONS'),
            'collection'=> $result,
            'prevNextcollection'=> $prevNextcollection,
            'items'=> $items,
        ));
        $this->setTemplate('module:boncollection/views/templates/front/boncollection_collection.tpl');
    }

    public function prevNextcollection()
    {
        $result = array();

        $next_collection = new ClassBoncollection(
            (int)Tools::getValue('id_tab') + 1,
            (int)$this->context->language->id,
            (int)$this->context->shop->id
        );
        
        $prev_collection = new ClassBoncollection(
            (int)Tools::getValue('id_tab') - 1,
            (int)$this->context->language->id,
            (int)$this->context->shop->id
        );
        
        $result['next_id'] = $next_collection->id;
        $result['prev_id'] = $prev_collection->id;
        $result['url_next'] = str_replace(' ', '_', $next_collection->url);
        $result['url_prev'] = str_replace(' ', '_', $prev_collection->url);

        return $result;
    }

    public function getBreadcrumbLinks()
    {
        $collection = new ClassBoncollection(
            (int)Tools::getValue('id_tab'),
            (int)$this->context->language->id,
            (int)$this->context->shop->id
        );

        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['count'] = 3;
        $breadcrumb['links'][] = array(
            'title' => $this->l('Collection'),
            'url' => $this->context->link->getModuleLink(
                'boncollection',
                'main'
            ),
        );
        $breadcrumb['links'][] = array(
            'title' => $collection->title,
            'url' => $this->context->link->getModuleLink(
                'boncollection',
                'collection',
                ['id_tab'=> $collection->id, 'link_rewrite'=> str_replace(' ', '_', $collection->url)]
            ),
        );
        return $breadcrumb;
    }
}
