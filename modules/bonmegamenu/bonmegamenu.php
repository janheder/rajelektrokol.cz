<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
 
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

include_once(_PS_MODULE_DIR_ . 'bonmegamenu/classes/ClassBonmegamenu.php');
include_once(_PS_MODULE_DIR_ . 'bonmegamenu/classes/ClassBonmegamenuSubcategory.php');
include_once(_PS_MODULE_DIR_ . 'bonmegamenu/classes/ClassBonmegamenuLinks.php');
include_once(_PS_MODULE_DIR_ . 'bonmegamenu/classes/ClassBonmegamenuConstructor.php');
include_once(_PS_MODULE_DIR_ . 'bonmegamenu/classes/ClassBonmegamenuSubcategoryProduct.php');
include_once(_PS_MODULE_DIR_ . 'bonmegamenu/classes/ClassBonmegamenuSubcategoryLabel.php');
include_once(_PS_MODULE_DIR_ . 'bonmegamenu/classes/ClassBonmegamenuSubcategoryView.php');

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Bonmegamenu extends Module implements WidgetInterface
{
    protected $config_form = false;

    const MENU_JSON_CACHE_KEY = 'MOD_BONMEGA_MENU_JSON';

    protected $pattern = '/^([A-Z_]*)[0-9]+/';

    public $page_name = '';

    protected $spacer_size = '5';

    public $category = array();

    public function __construct()
    {
        $this->name = 'bonmegamenu';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = '5f18c1791612037aeeba1d9629352be0';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Exciting Mega Menu with Products, Banners & Video');
        $this->description = $this->l('Allows you to create multifunctional Mega Menu.');
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        if (Configuration::get('PS_SSL_ENABLED')) {
            $this->ssl = 'https://';
        } else {
            $this->ssl = 'http://';
        }
        $this->imageFiles = null;
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'bonmegamenu';
            }
        }
        $tab->class_name = 'AdminAjaxBonmegamenu';
        $tab->module = $this->name;
        $tab->id_parent = -1;

        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxBonmegamenu')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include(dirname(__FILE__) . '/sql/install.php');
        $this->installSamples();

        return parent::install() &&
            $this->registerHook('header') &&
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayBonMegamenu') &&
            $this->registerHook('displayWrapperTop') &&
            $this->registerHook('displayNav1') &&
            $this->registerHook('displayNav2') &&
            $this->registerHook('displayNav') &&
            $this->registerHook('displayFooter') &&
            $this->registerHook('displayFooterBefore') &&
            $this->registerHook('displayLeftColumn') &&
            $this->registerHook('displayCustomBonmegamenu') &&
            $this->registerHook('displayNavFullWidth') &&
            $this->registerHook('displayLeftColumnProduct');
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        $item = new ClassBonmegamenu();
        $item->id_shop = (int)$this->context->shop->id;
        $item->status = 1;
        $item->type = "horizontal";
        $item->sort_order = 1;
        $item->menu_items = 'CAT3,CAT6,CAT9';
        $item->menu_width = 'full';
        $item->max_depth = 10;
        $item->hidde_vertical_menu = false;
        $item->brands_image = true;
        $item->brands_name = true;
        $item->brands_img_type = 'small_default';
        $item->enable_category_images = true;
        $item->enable_category_images_hover = false;
        $item->menu_alignment = 'center_alignment';
        $item->color_background = '#ffffff';
        $item->color_link = '#ffffff';
        $item->color_link_hover = '#d24545';
        $item->menu_font_family = 'default';
        $item->menu_font_size = '18';
        $item->sub_color_background = '#fff9f2';
        $item->sub_direction_type = 'horizontal';
        $item->sub_menu_width = 'submenu_container_width';
        $item->sub_menu_popup_width = 'popup_container_width';
        $item->collapse_sub = false;
        $item->sub_color_link = '#7a7a7a';
        $item->sub_color_link_hover = '#4c1d21';
        $item->sub_color_titles_hover = '#3a3a3a';
        $item->sub_color_titles = '#4c1d21';
        $item->sub_menu_font = 'default';
        $item->sub_menu_font_size = '19';
        $item->hide_on_mobile = false;
        $item->mobile_view = '992';
        $item->mobile_background = '#3a3a3a';
        $item->color_hover_effect = '#ffffff';
        $item->main_hover_effect = 'background';
        $item->text_transform = 'capitalize';
        $item->mobile_links_color = '#ffffff';
        $item->enable_contact_info = false;
        $item->position_desktop = "displayBonMegamenu";
        $item->position_mobile = "displayBonMegamenu";
        
        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = 'Menu';
        }

        $item->add();
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');
        return parent::uninstall()
            && $this->removeAjaxContoller();
    }

    public function getContent()
    {
        $output = '';
        $result = '';


        if ((bool)Tools::isSubmit('updatebonmegamenulinks')) {
            $output = '';
            $output .= $this->renderBonmegamenuCategoryForm();
            $output .= $this->renderBonmegamenuCategoryLinksForm();
            $output .= $this->renderBonmegamenuLinksList();
            $result = true;
        }
        if ((bool)Tools::isSubmit('deletebonmegamenulinks')) {
            $output .= $this->deleteBonmegamenuLinks();
            $result = true;
            $output .= $this->renderBonmegamenuCategoryForm();
            $output .= $this->renderBonmegamenuCategoryLinksForm();
            $output .= $this->renderBonmegamenuLinksList();
        }
        if ((bool)Tools::isSubmit('submitUpdateBonmegamenu')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addBonmegamenu();
                $result = true;
                $output .= $this->renderBonmegamenuCategoryForm();
                $output .= $this->renderBonmegamenuCategoryLinksForm();
                $output .= $this->renderBonmegamenuLinksList();
            } else {
                $output = $result;
                $output .= $this->renderBonmegamenuCategoryForm();
                $output .= $this->renderBonmegamenuCategoryLinksForm();
                $output .= $this->renderBonmegamenuLinksList();
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBonmegamenuLinks')) {
            if (!$result = $this->preValidateLinksForm()) {
                $output .= $this->addBonmegamenuLinks();
                $result = true;
                $output .= $this->renderBonmegamenuCategoryForm();
                $output .= $this->renderBonmegamenuCategoryLinksForm();
                $output .= $this->renderBonmegamenuLinksList();
            } else {
                $output = $result;
                $output .= $this->renderBonmegamenuCategoryForm();
                $output .= $this->renderBonmegamenuCategoryLinksForm();
                $output .= $this->renderBonmegamenuLinksList();
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBonmegamenuSub')) {
            if (!$result = $this->preValidateFormSub()) {
                $output .= $this->addBonmegamenuSub();
            } else {
                $output = $result;
                $output .= $this->renderBonmegamenuSubcategoryForm();
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBonmegamenuSubLabel')) {
            if (!$result = $this->preValidateFormSubLabel()) {
                $output .= $this->addBonmegamenuSubLabel();
            } else {
                $output = $result;
                $output .= $this->renderBonmegamenuSubcategoryLabelForm();
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBonmegamenuSubView')) {
                $output .= $this->addBonmegamenuSubView();
        } elseif ((bool)Tools::isSubmit('submitUpdateBonmegamenuSubProd')) {
            if (!$result = $this->preValidateFormSubProduct()) {
                $output .= $this->addBonmegamenuSubProduct();
            } else {
                $output = $result;
                $output .= $this->renderBonmegamenuSubcategoryProductForm();
            }
        }

        if (Tools::getIsset('updatebonmegamenu') || Tools::getValue('updatebonmegamenu')) {
            $output .= $this->renderBonmegamenuCategoryForm();
            $output .= $this->renderBonmegamenuCategoryLinksForm();
            $output .= $this->renderBonmegamenuLinksList();
        } elseif ((bool)Tools::isSubmit('addbonmegamenu')) {
            $output .= $this->renderBonmegamenuCategoryForm();
            $output .= $this->renderBonmegamenuCategoryLinksForm();
            $output .= $this->renderBonmegamenuLinksList();
        } elseif ((bool)Tools::isSubmit('viewbonmegamenu')) {
            $output .= $this->renderBonmegamenuSubcategoryViewList();
            $output .= $this->renderBonmegamenuSubcategoryList();
            $output .= $this->renderBonmegamenuSubcategoryProductsList();
            $output .= $this->renderBonmegamenuSubcategoryLabelsList();
        } elseif (Tools::getIsset('updatebonmegamenu_sub') || Tools::getValue('updatebonmegamenu_sub')) {
            $output .= $this->renderBonmegamenuSubcategoryForm();
        } elseif (Tools::getIsset('updatebonmegamenu_sub_view') || Tools::getValue('updatebonmegamenu_sub_view')) {
            $output .= $this->renderBonmegamenuSubcategoryViewForm();
        } elseif (Tools::getIsset('updatebonmegamenu_sub_prod') || Tools::getValue('updatebonmegamenu_sub_prod')) {
            $output .= $this->renderBonmegamenuSubcategoryProductForm();
        } elseif (Tools::getIsset('updatebonmegamenu_sub_label') || Tools::getValue('updatebonmegamenu_sub_label')) {
            $output .= $this->renderBonmegamenuSubcategoryLabelForm();
        } elseif ((bool)Tools::isSubmit('addsubbonmegamenu')) {
            $output .= $this->renderBonmegamenuSubcategoryForm();
        } elseif ((bool)Tools::isSubmit('addsub_view_bonmegamenu')) {
            $output .= $this->renderBonmegamenuSubcategoryViewForm();
        } elseif ((bool)Tools::isSubmit('addsub_prod_bonmegamenu')) {
            $output .= $this->renderBonmegamenuSubcategoryProductForm();
        } elseif ((bool)Tools::isSubmit('addsub_label_bonmegamenu')) {
            $output .= $this->renderBonmegamenuSubcategoryLabelForm();
        } elseif ((bool)Tools::isSubmit('statusbonmegamenu')) {
            $output .= $this->updateStatusTab();
            $output .= $this->renderBonmegamenuCategoryList();
        } elseif ((bool)Tools::isSubmit('statusbonmegamenu_sub')) {
            $output .= $this->updateStatusSubcategory();
            $output .= $this->renderBonmegamenuSubcategoryList();
        } elseif ((bool)Tools::isSubmit('statusbonmegamenu_sub_label')) {
            $output .= $this->updateStatusSubcategoryLabel();
            $output .= $this->renderBonmegamenuSubcategoryLabelsList();
        } elseif ((bool)Tools::isSubmit('statusbonmegamenu_sub_prod')) {
            $output .= $this->updateStatusSubcategoryProduct();
            $output .= $this->renderBonmegamenuSubcategoryProductsList();
        } elseif ((bool)Tools::isSubmit('statusbonmegamenu_sub_view')) {
            $output .= $this->updateStatusSubcategoryView();
            $output .= $this->renderBonmegamenuSubcategoryViewList();
        } elseif ((bool)Tools::isSubmit('deletebonmegamenu')) {
            $output .= $this->deleteBonmegamenu();
            $output .= $this->renderBonmegamenuCategoryList();
        } elseif ((bool)Tools::isSubmit('deletebonmegamenu_sub')) {
            $output .= $this->deleteBonmegamenuSub();
            $output .= $this->renderBonmegamenuSubcategoryViewList();
            $output .= $this->renderBonmegamenuSubcategoryList();
            $output .= $this->renderBonmegamenuSubcategoryProductsList();
            $output .= $this->renderBonmegamenuSubcategoryLabelsList();
        } elseif ((bool)Tools::isSubmit('deletebonmegamenu_sub_prod')) {
            $output .= $this->deleteBonmegamenuSubProduct();
            $output .= $this->renderBonmegamenuSubcategoryViewList();
            $output .= $this->renderBonmegamenuSubcategoryList();
            $output .= $this->renderBonmegamenuSubcategoryProductsList();
            $output .= $this->renderBonmegamenuSubcategoryLabelsList();
        } elseif ((bool)Tools::isSubmit('deletebonmegamenu_sub_label')) {
            $output .= $this->deleteBonmegamenuSubLabel();
            $output .= $this->renderBonmegamenuSubcategoryViewList();
            $output .= $this->renderBonmegamenuSubcategoryList();
            $output .= $this->renderBonmegamenuSubcategoryProductsList();
            $output .= $this->renderBonmegamenuSubcategoryLabelsList();
        } elseif ((bool)Tools::isSubmit('deletebonmegamenu_sub_view')) {
            $output .= $this->deleteBonmegamenuSubView();
            $output .= $this->renderBonmegamenuSubcategoryViewList();
            $output .= $this->renderBonmegamenuSubcategoryList();
            $output .= $this->renderBonmegamenuSubcategoryProductsList();
            $output .= $this->renderBonmegamenuSubcategoryLabelsList();
        } elseif (!$result) {
            $output .= $this->renderBonmegamenuCategoryList();
        }

        return $output;
    }

    protected function getStringValueType($string)
    {
        if (Validate::isInt($string)) {
            return 'int';
        } elseif (Validate::isFloat($string)) {
            return 'float';
        } elseif (Validate::isBool($string)) {
            return 'bool';
        } else {
            return 'string';
        }
    }

    // start main menu settings


    protected function renderBonmegamenuCategoryForm()
    {
        $shops = Shop::getContextListShopID();
        ClassBonmegamenuConstructor::cacheFileRewrite(Tools::getValue('id_tab'), self::MENU_JSON_CACHE_KEY);
 
        $fields_options = array(
            );

        $fields_form = array(
            'form' => array(
                
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ?
                        $this->l('Update category') :
                        $this->l('Add category')),
                    'icon' => 'icon-cogs',
                ),
                'tabs' => array(
                    'TAB1' => $this->l('General settings'),
                    'TAB2' => $this->l('Selected items'),
                    'TAB3' => $this->l('Main categories style'),
                    'TAB4' => $this->l('Subcategories style'),
                    'TAB5' => $this->l('Mobile settings'),
                    'TAB6' => $this->l('Contact info'),
                    // 'TAB7' => $this->l('Social links'),
                    ),
                'input' => array(
                    //TAB1
                    array(
                        'type' => 'text',
                        'tab' => 'TAB1',
                        'label' => $this->l('Menu name:'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB1',
                        'label' => $this->l('Menu position desktop:'),
                        'name' => 'position_desktop',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'displayBonMegamenu',
                                    'name' => 'displayBonMegamenu'),
                                array(
                                    'id' => 'displayTop',
                                    'name' => 'displayTop'),
                                array(
                                    'id' => 'displayWrapperTop',
                                    'name' => 'displayWrapperTop'),
                                array(
                                    'id' => 'displayCustomBonmegamenu',
                                    'name' => 'displayCustomBonmegamenu'),
                                array(
                                    'id' => 'displayNav1',
                                    'name' => 'displayNav1'),
                                array(
                                    'id' => 'displayNav2',
                                    'name' => 'displayNav2'),
                                array(
                                    'id' => 'displayNav',
                                    'name' => 'displayNav'),
                                array(
                                    'id' => 'displayFooter',
                                    'name' => 'displayFooter'),
                                array(
                                    'id' => 'displayFooterBefore',
                                    'name' => 'displayFooterBefore'),
                                array(
                                    'id' => 'displayLeftColumn',
                                    'name' => 'displayLeftColumn'),
                                array(
                                    'id' => 'displayNavFullWidth',
                                    'name' => 'displayNavFullWidth'),
                                array(
                                    'id' => 'displayLeftColumnProduct',
                                    'name' => 'displayLeftColumnProduct'),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB1',
                        'label' => $this->l('Menu position mobile:'),
                        'name' => 'position_mobile',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'displayBonMegamenu',
                                    'name' => $this->l('displayBonMegamenu')),
                                array(
                                    'id' => 'displayTop',
                                    'name' => $this->l('displayTop')),
                                array(
                                    'id' => 'displayWrapperTop',
                                    'name' => $this->l('displayWrapperTop')),
                                array(
                                    'id' => 'displayCustomBonmegamenu',
                                    'name' => $this->l('displayCustomBonmegamenu')),
                                array(
                                    'id' => 'displayNav1',
                                    'name' => $this->l('displayNav1')),
                                array(
                                    'id' => 'displayNav2',
                                    'name' => $this->l('displayNav2')),
                                array(
                                    'id' => 'displayNav',
                                    'name' => $this->l('displayNav')),
                                array(
                                    'id' => 'displayFooter',
                                    'name' => $this->l('displayFooter')),
                                array(
                                    'id' => 'displayFooterBefore',
                                    'name' => $this->l('displayFooterBefore')),
                                array(
                                    'id' => 'displayLeftColumn',
                                    'name' => $this->l('displayLeftColumn')),
                                array(
                                    'id' => 'displayLeftColumnProduct',
                                    'name' => $this->l('displayLeftColumnProduct')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB1',
                        'label' => $this->l('Menu direction type:'),
                        'name' => 'type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'horizontal',
                                    'name' => $this->l('Horizontal')),
                                array(
                                    'id' => 'vertical',
                                    'name' => $this->l('Vertical')),
                                array(
                                    'id' => 'full_screen',
                                    'name' => $this->l('Full screen')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB1',
                        'label' => $this->l('Menu width:'),
                        'name' => 'menu_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'full',
                                    'name' => $this->l('Full')),
                                array(
                                    'id' => 'container',
                                    'name' => $this->l('Container')),
                                array(
                                    'id' => 'max-content',
                                    'name' => $this->l('Max content')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Max menu depth:'),
                        'name' => 'max_depth',
                        'tab' => 'TAB1',
                        'col' => 2,
                        'suffix' => 'depth',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Hide vertical menu:'),
                        'name' => 'hidde_vertical_menu',
                        'tab' => 'TAB1',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable brands images:'),
                        'name' => 'brands_image',
                        'tab' => 'TAB1',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Brands name:'),
                        'name' => 'brands_name',
                        'tab' => 'TAB1',
                        'desc' => $this->l('Display brand name'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Image Type:'),
                        'name' => 'brands_img_type',
                        'desc' => $this->l('Select image type.'),
                        'tab' => 'TAB1',
                        'options' => array(
                            'query' => $this->getImageTypesByForm(),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable category images:'),
                        'name' => 'enable_category_images',
                        'tab' => 'TAB1',
                        'desc' => $this->l('only for depth 1'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable category image on hover:'),
                        'name' => 'enable_category_images_hover',
                        'tab' => 'TAB1',
                        'desc' => $this->l('not compatible with depth 0'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'tab' => 'TAB1',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    //TAB2
                    array(
                        'type' => 'link_choice',
                        'tab' => 'TAB2',
                        'label' => 'Links:',
                        'name' => 'link',
                        'lang' => true,
                    ),
                    //TAB3
                    array(
                        'type' => 'files_lang',
                        'label' => $this->l('Menu image background:'),
                        'name' => 'image',
                        'tab' => 'TAB3',
                        'lang' => true,
                        'col' => 6,
                        'desc' => $this->l(
                            'If the parallax type image - format file .png, 
                            .jpg, .gif. If the parallax type video - format file .mp4, .webm, .ogv.'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB4',
                        'label' => $this->l('Sub menu width:'),
                        'name' => 'sub_menu_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'submenu_content_width',
                                    'name' => $this->l('Content width')),
                                array(
                                    'id' => 'submenu_container_width',
                                    'name' => $this->l('Container width')),
                                array(
                                    'id' => 'submenu_full_width',
                                    'name' => $this->l('As top menu width')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB4',
                        'label' => $this->l('Sub menu popup width:'),
                        'name' => 'sub_menu_popup_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'popup_content_width',
                                    'name' => $this->l('Content width')),
                                array(
                                    'id' => 'popup_container_width',
                                    'name' => $this->l('Container width')),
                                array(
                                    'id' => 'popup_full_width',
                                    'name' => $this->l('Full width')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB3',
                        'label' => $this->l('Menu horizontal alignment:'),
                        'name' => 'menu_alignment',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'center_alignment',
                                    'name' => $this->l('Center')),
                                array(
                                    'id' => 'right_alignment',
                                    'name' => $this->l('Right')),
                                array(
                                    'id' => 'left_alignment',
                                    'name' => $this->l('Left')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Main menu color background:'),
                        'name' => 'color_background',
                        'tab' => 'TAB3',
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB3',
                        'label' => $this->l('Main menu text transform:'),
                        'name' => 'text_transform',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'unset',
                                    'name' => 'Unset'),
                                array(
                                    'id' => 'capitalize',
                                    'name' => 'Capitalize'),
                                array(
                                    'id' => 'lowercase',
                                    'name' => 'Lowercase'),
                                array(
                                    'id' => 'uppercase',
                                    'name' => 'Uppercase'),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Main menu categories color:'),
                        'name' => 'color_link',
                        'tab' => 'TAB3',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Main menu categories color on hover:'),
                        'name' => 'color_link_hover',
                        'tab' => 'TAB3',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Main categories font family:'),
                        'name' => 'menu_font_family',
                        'tab' => 'TAB3',
                        'options' => array(
                            'query' => $this->getConfigGoogleFont(),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Main menu categories font size:'),
                        'name' => 'menu_font_size',
                        'tab' => 'TAB3',
                        'col' => 2,
                        'suffix' => 'px',
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB3',
                        'label' => $this->l('Main menu hover effect:'),
                        'desc' => 'Only for desktop',
                        'name' => 'main_hover_effect',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'none',
                                    'name' => 'None'),
                                array(
                                    'id' => 'underline',
                                    'name' => 'Underline'),
                                array(
                                    'id' => 'text_shadow',
                                    'name' => 'Text shadow'),
                                array(
                                    'id' => 'background',
                                    'name' => 'Link background'),
                                array(
                                    'id' => 'overline',
                                    'name' => 'Overline'),
                                array(
                                    'id' => 'transformY',
                                    'name' => 'TransformY'),
                                array(
                                    'id' => 'both_line',
                                    'name' => 'Both line'),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color for hover effect:'),
                        'name' => 'color_hover_effect',
                        'tab' => 'TAB3',
                    ),
                    //TAB4
                    array(
                        'type' => 'color',
                        'label' => $this->l('Sub menu color background:'),
                        'name' => 'sub_color_background',
                        'tab' => 'TAB4',
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB4',
                        'label' => $this->l('Submenu direction type:'),
                        'name' => 'sub_direction_type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'horizontal',
                                    'name' => $this->l('Horizontal')),
                                array(
                                    'id' => 'vertical',
                                    'name' => $this->l('Vertical')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Collapse subcategories:'),
                        'name' => 'collapse_sub',
                        'tab' => 'TAB4',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu categories color:'),
                        'name' => 'sub_color_link',
                        'tab' => 'TAB4',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu categories color on hover:'),
                        'name' => 'sub_color_link_hover',
                        'tab' => 'TAB4',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu categories titles color:'),
                        'name' => 'sub_color_titles',
                        'tab' => 'TAB4',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Submenu categories titles color on hover:'),
                        'name' => 'sub_color_titles_hover',
                        'tab' => 'TAB4',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Sub categories font family:'),
                        'name' => 'sub_menu_font',
                        'tab' => 'TAB4',
                        'options' => array(
                            'query' => $this->getConfigGoogleFont(),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Sub menu categories font size:'),
                        'name' => 'sub_menu_font_size',
                        'tab' => 'TAB4',
                        'col' => 2,
                        'suffix' => 'px',
                    ),
                    //TAB5
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Hide on mobile devices and tablets:'),
                        'name' => 'hide_on_mobile',
                        'tab' => 'TAB5',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'tab' => 'TAB5',
                        'label' => $this->l('Mobile view on the screen:'),
                        'name' => 'mobile_view',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => '1200',
                                    'name' => '1200px'),
                                array(
                                    'id' => '992',
                                    'name' => '992px'),
                                array(
                                    'id' => '768',
                                    'name' => '768px'),
                                array(
                                    'id' => '576',
                                    'name' => '576px'),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Mobile menu color background:'),
                        'name' => 'mobile_background',
                        'tab' => 'TAB5',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Mobile menu color links:'),
                        'name' => 'mobile_links_color',
                        'tab' => 'TAB5',
                    ),
                    //TAB6
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable default contact info'),
                        'name' => 'enable_contact_info',
                        'tab' => 'TAB6',
                        'is_bool' => true,
                        'desc' => $this->l('compatible only with vertical and hidden menu type'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Custom text'),
                        'name' => 'custom_text',
                        'desc' => $this->l('compatible only with vertical and hidden menu type'),
                        'tab' => 'TAB6',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    //TAB7
                    // array(
                    //     'type' => 'text',
                    //     'tab' => 'TAB7',
                    //     'lang' => true,
                    //     'label' => $this->l('Facebook URL'),
                    //     'name' => 'social_facebook',
                    //     'desc' => $this->l('Your Facebook fan page.'),
                    // ),
                    // array(
                    //     'type' => 'text',
                    //     'tab' => 'TAB7',
                    //     'lang' => true,
                    //     'label' => $this->l('Twitter URL'),
                    //     'name' => 'social_twitter',
                    //     'desc' => $this->l('Your official Twitter account.'),
                    // ),
                    // array(
                    //     'type' => 'text',
                    //     'tab' => 'TAB7',
                    //     'lang' => true,
                    //     'label' => $this->l('YouTube URL'),
                    //     'name' => 'social_youtube',
                    //     'desc' => $this->l('Your official YouTube account.'),
                    // ),
                    // array(
                    //     'type' => 'text',
                    //     'tab' => 'TAB7',
                    //     'lang' => true,
                    //     'label' => $this->l('Instagram URL:'),
                    //     'name' => 'social_instagram',
                    //     'desc' => $this->l('Your official Instagram account.'),
                    // ),
                    // array(
                    //     'col' => 2,
                    //     'type' => 'text',
                    //     'name' => 'sort_order',
                    //     'class' => 'hidden'
                    // ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' .
                            $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonmegamenu') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonmegamenu((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
            $fields_form['form']['images'] = $tab->image;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonmegamenu';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name . '&id_tab='. Tools::getValue('id_tab');
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonmegamenuFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
            'image_baseurl_video' => $this->_path.'views/img/',
            'choices' => ClassBonmegamenuConstructor::renderChoicesSelect(),
            'selected_links' => ClassBonmegamenuConstructor::makeMenuOption()
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonmegamenuFormValues()
    {
        if ((bool)Tools::getIsset('updatebonmegamenu') && (int)Tools::getValue('id_tab') > 0 ||
        (bool)Tools::getIsset('updatebonmegamenulinks') && (int)Tools::getValue('id_tab') > 0 ||
        (bool)Tools::getIsset('deletebonmegamenulinks') && (int)Tools::getValue('id_tab') > 0 ||
        (bool)Tools::getIsset('submitUpdateBonmegamenu') && (int)Tools::getValue('id_tab') > 0 ||
        (bool)Tools::getIsset('submitUpdateBonmegamenuLinks') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonmegamenu((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassBonmegamenu();
        }
        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'position_desktop' => Tools::getValue('position_desktop', $tab->position_desktop),
            'position_mobile' => Tools::getValue('position_mobile', $tab->position_mobile),
            'type' => Tools::getValue('type', $tab->type),
            'menu_width' => Tools::getValue('menu_width', $tab->menu_width),
            'max_depth' => Tools::getValue('max_depth', $tab->max_depth),
            'hidde_vertical_menu' => Tools::getValue('hidde_vertical_menu', $tab->hidde_vertical_menu),
            'brands_image' => Tools::getValue('brands_image', $tab->brands_image),
            'brands_name' => Tools::getValue('brands_name', $tab->brands_name),
            'brands_img_type' => Tools::getValue('brands_img_type', $tab->brands_img_type),
            'enable_category_images' => Tools::getValue('enable_category_images', $tab->enable_category_images),
            'enable_category_images_hover' => Tools::getValue('enable_category_images_hover', $tab->enable_category_images_hover),
            'status' => Tools::getValue('status', $tab->status),
            'menu_items' => Tools::getValue('menu_items', $tab->menu_items),
            'image' => Tools::getValue('image', $tab->image),
            'menu_alignment' => Tools::getValue('menu_alignment', $tab->menu_alignment),
            'color_background' => Tools::getValue('color_background', $tab->color_background),
            'color_link' => Tools::getValue('color_link', $tab->color_link),
            'color_link_hover' => Tools::getValue('color_link_hover', $tab->color_link_hover),
            'menu_font_family' => Tools::getValue('menu_font_family', $tab->menu_font_family),
            'menu_font_size' => Tools::getValue('menu_font_size', $tab->menu_font_size),
            'sub_color_background' => Tools::getValue('sub_color_background', $tab->sub_color_background),
            'sub_direction_type' => Tools::getValue('sub_direction_type', $tab->sub_direction_type),
            'collapse_sub' => Tools::getValue('collapse_sub', $tab->collapse_sub),
            'sub_color_link' => Tools::getValue('sub_color_link', $tab->sub_color_link),
            'sub_color_link_hover' => Tools::getValue('sub_color_link_hover', $tab->sub_color_link_hover),
            'sub_color_titles' => Tools::getValue('sub_color_titles', $tab->sub_color_titles),
            'sub_color_titles_hover' => Tools::getValue('sub_color_titles_hover', $tab->sub_color_titles_hover),
            'sub_menu_popup_width' => Tools::getValue('sub_menu_popup_width', $tab->sub_menu_popup_width),
            'sub_menu_width' => Tools::getValue('sub_menu_width', $tab->sub_menu_width),
            'sub_menu_font' => Tools::getValue('sub_menu_font', $tab->sub_menu_font),
            'sub_menu_font_size' => Tools::getValue('sub_menu_font_size', $tab->sub_menu_font_size),
            'hide_on_mobile' => Tools::getValue('hide_on_mobile', $tab->hide_on_mobile),
            'mobile_view' => Tools::getValue('mobile_view', $tab->mobile_view),
            'mobile_background' => Tools::getValue('mobile_background', $tab->mobile_background),
            'main_hover_effect' => Tools::getValue('main_hover_effect', $tab->main_hover_effect),
            'color_hover_effect' => Tools::getValue('color_hover_effect', $tab->color_hover_effect),
            'text_transform' => Tools::getValue('text_transform', $tab->text_transform),
            'mobile_links_color' => Tools::getValue('mobile_links_color', $tab->mobile_links_color),
            'enable_contact_info' => Tools::getValue('enable_contact_info', $tab->enable_contact_info),
            'social_facebook' => Tools::getValue('social_facebook', $tab->social_facebook),
            'social_instagram' => Tools::getValue('social_instagram', $tab->social_instagram),
            'social_youtube' => Tools::getValue('social_youtube', $tab->social_youtube),
            'social_twitter' => Tools::getValue('social_twitter', $tab->social_twitter),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        );

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields_values['custom_text'][$lang['id_lang']] = Tools::getValue(
                'custom_text_' . (int) $lang['id_lang'],
                isset($tab->custom_text[$lang['id_lang']]) ? $tab->custom_text[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    public function renderBonmegamenuCategoryList()
    {
        if (!$tabs = ClassBonmegamenu::getBonmegamenuCategoryList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'position_desktop' => array(
                'title' => $this->l('Hook desktop'),
                'type'  => 'text',
                'align' => 'center',
                'search' => false,
            ),
            'position_mobile' => array(
                'title' => $this->l('Hook mobile'),
                'type'  => 'text',
                'align' => 'center',
                'search' => false,
            ),
            'type' => array(
                'title' => $this->l('Type'),
                'type'  => 'text',
                'align' => 'center',
                'search' => false,
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ),
            'sort_order' => array(
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle'
            )
        );

        $helper = new HelperList();

        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_tab';
        $helper->table = 'bonmegamenu';
        $helper->actions = array('view', 'edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&add' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new item')
        );
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' . (int)$this->context->shop->id;

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateList($tabs, $fields_list);
    }
    

    protected function addBonmegamenu()
    {
        $errors = array();
        
        if ((int)Tools::getValue('id_tab') > 0) {
            $item = new ClassBonmegamenu((int)Tools::getValue('id_tab'));
        } else {
            $item = new ClassBonmegamenu();
        }

        $item->id_shop = (int)$this->context->shop->id;


        $item->position_desktop = Tools::getValue('position_desktop');
        $item->position_mobile = Tools::getValue('position_mobile');
        $item->type = Tools::getValue('type');
        $item->menu_width = Tools::getValue('menu_width');
        $item->max_depth = Tools::getValue('max_depth');
        $item->hidde_vertical_menu = Tools::getValue('hidde_vertical_menu');
        $item->brands_image = Tools::getValue('brands_image');
        $item->brands_name = Tools::getValue('brands_name');
        $item->brands_img_type = Tools::getValue('brands_img_type');
        $item->enable_category_images = Tools::getValue('enable_category_images');
        $item->enable_category_images_hover = Tools::getValue('enable_category_images_hover');
        $item->status = (int)Tools::getValue('status');
        $item->menu_alignment = Tools::getValue('menu_alignment');
        $item->color_background = Tools::getValue('color_background');
        $item->color_link = Tools::getValue('color_link');
        $item->color_link_hover = Tools::getValue('color_link_hover');
        $item->menu_font_family = Tools::getValue('menu_font_family');
        $item->menu_font_size = Tools::getValue('menu_font_size');
        $item->sub_color_background = Tools::getValue('sub_color_background');
        $item->sub_direction_type = Tools::getValue('sub_direction_type');
        $item->sub_menu_width = Tools::getValue('sub_menu_width');
        $item->sub_menu_popup_width = Tools::getValue('sub_menu_popup_width');
        $item->collapse_sub = Tools::getValue('collapse_sub');
        $item->sub_color_link = Tools::getValue('sub_color_link');
        $item->sub_color_link_hover = Tools::getValue('sub_color_link_hover');
        $item->sub_color_titles_hover = Tools::getValue('sub_color_titles_hover');
        $item->sub_color_titles = Tools::getValue('sub_color_titles');
        $item->sub_menu_font = Tools::getValue('sub_menu_font');
        $item->sub_menu_font_size = Tools::getValue('sub_menu_font_size');
        $item->hide_on_mobile = Tools::getValue('hide_on_mobile');
        $item->mobile_view = Tools::getValue('mobile_view');
        $item->mobile_background = Tools::getValue('mobile_background');
        $item->text_transform = Tools::getValue('text_transform');
        $item->main_hover_effect = Tools::getValue('main_hover_effect');
        $item->color_hover_effect = Tools::getValue('color_hover_effect');
        $item->mobile_links_color = Tools::getValue('mobile_links_color');
        $item->enable_contact_info = Tools::getValue('enable_contact_info');


        $item->menu_items = Tools::getValue('menu_items') ? implode(",", Tools::getValue('menu_items')) : '';
        
        if ((int)Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $item->custom_text[$language['id_lang']] = Tools::getValue('custom_text_'.$language['id_lang']);
            $item->social_facebook[$language['id_lang']] = Tools::getValue('social_facebook_'.$language['id_lang']);
            $item->social_youtube[$language['id_lang']] = Tools::getValue('social_youtube_'.$language['id_lang']);
            $item->social_instagram[$language['id_lang']] = Tools::getValue('social_instagram_'.$language['id_lang']);
            $item->social_twitter[$language['id_lang']] = Tools::getValue('social_twitter_'.$language['id_lang']);
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));

            $imagesize = $_FILES['image_'.$language['id_lang']]["tmp_name"] != '' ? @getimagesize($_FILES['image_'.$language['id_lang']]["tmp_name"]) : '';
            if (isset($_FILES['image_'.$language['id_lang']])
                && isset($_FILES['image_'.$language['id_lang']]['tmp_name'])
                && !empty($_FILES['image_'.$language['id_lang']]['tmp_name'])
                && !empty($imagesize)
                && in_array(
                    Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)),
                    array('jpg', 'gif', 'jpeg', 'png', 'webp')
                )
                && in_array($type, array('jpg', 'gif', 'jpeg', 'png', 'webp'))) {
                $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                $salt = sha1(microtime());
                if ($error = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']])) {
                    $errors[] = $error;
                } elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.
                    $language['id_lang']]['tmp_name'], $temp_name)) {
                    return false;
                } elseif (!ImageManager::resize($temp_name, dirname(__FILE__).
                    '/views/img/'.$salt.'_'.$_FILES['image_'.
                    $language['id_lang']]['name'], null, null, $type)) {
                    $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                }

                if (isset($temp_name)) {
                    @unlink($temp_name);
                }
                $item->image[$language['id_lang']] = $salt.'_'.$_FILES['image_'.$language['id_lang']]['name'];
            } elseif (Tools::getValue('image_old_'.$language['id_lang']) != '') {
                $item->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
            }
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The item is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonmegamenu((int)Tools::getValue('id_tab'));
        $old_image = $class->image;
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

        foreach ($languages as $lang) {
            if (!Tools::isEmpty($_FILES['image_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png, .webp');
                }
            }
        }
        
        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of menu is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of menu format.');
        }

        if (!Validate::isColor(Tools::getValue('color_background'))
        || !Validate::isColor(Tools::getValue('color_link_hover'))
        || !Validate::isColor(Tools::getValue('sub_color_background'))
        || !Validate::isColor(Tools::getValue('sub_color_link'))
        || !Validate::isColor(Tools::getValue('sub_color_titles'))
        || !Validate::isColor(Tools::getValue('sub_color_titles_hover'))
        || !Validate::isColor(Tools::getValue('mobile_background'))
        || !Validate::isColor(Tools::getValue('mobile_background'))
        || !Validate::isColor(Tools::getValue('color_hover_effect'))
        || !Validate::isColor(Tools::getValue('color_link'))
        || !Validate::isColor(Tools::getValue('mobile_links_color'))) {
            $errors[] = $this->l('Color format error.');
        }

        if (!Tools::isEmpty(Tools::getValue('max_depth')) && !Validate::isUnsignedInt(Tools::getValue('max_depth'))
        || !Tools::isEmpty(Tools::getValue('sub_menu_font_size')) && !Validate::isUnsignedInt(Tools::getValue('sub_menu_font_size'))
        || !Tools::isEmpty(Tools::getValue('menu_font_size')) && !Validate::isUnsignedInt(Tools::getValue('menu_font_size'))) {
            $errors[] = $this->l('Bad number format');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonmegamenu()
    {
        $tab = new ClassBonmegamenu(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if ($tab->delete()) {
            $tabs = ClassBonmegamenuSubcategory::getBonmegamenuSubcategoryList((int)Tools::getValue('id_tab'));
            if ($tabs) {
                foreach ($tabs as $tab) {
                    $tab = new ClassBonmegamenuSubcategory($tab['id_tab']);
                    $tab->delete();
                }
            }

            $this->_confirmations = $this->l('Slider deleted.');
        }

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassBonmegamenu(Tools::getValue('id_tab'));

        if ($tab->status == 1) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The tab status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The tab status is successfully updated.'));
    }
    // start main menu settings

    // start category links
    protected function renderBonmegamenuCategoryLinksForm()
    {
        $shops = Shop::getContextListShopID();

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_sub') ?
                        $this->l('Update link') :
                        $this->l('Add link')),
                    'icon' => 'icon-cogs',
                ),
                'input' => [
                    array(
                        'col'   => 2,
                        'type'  => 'text',
                        'name'  => 'id_tab',
                        'class' => 'hidden'
                    ),
                    [
                        'type' => 'text',
                        'label' => $this->l('Label'),
                        'name' => 'label',
                        'lang' => true,
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' =>  $this->l('Link'),
                        'placeholder' => 'http://www.example.com',
                        'name' => 'link',
                        'required' => true,
                        'lang' => true,
                    ],
                    [
                        'type' => 'switch',
                        'label' =>  $this->l('New window'),
                        'name' => 'new_window',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' =>  $this->l('Yes'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' =>  $this->l('No'),
                            ],
                        ],
                    ],
                ],
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' .
                            $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonmegamenulinks') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenu((int)Tools::getValue('id_sub'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_sub', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonmegamenuLinks';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonmegamenuLinksFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonmegamenuLinksFormValues()
    {
        if ((bool)Tools::getIsset('updatebonmegamenulinks') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuLinks((int)Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBonmegamenuLinks();
        }
 
        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_sub' => Tools::getValue('id_sub'),
            'label' => Tools::getValue('label', $tab->label),
            'link' => Tools::getValue('link', $tab->link),
            'new_window' => Tools::getValue('new_window', $tab->new_window),
        );

        return $fields_values;
    }

    protected function preValidateLinksForm()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonmegamenuLinks((int)Tools::getValue('id_sub'));
        

        if (Tools::isEmpty(Tools::getValue('label_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The label of link is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('label_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad label of link format.');
        }

        if (Tools::isEmpty(Tools::getValue('link_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The link is required.');
        } elseif (!Validate::isUrl(Tools::getValue('link_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad link format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }


    protected function deleteBonmegamenuLinks()
    {
        $tab = new ClassBonmegamenuLinks(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function addBonmegamenuLinks()
    {
        $errors = array();
        
        if ((int)Tools::getValue('id_sub') > 0) {
            $item = new ClassBonmegamenuLinks((int)Tools::getValue('id_sub'));
        } else {
            $item = new ClassBonmegamenuLinks();
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->new_window = Tools::getValue('new_window');
        $item->id_tab = (int)Tools::getValue('id_tab');

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->label[$language['id_lang']] = Tools::getValue('label_'.$language['id_lang']);
            $item->link[$language['id_lang']] = Tools::getValue('link_'.$language['id_lang']);
        }

        if (!$errors) {
            if (!Tools::getValue('id_sub')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The item is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    public function renderBonmegamenuLinksList()
    {
        $shops = Shop::getContextListShopID();
        $links = [];

        foreach ($shops as $shop_id) {
            $class_links = ClassBonmegamenuLinks::getBonmegamenuLinksList((int)Tools::getValue('id_tab'));
            $links = array_merge($links, $class_links ? $class_links : []);
        }

        $fields_list = [
            'id_sub' => [
                'title' => $this->l('Link ID'),
                'type' => 'text',
            ],
            'label' => [
                'title' => $this->l('Label'),
                'type' => 'text',
            ],
            'link' => [
                'title' => $this->l('Link'),
                'type' => 'link',
            ],
            'new_window' => [
                'title' => $this->l('New window'),
                'type' => 'bool',
                'align' => 'center',
                'active' => 'status',
            ],
        ];

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->identifier = 'id_sub';
        $helper->table = 'bonmegamenulinks';
        $helper->actions = ['edit', 'delete'];
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->title = $this->l('Link list');
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name . '&id_tab='. Tools::getValue('id_tab');
        if (count($links) > 0) {
            return $helper->generateList($links, $fields_list);
        } else {
            return false;
        }
    }

    // end category links
          
    public function selectedCategories($categories, $enable_children = false)
    {
        foreach ($categories as $key => $tab) {
            $level_depth = isset($tab['level_depth']) ? $tab['level_depth'] : 1;
            array_push(
                $this->category,
                array(
                    'id_option' => $tab['page_identifier'],
                    'name' => str_repeat('&nbsp;', '3' * (int)$level_depth) . $tab['label']
                )
            );
 
            if (isset($tab['children']) && $enable_children) {
                $this->selectedCategories($tab['children'], $enable_children);
            }
        }
    }

    /* start subcategory view form and list */

    protected function renderBonmegamenuSubcategoryViewForm()
    {
        $menu = ClassBonmegamenuConstructor::makeMenu((int)Tools::getValue('id_tab'));
        $menu_items = $menu['children'];
    
        $this->selectedCategories($menu_items, false);
        // array_shift($this->category);

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_sub') ?
                        $this->l('Update subcategory view') :
                        $this->l('Add subcategory')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col'   => 2,
                        'type'  => 'text',
                        'name'  => 'id_tab',
                        'class' => 'hidden'
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_modules_categories',
                        'label' => $this->l('Select link:'),
                        'name' => 'id_category',
                        'options' => array(
                            'query' => $this->category,
                            'id' => 'id_option',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select column width:'),
                        'name' => 'column_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'width-col-12',
                                    'name' => $this->l('100%')
                                ),
                                array(
                                    'id' => 'width-col-6',
                                    'name' => $this->l('50%')
                                ),
                                array(
                                    'id' => 'width-col-4',
                                    'name' => $this->l('30%')
                                ),
                                array(
                                    'id' => 'width-col-3',
                                    'name' => $this->l('25%')
                                ),
                                array(
                                    'id' => 'width-col-2',
                                    'name' => $this->l('20%')
                                ),
                            ),
                            'name' => 'name',
                            'id' => 'id',
                            'index' => 'content_type'
                        ),
                        'col' => 2,
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('View type:'),
                        'name' => 'view_type',
                        'values' => array(
                            array(
                                'id' => 'type_1',
                                'value' => 'type_1',
                                'label' => $this->l('Type_1'),
                                'img_link' => $this->_path . 'views/img/view_type_1.png'
                            ),
                            array(
                                'id' => 'type_2',
                                'value' => 'type_2',
                                'label' => $this->l('Type_2'),
                                'img_link' => $this->_path . 'views/img/view_type_2.png'
                            ),
                            array(
                                'id' => 'type_3',
                                'value' => 'type_3',
                                'label' => $this->l('Type_3'),
                                'img_link' => $this->_path . 'views/img/view_type_3.png'
                            ),
                            array(
                                'id' => 'type_4',
                                'value' => 'type_4',
                                'label' => $this->l('Type_4'),
                                'img_link' => $this->_path . 'views/img/view_type_4.png'
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable category description:'),
                        'name' => 'enable_category_description',
                        'tab' => 'TAB1',
                        'desc' => $this->l('only for depth 1'),
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'type'  => 'submit',
                ),
                'buttons' => array(
                    array(
                        'href'  => AdminController::$currentIndex.'&configure='.$this->name.'&viewbonmegamenu&id_tab='.
                            Tools::getValue('id_tab').'&token='.Tools::getAdminTokenLite('AdminModules') .
                            '&id_shop='. (int)$this->context->shop->id,
                        'title' => $this->l('Cancel'),
                        'icon'  => 'process-icon-cancel'
                    ),
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name .
                            '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to main page'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonmegamenu_sub_view') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuSubcategoryView((int)Tools::getValue('id_sub'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_sub', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonmegamenuSubView';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonmegamenuSubcategoryViewFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonmegamenuSubcategoryViewFormValues()
    {
        if ((bool)Tools::getIsset('updatebonmegamenu_sub_view') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuSubcategoryView((int)Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBonmegamenuSubcategoryView();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_sub' => Tools::getValue('id_sub'),
            'id_category' => Tools::getValue('id_category', $tab->id_category),
            'column_width' => Tools::getValue('column_width', $tab->column_width),
            'view_type' => Tools::getValue('view_type', $tab->view_type),
             'enable_category_description' => Tools::getValue('enable_category_description', $tab->enable_category_description),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        );
    
        return $fields_values;
    }

    public function renderBonmegamenuSubcategoryViewList()
    {
        if (!$tabs = ClassBonmegamenuSubcategoryView::getBonmegamenuSubcategoryList(Tools::getValue('id_tab'))) {
            $tabs = array();
        }

        $fields_list = array(
            'id_sub' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'id_tab' => array(
                'title' => ($this->l('Id tab')),
                'type'  => 'text',
                'class' => 'hidden id_tab',
                'search' => false,
                'orderby' => false,
            ),
            'id_category' => array(
                'title' => ($this->l('Page identifier')),
                'type'  => 'text',
                'align' => 'center',
                'search' => false,
            ),
            'view_type' => array(
                'title' => $this->l('View type'),
                'type'  => 'view_type',
                'search' => false,
                'orderby' => false,
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ),
            'sort_order' => array(
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle'
            ),
            
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_sub';
        $helper->table = 'bonmegamenu_sub_view';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->l('Subcategory view');
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
            . '&configure=' . $this->name . '&addsub_view_' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules')
                . '&id_shop=' . (int)$this->context->shop->id
                . '&id_tab=' .Tools::getValue('id_tab'),
            'desc' => $this->l('Add new item')
        );
        $helper->toolbar_btn['back'] = array(
            'href' => AdminController::$currentIndex.'&configure='.$this->name .
                '&token='.Tools::getAdminTokenLite('AdminModules') . '&id_shop=' . (int)$this->context->shop->id,
            'desc' => $this->l('Back to main page')
        );
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' .
            (int)$this->context->shop->id . '&id_tab=' .Tools::getValue('id_tab');

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonmegamenuSubView()
    {
        $errors = array();

        if ((int)Tools::getValue('id_sub') > 0) {
            $item = new ClassBonmegamenuSubcategoryView((int)Tools::getValue('id_sub'));
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item = new ClassBonmegamenuSubcategoryView();
            $item->sort_order = $item->getMaxSortOrder((int)Tools::getValue('id_tab'));
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->id_tab = (int)Tools::getValue('id_tab');
        $item->status = (int)Tools::getValue('status');
        $item->enable_category_description = (int) Tools::getValue('enable_category_description');
        $item->id_category = pSql(Tools::getValue('id_category'));
        $item->column_width = pSql(Tools::getValue('column_width'));
        $item->view_type = pSql(Tools::getValue('view_type'));

        if (!$errors) {
            if (!Tools::getValue('id_sub')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The subcategory is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function deleteBonmegamenuSubView()
    {
        $tab = new ClassBonmegamenuSubcategoryView(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the subcategory'));
        }

        return $this->displayConfirmation($this->l('The subcategory is successfully deleted'));
    }
    
    protected function updateStatusSubcategoryView()
    {
        $tab = new ClassBonmegamenuSubcategoryView(Tools::getValue('id_sub'));

        if ($tab->status == 1) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The subcategory status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The subcategory status is successfully updated.'));
    }
    
    /* end subcategory view form and list */
    
    /* start banners and video form and list */

    protected function renderBonmegamenuSubcategoryForm()
    {
        $menu = ClassBonmegamenuConstructor::makeMenu((int)Tools::getValue('id_tab'));
        $menu_items = $menu['children'];
  
        $this->selectedCategories($menu_items, false);
        // array_shift($this->category);

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_sub') ?
                        $this->l('Update subcategory banners and video') :
                        $this->l('Add subcategory')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col'   => 2,
                        'type'  => 'text',
                        'name'  => 'id_tab',
                        'class' => 'hidden'
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title:'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_modules_categories',
                        'label' => $this->l('Select link:'),
                        'name' => 'id_category',
                        'options' => array(
                            'query' => $this->category,
                            'id' => 'id_option',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select content type:'),
                        'name' => 'content_type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'video',
                                    'name' => $this->l('YouTube Video')
                                ),
                                array(
                                    'id' => 'banner',
                                    'name' => $this->l('Banner')
                                ),
                                array(
                                    'id' => 'background_image',
                                    'name' => $this->l('Background image')
                                ),
                                array(
                                    'id' => 'category_image',
                                    'name' => $this->l('Category image')
                                ),
                            ),
                            'name' => 'name',
                            'id' => 'id',
                            'index' => 'content_type'
                        ),
                        'col' => 2,
                    ),
                    array(
                        'type' => 'files_lang_sub',
                        'label' => $this->l('Image:'),
                        'name' => 'image',
                        'lang' => true,
                        'col' => 6,
                        'desc' => $this->l('Format file .png, .jpg, .gif.'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select banner width:'),
                        'name' => 'banner_width',
                        'desc' => $this->l('Does not apply to content type "background image"'),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'col-xl-12',
                                    'name' => $this->l('100%')
                                ),
                                array(
                                    'id' => 'col-xl-6',
                                    'name' => $this->l('50%')
                                ),
                                array(
                                    'id' => 'col-xl-4',
                                    'name' => $this->l('30%')
                                ),
                                array(
                                    'id' => 'col-xl-3',
                                    'name' => $this->l('25%')
                                ),
                            ),
                            'name' => 'name',
                            'id' => 'id',
                            'index' => 'banner_width'
                        ),
                        'col' => 2,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select description type:'),
                        'name' => 'description_type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'none',
                                    'name' => $this->l('Without description')
                                ),
                                array(
                                    'id' => 'category_description',
                                    'name' => $this->l('Category description')
                                ),
                                array(
                                    'id' => 'custom_description',
                                    'name' => $this->l('Custom description')
                                ),
                            ),
                            'name' => 'name',
                            'id' => 'id',
                            'index' => 'description_type'
                        ),
                        'col' => 2,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'banner_description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('YouTube video code:'),
                        'name' => 'youtube_video',
                        'placeholder' => '8c_9oKx81K4',
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'type'  => 'submit',
                ),
                'buttons' => array(
                    array(
                        'href'  => AdminController::$currentIndex.'&configure='.$this->name.'&viewbonmegamenu&id_tab='.
                            Tools::getValue('id_tab').'&token='.Tools::getAdminTokenLite('AdminModules') .
                            '&id_shop='. (int)$this->context->shop->id,
                        'title' => $this->l('Cancel'),
                        'icon'  => 'process-icon-cancel'
                    ),
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name .
                            '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to main page'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonmegamenu_sub') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuSubcategory((int)Tools::getValue('id_sub'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_sub', 'value' => (int)$tab->id);
            $fields_form['form']['images'] = $tab->image;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonmegamenuSub';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonmegamenuSubcategoryFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonmegamenuSubcategoryFormValues()
    {
        if ((bool)Tools::getIsset('updatebonmegamenu_sub') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuSubcategory((int)Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBonmegamenuSubcategory();
        }
        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_sub' => Tools::getValue('id_sub'),
            'id_category' => Tools::getValue('id_category', $tab->id_category),
            'title' => Tools::getValue('title', $tab->title),
            'youtube_video' => Tools::getValue('youtube_video', $tab->youtube_video),
            'content_type' => Tools::getValue('content_type', $tab->content_type),
            'description_type' => Tools::getValue('description_type', $tab->description_type),
            'banner_width' => Tools::getValue('banner_width', $tab->banner_width),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
            'image' => Tools::getValue('image', $tab->image),
        );

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields_values['banner_description'][$lang['id_lang']] = Tools::getValue(
                'banner_description_' . (int) $lang['id_lang'],
                isset($tab->banner_description[$lang['id_lang']]) ? $tab->banner_description[$lang['id_lang']] : ''
            );
        }

 
        return $fields_values;
    }

    public function renderBonmegamenuSubcategoryList()
    {
        if (!$tabs = ClassBonmegamenuSubcategory::getBonmegamenuSubcategoryList(Tools::getValue('id_tab'))) {
            $tabs = array();
        }

        $fields_list = array(
            'id_sub' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'id_tab' => array(
                'title' => ($this->l('Id tab')),
                'type'  => 'text',
                'class' => 'hidden id_tab',
                'search' => false,
                'orderby' => false,
            ),
            'id_category' => array(
                'title' => ($this->l('Page identifier')),
                'type'  => 'text',
                'align' => 'center',
                'search' => false,
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'content_type' => array(
                'title' => $this->l('Content type'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'images' => array(
                'title' => $this->l('Banner/Video'),
                'type'  => 'box_image',
                'align' => 'center',
                'search' => false,
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ),
            'sort_order' => array(
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle'
            ),
            
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_sub';
        $helper->table = 'bonmegamenu_sub';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->l('Banner and Video');
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&addsub' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules')
                . '&id_shop=' . (int)$this->context->shop->id
                . '&id_tab=' .Tools::getValue('id_tab'),
            'desc' => $this->l('Add new item')
        );
        $helper->toolbar_btn['back'] = array(
            'href' => AdminController::$currentIndex.'&configure='.$this->name .
                '&token='.Tools::getAdminTokenLite('AdminModules') . '&id_shop=' . (int)$this->context->shop->id,
            'desc' => $this->l('Back to main page')
        );
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' .
            (int)$this->context->shop->id . '&id_tab=' .Tools::getValue('id_tab');

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonmegamenuSub()
    {
        $errors = array();

        if ((int)Tools::getValue('id_sub') > 0) {
            $item = new ClassBonmegamenuSubcategory((int)Tools::getValue('id_sub'));
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item = new ClassBonmegamenuSubcategory();
            $item->sort_order = $item->getMaxSortOrder((int)Tools::getValue('id_tab'));
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->id_tab = (int)Tools::getValue('id_tab');
        $item->status = (int)Tools::getValue('status');
        $item->id_category = pSql(Tools::getValue('id_category'));
        $item->content_type = pSql(Tools::getValue('content_type'));
        $item->description_type = pSql(Tools::getValue('description_type'));
        $item->banner_width = pSql(Tools::getValue('banner_width'));

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
            $item->youtube_video[$language['id_lang']] = Tools::getValue('youtube_video_' . $language['id_lang']);
            $item->banner_description[$language['id_lang']] = Tools::getValue('banner_description_' . $language['id_lang']);
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_' . $language['id_lang']]['name'], '.'), 1));

            $imagesize = $_FILES['image_'.$language['id_lang']]["tmp_name"] != '' ? @getimagesize($_FILES['image_'.$language['id_lang']]["tmp_name"]) : '';
            if (isset($_FILES['image_' . $language['id_lang']])
                && isset($_FILES['image_' . $language['id_lang']]['tmp_name'])
                && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])
                && !empty($imagesize)
                && in_array(
                    Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)),
                    array('jpg', 'gif', 'jpeg', 'png', 'webp')
                )
                && in_array($type, array('jpg', 'gif', 'jpeg', 'png', 'webp'))
            ) {
                $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                $salt = sha1(microtime());
                if ($error = ImageManager::validateUpload($_FILES['image_' . $language['id_lang']])) {
                    $errors[] = $error;
                } elseif (!$temp_name || !move_uploaded_file($_FILES['image_' .
                    $language['id_lang']]['tmp_name'], $temp_name)) {
                    return false;
                } elseif (!ImageManager::resize($temp_name, dirname(__FILE__) .
                    '/views/img/' . $salt . '_' .
                    $_FILES['image_' . $language['id_lang']]['name'], null, null, $type)) {
                    $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                }

                if (isset($temp_name)) {
                    @unlink($temp_name);
                }
                $item->image[$language['id_lang']] = $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'];
            } elseif (Tools::getValue('image_old_' . $language['id_lang']) != '') {
                $item->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
            }
        }

        if (!$errors) {
            if (!Tools::getValue('id_sub')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The subcategory is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateFormSub()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonmegamenuSubcategory((int)Tools::getValue('id_sub'));


        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of item is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of item.');
        }
       
        foreach ($languages as $lang) {
            if (!Tools::isEmpty($_FILES['image_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png, .webp');
                }
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonmegamenuSub()
    {
        $tab = new ClassBonmegamenuSubcategory(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the subcategory'));
        }

        return $this->displayConfirmation($this->l('The subcategory is successfully deleted'));
    }
    
    protected function updateStatusSubcategory()
    {
        $tab = new ClassBonmegamenuSubcategory(Tools::getValue('id_sub'));

        if ($tab->status == 1) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The subcategory status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The subcategory status is successfully updated.'));
    }

    /* end banners and video form and list */


    /* start product form and list */
    protected function renderBonmegamenuSubcategoryProductForm()
    {
        $menu = ClassBonmegamenuConstructor::makeMenu((int)Tools::getValue('id_tab'));
        $menu_items = $menu['children'];
  
        $this->selectedCategories($menu_items, false);
        
        // array_shift($this->category);

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_sub') ?
                        $this->l('Update subcategory products') :
                        $this->l('Add subcategory')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col'   => 2,
                        'type'  => 'text',
                        'name'  => 'id_tab',
                        'class' => 'hidden'
                    ),
                    array(
                        'form_group_class' => 'display-block-product',
                        'type' => 'select_product',
                        'label' => $this->l('Select a product:'),
                        'class' => 'id_product',
                        'name' => 'id_product',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title:'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_modules_categories',
                        'label' => $this->l('Select link:'),
                        'name' => 'id_category',
                        'options' => array(
                            'query' => $this->category,
                            'id' => 'id_option',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select product width:'),
                        'name' => 'product_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'col-xl-12',
                                    'name' => $this->l('100%')
                                ),
                                array(
                                    'id' => 'col-xl-6',
                                    'name' => $this->l('50%')
                                ),
                                array(
                                    'id' => 'col-xl-4',
                                    'name' => $this->l('30%')
                                ),
                                array(
                                    'id' => 'col-xl-3',
                                    'name' => $this->l('25%')
                                ),
                            ),
                            'name' => 'name',
                            'id' => 'id',
                            'index' => 'product_width'
                        ),
                        'col' => 2,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'type'  => 'submit',
                ),
                'buttons' => array(
                    array(
                        'href'  => AdminController::$currentIndex.'&configure='.$this->name.'&viewbonmegamenu&id_tab='.
                            Tools::getValue('id_tab').'&token='.Tools::getAdminTokenLite('AdminModules') .
                            '&id_shop='. (int)$this->context->shop->id,
                        'title' => $this->l('Cancel'),
                        'icon'  => 'process-icon-cancel'
                    ),
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name .
                            '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to main page'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonmegamenu_sub_prod') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuSubcategoryProduct((int)Tools::getValue('id_sub'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_sub', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonmegamenuSubProd';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonmegamenuSubcategoryProductFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'link' => new Link(),
            'base_dir' => $this->ssl,
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonmegamenuSubcategoryProductFormValues()
    {
        if ((bool)Tools::getIsset('updatebonmegamenu_sub_prod') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuSubcategoryProduct((int)Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBonmegamenuSubcategoryProduct();
        }
        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_sub' => Tools::getValue('id_sub'),
            'id_category' => Tools::getValue('id_category', $tab->id_category),
            'id_product' => Tools::getValue('id_product', $tab->id_product),
            'product_width' => Tools::getValue('product_width', $tab->product_width),
            'product_name' => ClassBonmegamenuSubcategoryProduct::getProductName($tab->id_product),
            'link_rewrite' => ClassBonmegamenuSubcategoryProduct::getProductLinkRewrite($tab->id_product),
            'title' => Tools::getValue('title', $tab->title),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        );
        
        return $fields_values;
    }

    public function renderBonmegamenuSubcategoryProductsList()
    {
        if (!$tabs = ClassBonmegamenuSubcategoryProduct::getBonmegamenuSubcategoryList(Tools::getValue('id_tab'))) {
            $tabs = array();
        }

        $fields_list = array(
            'id_sub' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'id_tab' => array(
                'title' => ($this->l('Id tab')),
                'type'  => 'text',
                'class' => 'hidden id_tab',
                'search' => false,
                'orderby' => false,
            ),
            'id_category' => array(
                'title' => ($this->l('Page identifier')),
                'type'  => 'text',
                'align' => 'center',
                'search' => false,
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'image' => array(
                'title' => $this->l('Product Image'),
                'type'  => 'block_image',
                'align' => 'center',
                'search' => false,
            ),
            'id_product' => array(
                'title' => $this->l('Id product'),
                'type'  => 'id_product',
                'align' => 'center',
                'search' => false,
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ),
            'sort_order' => array(
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle'
            ),
            
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_sub';
        $helper->table = 'bonmegamenu_sub_prod';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->l('Products');
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&addsub_prod_' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules')
                . '&id_shop=' . (int)$this->context->shop->id
                . '&id_tab=' .Tools::getValue('id_tab'),
            'desc' => $this->l('Add new item')
        );
        $helper->toolbar_btn['back'] = array(
            'href' => AdminController::$currentIndex.'&configure='.$this->name .
                '&token='.Tools::getAdminTokenLite('AdminModules') . '&id_shop=' . (int)$this->context->shop->id,
            'desc' => $this->l('Back to main page')
        );
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' .
            (int)$this->context->shop->id . '&id_tab=' .Tools::getValue('id_tab');

        $helper->tpl_vars = array(
            'link' => new Link(),
            'ps_version' => _PS_VERSION_,
            'base_dir' => $this->ssl,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'images/',
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonmegamenuSubProduct()
    {
        $errors = array();

        if ((int)Tools::getValue('id_sub') > 0) {
            $item = new ClassBonmegamenuSubcategoryProduct((int)Tools::getValue('id_sub'));
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item = new ClassBonmegamenuSubcategoryProduct();
            $item->sort_order = $item->getMaxSortOrder((int)Tools::getValue('id_tab'));
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->id_tab = (int)Tools::getValue('id_tab');
        $item->status = (int)Tools::getValue('status');
        $item->id_category = pSql(Tools::getValue('id_category'));
        $item->id_product = (int)Tools::getValue('id_product');
        $item->product_width = Tools::getValue('product_width');

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
        }

        if (!$errors) {
            if (!Tools::getValue('id_sub')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The subcategory is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateFormSubProduct()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonmegamenuSubcategoryProduct((int)Tools::getValue('id_sub'));

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of item is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of item format.');
        }

        if (Tools::isEmpty(Tools::getValue('id_product'))) {
            $errors[] = $this->l('The product is required.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonmegamenuSubProduct()
    {
        $tab = new ClassBonmegamenuSubcategoryProduct(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the subcategory'));
        }

        return $this->displayConfirmation($this->l('The subcategory is successfully deleted'));
    }
    
    protected function updateStatusSubcategoryProduct()
    {
        $tab = new ClassBonmegamenuSubcategoryProduct(Tools::getValue('id_sub'));

        if ($tab->status == 1) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The subcategory status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The subcategory status is successfully updated.'));
    }

    /* end product form and list */



    /* start labels and icons form and list */
    
    public function renderBonmegamenuSubcategoryLabelsList()
    {
        if (!$tabs = ClassBonmegamenuSubcategoryLabel::getBonmegamenuSubcategoryList(Tools::getValue('id_tab'))) {
            $tabs = array();
        }

        $fields_list = array(
            'id_sub' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'id_tab' => array(
                'title' => ($this->l('Id tab')),
                'type'  => 'text',
                'class' => 'hidden id_tab',
                'search' => false,
                'orderby' => false,
            ),
            'id_category' => array(
                'title' => ($this->l('Page identifier')),
                'type'  => 'text',
                'align' => 'center',
                'search' => false,
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ),
            'sort_order' => array(
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle'
            ),
            
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_sub';
        $helper->table = 'bonmegamenu_sub_label';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->l('Icons and Labels');
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&addsub_label_' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules')
                . '&id_shop=' . (int)$this->context->shop->id
                . '&id_tab=' .Tools::getValue('id_tab'),
            'desc' => $this->l('Add new item')
        );
        $helper->toolbar_btn['back'] = array(
            'href' => AdminController::$currentIndex.'&configure='.$this->name .
                '&token='.Tools::getAdminTokenLite('AdminModules') . '&id_shop=' . (int)$this->context->shop->id,
            'desc' => $this->l('Back to main page')
        );
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' .
            (int)$this->context->shop->id . '&id_tab=' .Tools::getValue('id_tab');

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateList($tabs, $fields_list);
    }
    protected function renderBonmegamenuSubcategoryLabelForm()
    {
        $menu = ClassBonmegamenuConstructor::makeMenu((int)Tools::getValue('id_tab'));
        $menu_items = $menu['children'];
  
        $this->selectedCategories($menu_items, true);
            
        // array_shift($this->category);

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_sub') ?
                        $this->l('Update subcategory labels and icons') :
                        $this->l('Add subcategory')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col'   => 2,
                        'type'  => 'text',
                        'name'  => 'id_tab',
                        'class' => 'hidden'
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title:'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_modules_categories',
                        'label' => $this->l('Select link:'),
                        'name' => 'id_category',
                        'options' => array(
                            'query' =>  $this->category,
                            'id' => 'id_option',
                            'name' => 'name'
                            )
                        ),
                    array(
                        'type' => 'switch',
                        'form_group_class' => 'bon_switch_icon',
                        'label' => $this->l('Add label'),
                        'name' => 'label_switch_icon',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Label name:'),
                        'name' => 'label_name',
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_category_icons_type',
                        'label' => $this->l('Select label type'),
                        'name' => 'type_label',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => '1',
                                    'name' => $this->l('Type_1')
                                ),
                                array(
                                    'id' => '2',
                                    'name' => $this->l('Type_2')
                                ),
                            ),
                            'name' => 'name',
                            'id' => 'id',
                            'index' => 'type_icon'
                        ),
                        'col' => 2,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Label background color:'),
                        'name' => 'label_bg_color',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Label text color:'),
                        'name' => 'label_text_color',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Label text font size:'),
                        'name' => 'label_font_size',
                        'col' => 2,
                        'suffix' => 'px',
                    ),
                    array(
                        'type' => 'switch',
                        'form_group_class' => 'bon_switch_icon',
                        'label' => $this->l('Add icon'),
                        'name' => 'switch_icon',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_modules_icons_type',
                        'label' => $this->l('Select icon family'),
                        'name' => 'type_icon',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'outicons',
                                    'name' => $this->l('Outicons')
                                ),
                                array(
                                    'id' => 'material_icons',
                                    'name' => $this->l('Material Icons')
                                ),
                            ),
                            'name' => 'name',
                            'id' => 'id',
                            'index' => 'type_icon'
                        ),
                        'col' => 2,
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_modules_icons',
                        'label' => $this->l('Select an icon'),
                        'name' => 'icon',
                        'options' => array(
                            'query' => $this->getIcons(),
                            'id' => 'id_option',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Icon color:'),
                        'name' => 'icon_color',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Icon text font size:'),
                        'name' => 'icon_font_size',
                        'col' => 2,
                        'suffix' => 'px',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'type'  => 'submit',
                ),
                'buttons' => array(
                    array(
                        'href'  => AdminController::$currentIndex.'&configure='.$this->name.'&viewbonmegamenu&id_tab='.
                            Tools::getValue('id_tab').'&token='.Tools::getAdminTokenLite('AdminModules') .
                            '&id_shop='. (int)$this->context->shop->id,
                        'title' => $this->l('Cancel'),
                        'icon'  => 'process-icon-cancel'
                    ),
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name .
                            '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to main page'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonmegamenu_sub_label') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuSubcategoryLabel((int)Tools::getValue('id_sub'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_sub', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonmegamenuSubLabel';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonmegamenuSubcategoryLabelFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'link' => new Link(),
            'base_dir' => $this->ssl,
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonmegamenuSubcategoryLabelFormValues()
    {
        if ((bool)Tools::getIsset('updatebonmegamenu_sub_label') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonmegamenuSubcategoryLabel((int)Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBonmegamenuSubcategoryLabel();
        }
        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_sub' => Tools::getValue('id_sub'),
            'id_category' => Tools::getValue('id_category', $tab->id_category),
            'title' => Tools::getValue('title', $tab->title),
            'status' => Tools::getValue('status', $tab->status),
            'label_switch_icon' => Tools::getValue('label_switch_icon', $tab->label_switch_icon),
            'label_name' => Tools::getValue('label_name', $tab->label_name),
            'type_label' => Tools::getValue('type_label', $tab->type_label),
            'label_bg_color' => Tools::getValue('label_bg_color', $tab->label_bg_color),
            'label_font_size' => Tools::getValue('label_font_size', $tab->label_font_size),
            'icon_font_size' => Tools::getValue('icon_font_size', $tab->icon_font_size),
            'label_text_color' => Tools::getValue('label_text_color', $tab->label_text_color),
            'type_icon' => Tools::getValue('type_icon', $tab->type_icon),
            'icon' => Tools::getValue('icon', $tab->icon),
            'icon_color' => Tools::getValue('icon_color', $tab->icon_color),
            'switch_icon' => Tools::getValue('switch_icon', $tab->switch_icon),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        );
        
        return $fields_values;
    }

    protected function addBonmegamenuSubLabel()
    {
        $errors = array();

        if ((int)Tools::getValue('id_sub') > 0) {
            $item = new ClassBonmegamenuSubcategoryLabel((int)Tools::getValue('id_sub'));
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item = new ClassBonmegamenuSubcategoryLabel();
            $item->sort_order = $item->getMaxSortOrder((int)Tools::getValue('id_tab'));
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->id_tab = (int)Tools::getValue('id_tab');
        $item->status = (int)Tools::getValue('status');
        $item->label_switch_icon = Tools::getValue('label_switch_icon');
        $item->id_category = pSql(Tools::getValue('id_category'));
        $item->type_label = Tools::getValue('type_label');
        $item->label_bg_color = Tools::getValue('label_bg_color');
        $item->label_font_size = Tools::getValue('label_font_size');
        $item->icon_font_size = Tools::getValue('icon_font_size');
        $item->label_text_color = Tools::getValue('label_text_color');
        $item->switch_icon = Tools::getValue('switch_icon');
        $item->type_icon = Tools::getValue('type_icon');
        $item->icon = Tools::getValue('icon');
        $item->icon_color = Tools::getValue('icon_color');

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
            $item->label_name[$language['id_lang']] = Tools::getValue('label_name_' . $language['id_lang']);
        }

        if (!$errors) {
            if (!Tools::getValue('id_sub')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The subcategory is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateFormSubLabel()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonmegamenuSubcategoryLabel((int)Tools::getValue('id_sub'));

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of item is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of item format.');
        }

        if (!Validate::isColor(Tools::getValue('label_bg_color'))
        || !Validate::isColor(Tools::getValue('label_text_color'))
        || !Validate::isColor(Tools::getValue('icon_color'))) {
            $errors[] = $this->l('Color format error.');
        }

        if (!Validate::isUnsignedInt(Tools::getValue('icon_font_size'))
        || !Validate::isUnsignedInt(Tools::getValue('label_font_size'))) {
            $errors[] = $this->l('Bad number format');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonmegamenuSubLabel()
    {
        $tab = new ClassBonmegamenuSubcategoryLabel(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the subcategory'));
        }

        return $this->displayConfirmation($this->l('The subcategory is successfully deleted'));
    }
    
    protected function updateStatusSubcategoryLabel()
    {
        $tab = new ClassBonmegamenuSubcategoryLabel(Tools::getValue('id_sub'));

        if ($tab->status == 1) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The subcategory status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The subcategory status is successfully updated.'));
    }

    public function getIcons()
    {
        $icons = array(
            array('id_option' => 'material-icons phone', 'name' => '&#xe0cd;', ),
            array('id_option' => 'material-icons store', 'name' => '&#xe8d1;'),
            array('id_option' => 'material-icons headset_mic', 'name' => '&#xe311;'),
            array('id_option' => 'people material-icons', 'name' => '&#xe7fb;'),
            array('id_option' => 'material-icons access_alarms', 'name' => '&#xe191;'),
            array('id_option' => 'material-icons account_circle', 'name' => '&#xe853;'),
            array('id_option' => 'material-icons build', 'name' => '&#xe869;'),
            array('id_option' => 'material-icons brush', 'name' => '&#xe3ae;'),
            array('id_option' => 'material-icons camera_alt', 'name' => '&#xe3b0;'),
            array('id_option' => 'material-icons card_giftcard', 'name' => '&#xe8f6;'),
            array('id_option' => 'material-icons chat', 'name' => '&#xe0b7;'),
            array('id_option' => 'material-icons chat_bubble', 'name' => '&#xe0ca;'),
            array('id_option' => 'material-icons chat_bubble_outline', 'name' => '&#xe0cb;'),
            array('id_option' => 'material-icons chevron_left', 'name' => '&#xe5cb;'),
            array('id_option' => 'material-icons chevron_right', 'name' => '&#xe5cc;'),
            array('id_option' => 'material-icons collections', 'name' => '&#xe3b6;'),
            array('id_option' => 'material-icons contacts', 'name' => '&#xe0ba;'),
            array('id_option' => 'material-icons quick_contacts_dialer', 'name' => '&#xe0cf;'),
            array('id_option' => 'material-icons color_lens', 'name' => '&#xe3b7;'),
            array('id_option' => 'material-icons computer', 'name' => '&#xe30a;'),
            array('id_option' => 'material-icons create', 'name' => '&#xe150;'),
            array('id_option' => 'material-icons crop_original', 'name' => '&#xe3c4;'),
            array('id_option' => 'material-icons desktop_mac', 'name' => '&#xe30b;'),
            array('id_option' => 'material-icons email', 'name' => '&#xe0be;'),
            array('id_option' => 'material-icons expand_less', 'name' => '&#xe5ce;'),
            array('id_option' => 'material-icons expand_more', 'name' => '&#xe5cf;'),
            array('id_option' => 'material-icons favorite', 'name' => '&#xe87e;'),
            array('id_option' => 'material-icons file_download', 'name' => '&#xe2c4;'),
            array('id_option' => 'material-icons forum', 'name' => '&#xe0bf;'),
            array('id_option' => 'material-icons help', 'name' => '&#xe887;'),
            array('id_option' => 'material-icons help_outline', 'name' => '&#xe8fd;'),
            array('id_option' => 'material-icons insert_comment', 'name' => '&#xe24c;'),
            array('id_option' => 'material-icons insert_invitation', 'name' => '&#xe24f;'),
            array('id_option' => 'material-icons insert_link', 'name' => '&#xe250;'),
            array('id_option' => 'material-icons insert_photo', 'name' => '&#xe251;'),
            array('id_option' => 'material-icons local_offer', 'name' => '&#xe54e;'),
            array('id_option' => 'material-icons location_on', 'name' => '&#xe0c8;'),
            array('id_option' => 'material-icons phone_android', 'name' => '&#xe324;'),
            array('id_option' => 'material-icons settings', 'name' => '&#xe8b8;'),
            array('id_option' => 'fl-outicons fl-outicons-headphones46', 'name' => '&#57383;'),
            array('id_option' => 'fl-outicons fl-outicons-house204', 'name' => '&#xE029;'),
            array('id_option' => 'fl-outicons fl-outicons-book270', 'name' => '&#xE007;'),
            array('id_option' => 'fl-outicons fl-outicons-chevron1', 'name' => '&#57357;'),
            array('id_option' => 'fl-outicons fl-outicons-chevron3', 'name' => '&#57359;'),
            array('id_option' => 'fl-outicons fl-outicons-chevron', 'name' => '&#57360;'),
            array('id_option' => 'fl-outicons fl-outicons-chevron2', 'name' => '&#57358;'),
            array('id_option' => 'fl-outicons fl-outicons-building106', 'name' => '&#57353;'),
            array('id_option' => 'fl-outicons fl-outicons-news', 'name' => '&#57401;'),
            array('id_option' => 'fl-outicons fl-outicons-question5', 'name' => '&#57415;'),
            array('id_option' => 'fl-outicons fl-outicons-sales2', 'name' => '&#57419;'),
            array('id_option' => 'fl-outicons fl-outicons-magnifying glass34', 'name' => '&#57394;'),
            array('id_option' => 'fl-outicons fl-outicons-phone14', 'name' => '&#57407;'),
            array('id_option' => 'fl-outicons fl-outicons-photo-camera5', 'name' => '&#57408;'),
            array('id_option' => 'fl-outicons fl-outicons-picture54', 'name' => '&#57409;'),
            array('id_option' => 'fl-outicons fl-outicons-pin12', 'name' => '&#57410;'),
            array('id_option' => 'fl-outicons fl-outicons-play127', 'name' => '&#57411;'),
            array('id_option' => 'fl-outicons fl-outicons-speech bubble34', 'name' => '&#57428;'),
            array('id_option' => 'fl-outicons fl-outicons-speech-balloon2', 'name' => '&#57427;'),
            array('id_option' => 'fl-outicons fl-outicons-truck72', 'name' => '&#57436;'),
            array('id_option' => 'fl-outicons fl-outicons-user189', 'name' => '&#57440;'),
            array('id_option' => 'fl-outicons fl-outicons-treasure', 'name' => '&#57435;'),
            array('id_option' => 'fl-outicons fl-outicons-print', 'name' => '&#57414;'),
            array('id_option' => 'fl-outicons fl-outicons-share53', 'name' => '&#57421;'),
            array('id_option' => 'fl-outicons fl-outicons-pencil9', 'name' => '&#57406;'),
            array('id_option' => 'fl-outicons fl-outicons-heart373', 'name' => '&#57384;'),
            array('id_option' => 'fl-outicons fl-outicons-download194', 'name' => '&#57369;'),
            array('id_option' => 'fl-outicons fl-outicons-gear40', 'name' => '&#57380;'),
            array('id_option' => 'fl-outicons fl-outicons-mail2', 'name' => '&#57396;'),

        );

        return $icons;
    }

    protected function getConfigGoogleFont()
    {
        $google_font = array(
            array(
                'id' => 'default',
                'name' => $this->l('Theme font family')),
            array(
                'id' => 'Roboto',
                'name' => $this->l('Roboto')),
            array(
                'id' => 'Poppins',
                'name' => $this->l('Poppins')),
            array(
                'id' => 'Open+Sans',
                'name' => $this->l('Open Sans')),
            array(
                'id' => 'Vollkorn',
                'name' => $this->l('Vollkorn')),
            array(
                'id' => 'Tangerine',
                'name' => $this->l('Tangerine')),
            array(
                'id' => 'Risque',
                'name' => $this->l('Risque')),
            array(
                'id' => 'Lato',
                'name' => $this->l('Lato')),
            array(
                'id' => 'Oswald',
                'name' => $this->l('Oswald')),
            array(
                'id' => 'Lora',
                'name' => $this->l('Lora')),
            array(
                'id' => 'Ubuntu',
                'name' => $this->l('Ubuntu')),
            array(
                'id' => 'Playfair+Display',
                'name' => $this->l('Playfair Display')),
            array(
                'id' => 'Barlow',
                'name' => $this->l('Barlow')),
            array(
                'id' => 'Cabin',
                'name' => $this->l('Cabin')),
            array(
                'id' => 'Anton',
                'name' => $this->l('Anton')),
            array(
                'id' => 'Oxygen',
                'name' => $this->l('Oxygen')),
            array(
                'id' => 'Lobster',
                'name' => $this->l('Lobster')),
            array(
                'id' => 'Caveat',
                'name' => $this->l('Caveat')),
        );

        return  $google_font;
    }

    protected function getImageTypesByForm()
    {
        $options = array();
        $image_types = $this->getImageTypes();
        foreach ($image_types as $image_type) {
            $options[] = array('id' => $image_type, 'name' => $image_type);
        }
        return $options;
    }

    public function getImageTypes()
    {
        $res = array();

        $types = Db::getInstance()->ExecuteS('SELECT `name` FROM '._DB_PREFIX_.'image_type WHERE manufacturers = 1');
        if (!$types) {
            return false;
        }
        foreach ($types as $type) {
            $res[] = $type['name'];
        }

        return $res;
    }

    /* end labels and icons form and list */

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonmegamenu'));
        Media::addJsDefL('file_theme_url', $this->_path);
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonmegamenu'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . 'views/js/bonmegamenu_back.js');
        $this->context->controller->addCSS($this->_path . 'views/css/bonmegamenu_back.css');
        $this->context->controller->addCSS($this->_path.'views/css/fl-outicons.css');
    }

    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path . 'views/js/bonmegamenu_front.js');
        $this->context->controller->addCSS($this->_path . 'views/css/bonmegamenu_front.min.css');
        $this->context->controller->addCSS($this->_path.'views/css/fl-outicons.css', 'all');
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        $tabs = ClassBonmegamenu::getBonmegamenuCategoryList();
        $menus = [];
        
        $page_identifier = ClassBonmegamenuConstructor::getCurrentPageIdentifier();
        
        foreach ($tabs as $key => $tab) {
            $menu_json = ClassBonmegamenuConstructor::cacheFileRewrite($tab['id_tab'], self::MENU_JSON_CACHE_KEY);
            $menus[$key]['item'] = ClassBonmegamenuConstructor::mapTree(function (array $node) use ($page_identifier) {
                $node['current'] = ($page_identifier === $node['page_identifier']);
                return $node;
            }, $menu_json);

            // styles
            $menus[$key]['settings'] = $tab;

            // social links
            $menus[$key]['social_links']['facebook'] = $tab['social_facebook'];
            $menus[$key]['social_links']['instagram'] = $tab['social_instagram'];
            $menus[$key]['social_links']['youtube'] = $tab['social_youtube'];
            $menus[$key]['social_links']['twitter'] = $tab['social_twitter'];

            // banners
            $menus[$key]['subitems_banner'] = ClassBonmegamenuSubcategory::getTopFrontItems((int)$tab['id_tab']);

            // view
            $menus[$key]['subitems_view'] = ClassBonmegamenuSubcategoryView::getTopFrontItems((int)$tab['id_tab']);

            // labels
            $menus[$key]['subitems_labels'] = ClassBonmegamenuSubcategoryLabel::getTopFrontItems((int)$tab['id_tab']);

            // products
            $menus[$key]['subitems_products'] = [];
            $product_items = ClassBonmegamenuSubcategoryProduct::getTopFrontItems((int)$tab['id_tab']);
            if (is_array($product_items)) {
                foreach ($product_items as $key_prod => $item) {
                    $product = (new ProductAssembler($this->context))->assembleProduct(array('id_product' => $item['id_product']));
                    $presenterFactory = new ProductPresenterFactory($this->context);
                    $presentationSettings = $presenterFactory->getPresentationSettings();
                    $presenter = new ProductListingPresenter(new ImageRetriever($this->context->link), $this->context->link, new PriceFormatter(), new ProductColorsRetriever(), $this->context->getTranslator());
                    $menus[$key]['subitems_products'][$key_prod]['info'] = $presenter->present($presentationSettings, $product, $this->context->language);
                    $menus[$key]['subitems_products'][$key_prod]['id_category'] = $item['id_category'];
                    $menus[$key]['subitems_products'][$key_prod]['product_width'] = $item['product_width'];
                }
            }
        }
        return $menus;
    }

    public function renderWidget($hookName, array $configuration)
    {
        $http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";

        $this->smarty->assign([
            'menus' => $this->getWidgetVariables($hookName, $configuration),
            'hookName' => $hookName,
            'image_baseurl'=> $this->_path . 'views/img/',
            'id_language' => $this->context->language->id,
            'http' => $http,
        ]);

        return $this->fetch('module:/bonmegamenu/views/templates/hook/bonmegamenu.tpl');
    }
}
