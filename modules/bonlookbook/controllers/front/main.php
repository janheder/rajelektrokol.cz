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

class BonlookbookMainModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->context = Context::getContext();
        $this->id_shop = Context::getContext()->shop->id;
        $bonlookbook_front = new ClassBonlookbook();
        $tabs = $bonlookbook_front->getTopFrontItems($this->id_shop, true);
        $result = array();
        $points = array();

        foreach ($tabs as $key => $tab) {
            $points_arr = ClassBonlookbookPoint::getTopFrontItems((int)$tab['id_tab']);
            $result[$key]['id'] = $tab['id_tab'];
            $result[$key]['title'] = $tab['title'];
            $result[$key]['description'] = $tab['description'];
            $result[$key]['image'] = $tab['image'];
            if (file_exists($_SERVER["DOCUMENT_ROOT"] . _MODULE_DIR_  . 'bonlookbook/views/img/' . $tab['image'])) {
                $result[$key]['image_size'] = getimagesize($_SERVER["DOCUMENT_ROOT"] . _MODULE_DIR_  . 'bonlookbook/views/img/' . $tab['image']);
            }
            $result[$key]['subitems'] = ClassBonlookbookPoint::getTopFrontItems((int)$tab['id_tab']);

            foreach ($points_arr as $k => $point) {
                $image = new Image();
                $points[$tab['id_tab'] . '_' . $k]['id_tab'] = $tab['id_tab'];
                $points[$tab['id_tab'] . '_' . $k]['product'] = (new ProductAssembler($this->context))->assembleProduct(array('id_product' => $point['id_product']));
                $points[$tab['id_tab'] . '_' . $k]['product_image'] = $image->getCover($point['id_product']);
                $points[$tab['id_tab'] . '_' . $k]['top'] = $point['top'];
                $points[$tab['id_tab'] . '_' . $k]['left'] = $point['left'];
                $points[$tab['id_tab'] . '_' . $k]['status'] = $point['status'];
            }
        }

        $this->context->smarty->assign(array(
            'items'=> $result,
            'points'=> $points,
            'image_baseurl'=> _MODULE_DIR_ . 'bonlookbook/views/img/'
        ));

        $this->setTemplate('module:bonlookbook/views/templates/hook/bonlookbook.tpl');
    }
}
