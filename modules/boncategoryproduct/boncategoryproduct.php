<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Category Products with Tabs and Carousel on Home Page
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

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once(_PS_MODULE_DIR_.'boncategoryproduct/classes/ClassBoncategoryproduct.php');

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class Boncategoryproduct extends Module
{
    private $category = array();

    public function __construct()
    {
        $this->name = 'boncategoryproduct';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '9e53dd4f1a80b1ce8d5e60161eac4d6c';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Category Products with Tabs and Carousel on Home Page');
        $this->description = $this->l('Display category products on home page.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        if (Configuration::get('PS_SSL_ENABLED')) {
            $this->ssl = 'https://';
        } else {
            $this->ssl = 'http://';
        }
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'PRODUCT_CATEGORY_DESCRIPTION_STATUS' => true,
            'PRODUCT_CATEGORY_DISPLAY_CAROUCEL' => true,
            'PRODUCT_CATEGORY_CAROUSEL_DRAG' => true,
            'PRODUCT_CATEGORY_CAROUCEL_LOOP' => true,
            'PRODUCT_CATEGORY_CAROUSEL_AUTOPLAY' => false,
            'PRODUCT_CATEGORY_CAROUSEL_TIME' => 5000,
        );

        return $configurations;
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'boncategoryproduct';
            }
        }
        $tab->class_name = 'AdminAjaxBoncategoryproduct';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxBoncategoryproduct')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        $this->installSamples();
        $configurations = $this->getConfigurations();

        foreach ($configurations as $name => $config) {
            Configuration::updateValue($name, $config);
        }

        return parent::install() &&
            $this->registerHook('header') &&
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayHome') &&
            $this->registerHook('displayCustomBoncategoryproduct') &&
            $this->registerHook('actionCategoryDelete');
    }
    
    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 2; ++$i) {
            $item = new ClassBoncategoryproduct();
            $item->id_shop = (int)$this->context->shop->id;
            if ($i==1) {
                $item->id_category = 3;
            } else {
                $item->id_category = 4;
            }
            $item->custom_banner = true;
            $item->status = 1;
            $item->enable_all_banners = 1;
            $item->sort_order = $i;
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'Top rated products';
            }

            $item->add();
        }
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
        $configurations = $this->getConfigurations();

        foreach (array_keys($configurations) as $config) {
            Configuration::deleteByName($config);
        }

        return parent::uninstall()
            && $this->removeAjaxContoller();
    }

    public function getContent()
    {
        $output = '';
        $result ='';

        if ((bool)Tools::isSubmit('submitConfiguration')) {
            if (!$errors = $this->preValidateSetting()) {
                $output .= $this->postProcess();
                $this->clearCache();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output = $errors;
            }
        }

        if (((bool)Tools::isSubmit('submitCategory'))) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addCategory();
            } else {
                $output = $result;
                $output .= $this->renderForm();
            }
        }

        if ((bool)Tools::isSubmit('statusboncategoryproduct')) {
            $output .= $this->updateStatusTab('status');
        }

        if ((bool)Tools::isSubmit('deleteboncategoryproduct')) {
            $output .= $this->deleteCategory();
        }

        if (Tools::getIsset('updateboncategoryproduct') || Tools::getValue('updateboncategoryproduct')) {
            $output .= $this->renderForm();
        } elseif ((bool)Tools::isSubmit('addboncategoryproduct')) {
            $output .= $this->renderForm();
        } elseif (!$result) {
            $output .= $this->renderCategoriesList();
            $output .= $this->renderTabForm();
        }

        return $output;
    }

    /** ADD CATEGORY*/
    public function renderCategoriesList()
    {
        if (!$tabs = ClassBoncategoryproduct::getCategoryList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_item' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'name' => array(
                'title' => $this->l('Category'),
                'type' => 'text',
                'col' => 6,
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
            )
        );

        $helper = new HelperList();

        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_item';
        $helper->table = 'boncategoryproduct';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                .'&configure='.$this->name.'&add'.$this->name
                .'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new item')
        );
        $helper->currentIndex = AdminController::$currentIndex
            .'&configure='.$this->name.'&id_shop='.(int)$this->context->shop->id;

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'id_lang' => $this->context->language->id,
        );
        return $helper->generateList($tabs, $fields_list);
    }

    protected function renderForm()
    {
        $this->getCategoriesList();

        array_shift($this->category);

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_item')
                        ? $this->l('Update item')
                        : $this->l('Add item')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select category'),
                        'name' => 'id_category',
                        'options' => array(
                            'query' => $this->category,
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden'
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
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    array(
                        'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updateboncategoryproduct') && (int)Tools::getValue('id_item') > 0) {
            $item = new ClassBoncategoryproduct((int)Tools::getValue('id_item'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_item', 'value' => (int)$item->id);
        }

        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCategory';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'views/img/',
        );

        return $helper->generateForm(array($fields_form));
    }

    private function getCategoriesList()
    {
        $category = new Category();
        $this->getItemCategories($category->getNestedCategories((int)Configuration::get('PS_ROOT_CATEGORY')));
    }

    protected function getItemCategories($categories)
    {
        foreach ($categories as $category) {
            array_push(
                $this->category,
                array(
                    'id' => (int)$category['id_category'],
                    'name' => str_repeat('&nbsp;', '3' * (int)$category['level_depth']).$category['name']
                )
            );

            if (isset($category['children']) && !empty($category['children'])) {
                $this->getItemCategories($category['children']);
            }
        }
    }

    protected function getConfigFormValues()
    {
        if ((bool)Tools::getIsset('updateboncategoryproduct') && (int)Tools::getValue('id_item') > 0) {
            $item = new ClassBoncategoryproduct((int)Tools::getValue('id_item'));
            $fields_values = array(
                'id_item' => Tools::getValue('id_item'),
                'title' => Tools::getValue('title', $item->title),
                'id_category' => Tools::getValue('id_category', $item->id_category),
                'sort_order' => Tools::getValue('sort_order', $item->sort_order),
                'status' => Tools::getValue('status', $item->status),
            );
        } else {
            $item = new ClassBoncategoryproduct();
            $fields_values = array(
                'id_item' => '',
                'id_category' => '',
                'sort_order' => '',
                'title' => 'title',
                'status' => '',
            );
        }

        return $fields_values;
    }

    protected function addCategory()
    {
        if ((int)Tools::getValue('id_item') > 0) {
            $item = new ClassBoncategoryproduct((int)Tools::getValue('id_item'));
        } else {
            $item = new ClassBoncategoryproduct();
        }

        $item->id_category = (int)Tools::getValue('id_category');
        $item->id_shop = (int)$this->context->shop->id;

        if ((int)Tools::getValue('id_item') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int)$this->id_shop);
        }

        $item->status = (bool)Tools::getValue('status');
        $item->enable_all_banners = (bool)Tools::getValue('enable_all_banners');
        $item->custom_banner = (bool)Tools::getValue('custom_banner');

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            if (Tools::isEmpty(Tools::getValue('title_'.$language['id_lang']))) {
                $item->title[$language['id_lang']] = Tools::getValue('title_'.$this->context->language->id);
            }
        }

        if (!Tools::getValue('id_item')) {
            if (!$item->add()) {
                return $this->displayError($this->l('The item could not be added.'));
            }
        } elseif (!$item->update()) {
            return $this->displayError($this->l('The item could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The item is saved.'));
    }


    protected function deleteCategory()
    {
        $item = new ClassBoncategoryproduct(Tools::getValue('id_item'));
        $res = $item->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab($type)
    {
        $item = new ClassBoncategoryproduct(Tools::getValue('id_item'));

        if ($item->$type == 1) {
            $item->$type = 0;
        } else {
            $item->$type = 1;
        }

        if (!$item->update()) {
            return $this->displayError($this->l('The tab status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The tab status is successfully updated.'));
    }



    /** CONFIGURATION MODULE*/


    protected function renderTabForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Caroucel:'),
                        'name' => 'PRODUCT_CATEGORY_DISPLAY_CAROUCEL',
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
                        'type' => 'switch',
                        'form_group_class' => 'display-block-carousel-content',
                        'label' => $this->l('Autoplay:'),
                        'name' => 'PRODUCT_CATEGORY_CAROUSEL_AUTOPLAY',
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
                        'type' => 'text',
                        'form_group_class' => 'display-block-carousel-content',
                        'label' => $this->l('Autoplay Speed:'),
                        'name' => 'PRODUCT_CATEGORY_CAROUSEL_TIME',
                        'col' => 2,
                        'required' => true,
                        'suffix' => 'milliseconds',
                    ),
                    array(
                        'type' => 'switch',
                        'form_group_class' => 'display-block-carousel-content',
                        'label' => $this->l('Mouse drag:'),
                        'name' => 'PRODUCT_CATEGORY_CAROUSEL_DRAG',
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
//                    array(
//                        'type' => 'switch',
//                        'form_group_class' => 'display-block-carousel-content',
//                        'label' => $this->l('Loop:'),
//                        'name' => 'PRODUCT_CATEGORY_CAROUCEL_LOOP',
//                        'desc' => $this->l('Infinity loop. Duplicate last and first items to get loop illusion.'),
//                        'values' => array(
//                            array(
//                                'id' => 'active_on',
//                                'value' => 1,
//                                'label' => $this->l('Enabled')
//                            ),
//                            array(
//                                'id' => 'active_off',
//                                'value' => 0,
//                                'label' => $this->l('Disabled')
//                            )
//                        ),
//                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitConfiguration';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        $fields = array();
        $configurations = $this->getConfigurations();

        foreach (array_keys($configurations) as $config) {
            $fields[$config] = Configuration::get($config);
        }

        return $fields;
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFieldsValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }


    protected function preValidateSetting()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('PRODUCT_CATEGORY_CAROUSEL_TIME'))) {
            $errors[] = $this->l('Animation speed is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('PRODUCT_CATEGORY_CAROUSEL_TIME'))) {
                $errors[] = $this->l('Bad animation speed format');
            }
        }

        if ($errors) {
            return $this->displayError(implode('<br />', $errors));
        } else {
            return false;
        }
    }


    protected function preValidateForm()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBoncategoryproduct'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBoncategoryproduct'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/boncategoryproduct-back.js');
        $this->context->controller->addCSS($this->_path.'views/css/boncategoryproduct-back.css');
    }

    protected function getType($data)
    {
        if (Validate::isInt($data)) {
            return 'int';
        } elseif (Validate::isFloat($data)) {
            return 'float';
        } elseif (Validate::isBool($data)) {
            return 'bool';
        } else {
            return 'string';
        }
    }

    protected function getBlankSettings()
    {
        $settings = $this->getConfigurations();
        $result = array();

        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $result[$name] = array('value' => $data, 'type' => $this->getType($data));
        }

        return $result;
    }

    protected function clearCache()
    {
        $this->_clearCache('boncategoryproduct-home.tpl');
        $this->_clearCache('boncategoryproduct-header.tpl');
    }

    public function hookActionCategoryDelete($params)
    {
        $data = ClassBoncategoryproduct::getDeletedCategory((int)$params['category']->id_category);

        if ($data) {
            foreach ($data as $item) {
                $this->deleteItem($item);
            }
        }
    }

    public function hookHeader()
    {
        if ($this->context->controller->php_self == "index") {
//            $this->context->controller->addJS($this->_path.'views/js/swiper-bundle.min.js');
//            $this->context->controller->addCSS($this->_path.'views/css/swiper-bundle.min.css', 'all');
            $this->context->controller->addCSS($this->_path.'views/css/boncategoryproduct-front.css', 'all');
            $this->context->controller->addJS($this->_path . '/views/js/boncategoryproduct.js');
            $this->context->smarty->assign('settings', $this->getBlankSettings());

            return $this->display($this->_path, '/views/templates/hook/boncategoryproduct-header.tpl');
        }
    }

    public function hookDisplayHome()
    {
      
        $data = array();
        $categories = ClassBoncategoryproduct::getFrontCategory();
        $result =  array();
        if ($categories) {
            foreach ($categories as $key => $category) {

                $data[$key]['category'] = new Category((int)$category['id_category'], $this->context->language->id);
               
                $products = Product::getProducts($this->context->language->id, 0, 0, 'id_product', 'ASC', (int)$category['id_category'], true);

                foreach ($products as $keyt => $tab) {
                    $image = new Image();
                    $product = (new ProductAssembler($this->context))->assembleProduct(array('id_product' => $tab['id_product']));
                    $presenterFactory = new ProductPresenterFactory($this->context);
                    $presentationSettings = $presenterFactory->getPresentationSettings();
                    $presenter = new ProductListingPresenter(new ImageRetriever($this->context->link), $this->context->link, new PriceFormatter(), new ProductColorsRetriever(), $this->context->getTranslator());
                    $result[$keyt]['image'] = $image->getCover($tab['id_product']);
                    $result[$keyt]['info'] = $presenter->present($presentationSettings, $product, $this->context->language);
                }

                $data[$key]['result'] =  $result;
                $data[$key]['title'] = $category['title'];
                $data[$key]['id_item'] = (int)$category['id_item'];
                $data[$key]['id_category'] = $category['id_category'];
            }
        }
       
        $this->context->smarty->assign(
            array(
                'categories' => $data,
                'image_baseurl' => $this->_path.'views/img/',
                'display_caroucel' => Configuration::get('PRODUCT_CATEGORY_DISPLAY_CAROUCEL'),
            )
        );
        
        return $this->display($this->_path, '/views/templates/hook/boncategoryproduct-home.tpl');
    }
    
    public function hookdisplayCustomBoncategoryproduct()
    {
        return $this->hookDisplayHome();
    }
}
