<?php
/**
 * 2015-2017 Bonpresta
 *
 * Bonpresta Brand Manager
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
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class BonBrand extends Module
{
    public function __construct()
    {
        $this->name = 'bonbrand';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->author = 'Bonpresta';
        $this->module_key = '5bd5df8bf567370424a7651cdf5cac83';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Brand Manager');
        $this->description = $this->l('Enable Brand Manager.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getModuleSettings()
    {
        $res = array(
            'BON_BRAND_DISPLAY_NAME' => false,
            'BON_BRAND_ORDER' => 0,
            'BON_BRAND_DISPLAY_IMAGE' => true,
            'BON_BRAND_DISPLAY_IMAGE_TYPE' => 'small_default',
            'BON_BRAND_DISPLAY_CAROUCEL' => false,
            'BON_BRAND_DISPLAY_ITEM_NB' => 6,
            'BON_BRAND_CAROUCEL_NB' => 4,
            'BON_BRAND_CAROUCEL_LOOP' => false,
            'BON_BRAND_CAROUCEL_NAV' => true,
            'BON_BRAND_CAROUCEL_DOTS' => false,
            'BON_BRAND_PRODUCT_DISPLAY' => true,
            'BON_BRAND_PRODUCT_NAME' => false,
            'BON_BRAND_PRODUCT_IMAGE' => true,
            'BON_BRAND_PRODUCT_TYPE' => 'small_default',
            'BON_BRAND_LIST_DISPLAY' => true,
            'BON_BRAND_LIST_NAME' => false,
            'BON_BRAND_LIST_IMAGE' => false,
            'BON_BRAND_LIST_TYPE' => 'small_default',
        );
        return $res;
    }

    public function install()
    {
        $settins = $this->getModuleSettings();
        foreach ($settins as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
        $this->registerHook('header') &&
        $this->registerHook('displayHome') &&
        $this->registerHook('displayProductPriceBlock') &&
        $this->registerHook('displayProductButtons');
    }

    public function uninstall()
    {
        $settins = $this->getModuleSettings();
        foreach (array_keys($settins) as $name) {
            Configuration::deleteByName($name);
        }
        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';

        if ((bool)Tools::isSubmit('submitSettingsByBrand')) {
            if (!$errors = $this->checkItemFields()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output .= $errors;
            }
        }

        return $output.$this->renderForm();
    }

    protected function getConfigMainForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Main Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Image Type:'),
                        'name' => 'BON_BRAND_DISPLAY_IMAGE_TYPE',
                        'desc' => $this->l('Select image type.'),
                        'options' => array(
                            'query' => $this->getImageTypesByForm(),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Order by:'),
                        'name' => 'BON_BRAND_ORDER',
                        'options' => array(
                            'query' => array(
                                array('id' => 0, 'name' => $this->l('manufacturer name')),
                                array('id' => 1, 'name' => $this->l('manufacturer id'))
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Name:'),
                        'name' => 'BON_BRAND_DISPLAY_NAME',
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
                        'label' => $this->l('Image:'),
                        'name' => 'BON_BRAND_DISPLAY_IMAGE',
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
                        'label' => $this->l('Items:'),
                        'name' => 'BON_BRAND_DISPLAY_ITEM_NB',
                        'class' => 'fixed-width-xs'
                    )
                )
            ),
        );
    }

    protected function getConfigCarouselForm()
    {
         return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings Carousel'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Caroucel:'),
                        'name' => 'BON_BRAND_DISPLAY_CAROUCEL',
                        'desc' => $this->l('Display brand in the carousel.'),
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
                        'label' => $this->l('Items:'),
                        'name' => 'BON_BRAND_CAROUCEL_NB',
                        'col' => 2,
                        'desc' => $this->l('The number of items you want to see on the screen.'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BON_BRAND_CAROUCEL_LOOP',
                        'desc' => $this->l('Infinity loop. Duplicate last and first items to get loop illusion.'),
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
                        'label' => $this->l('Nav:'),
                        'name' => 'BON_BRAND_CAROUCEL_NAV',
                        'desc' => $this->l('Show next/prev buttons.'),
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
                        'label' => $this->l('Dots:'),
                        'name' => 'BON_BRAND_CAROUCEL_DOTS',
                        'desc' => $this->l('Show dots navigation.'),
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
                )
            ),
        );
    }

    protected function getConfigProductForm()
    {
         return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings Product Page'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display:'),
                        'name' => 'BON_BRAND_PRODUCT_DISPLAY',
                        'desc' => $this->l('Display logo on product page.'),
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
                        'name' => 'BON_BRAND_PRODUCT_TYPE',
                        'desc' => $this->l('Select image type.'),
                        'options' => array(
                            'query' => $this->getImageTypesByForm(),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Name:'),
                        'name' => 'BON_BRAND_PRODUCT_NAME',
                        'desc' => $this->l('Display name on product page.'),
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
                        'label' => $this->l('Image:'),
                        'name' => 'BON_BRAND_PRODUCT_IMAGE',
                        'desc' => $this->l('Display image on product page.'),
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
                )
            ),
        );
    }

    protected function getConfigListForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings Listing'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display:'),
                        'name' => 'BON_BRAND_LIST_DISPLAY',
                        'desc' => $this->l('Display logo on list.'),
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
                        'name' => 'BON_BRAND_LIST_TYPE',
                        'desc' => $this->l('Select image type.'),
                        'options' => array(
                            'query' => $this->getImageTypesByForm(),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Name:'),
                        'name' => 'BON_BRAND_LIST_NAME',
                        'desc' => $this->l('Display name on list.'),
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
                        'label' => $this->l('Image:'),
                        'name' => 'BON_BRAND_LIST_IMAGE',
                        'desc' => $this->l('Display image on list.'),
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
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
    }

    public function renderForm()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitSettingsByBrand';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).
        '&configure='.$this->name.
        '&tab_module='.$this->tab.
        '&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($this->getConfigMainForm(), $this->getConfigCarouselForm(), $this->getConfigProductForm(), $this->getConfigListForm()));
    }


    protected function getConfigFieldsValues()
    {
        $filled_settings = array();
        $settings = $this->getModuleSettings();
        foreach (array_keys($settings) as $name) {
            $filled_settings[$name] = Configuration::get($name);
        }
        return $filled_settings;
    }

    /**
    * Update Configuration values
    */
    protected function postProcess()
    {
        $form_values = $this->getConfigFieldsValues();
        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
     * Display hook header
     */
    public function hookHeader()
    {
        if (Configuration::get('BON_BRAND_DISPLAY_CAROUCEL')) {
            $this->context->controller->addJS($this->_path.'views/js/bonbrand.js');
            $this->context->controller->addJS($this->_path.'views/js/slick.js');
            $this->context->controller->addCSS($this->_path.'views/css/slick.css', 'all');
            $this->context->controller->addCSS($this->_path.'views/css/slick-theme.css', 'all');
        }

        $this->context->controller->addCSS($this->_path.'views/css/bonbrand.css', 'all');
    }

     /**
     * Display home
     */
    public function hookDisplayHome()
    {
        $manufacturers = Manufacturer::getManufacturers();
        if (Configuration::get('BON_BRAND_ORDER')) {
            $manufacturers = $this->sortManufacturers($manufacturers);
        }
        foreach ($manufacturers as &$manufacturer) {
            $manufacturer['image'] = $this->context->language->iso_code.'-default';

            if (file_exists(_PS_MANU_IMG_DIR_.$manufacturer['id_manufacturer'].'-'.Configuration::get('BON_BRAND_DISPLAY_IMAGE_TYPE').'.jpg')) {
                $manufacturer['image'] = $manufacturer['id_manufacturer'];
            }
        }

        $this->smarty->assign(array(
            'bon_ps_version' => _PS_VERSION_,
            'manufacturers' => $manufacturers,
            'img_manu_dir' => _THEME_MANU_DIR_,
            'display_name' => Configuration::get('BON_BRAND_DISPLAY_NAME'),
            'order_by' => Configuration::get('BON_BRAND_ORDER'),
            'display_image' => Configuration::get('BON_BRAND_DISPLAY_IMAGE'),
            'image_type' => Configuration::get('BON_BRAND_DISPLAY_IMAGE_TYPE'),
            'display_caroucel' => Configuration::get('BON_BRAND_DISPLAY_CAROUCEL'),
            'nb_display' => Configuration::get('BON_BRAND_DISPLAY_ITEM_NB'),
            'caroucel_nb' => Configuration::get('BON_BRAND_CAROUCEL_NB'),
            'caroucel_loop' => Configuration::get('BON_BRAND_CAROUCEL_LOOP'),
            'caroucel_nav' => Configuration::get('BON_BRAND_CAROUCEL_NAV'),
            'caroucel_dots' => Configuration::get('BON_BRAND_CAROUCEL_DOTS'),
        ));

        return $this->display(__FILE__, 'bonbrand.tpl');
    }

    public function hookDisplayProductButtons()
    {

        $product = $this->context->controller->getProduct();
        $this->smarty->assign(array(
            'product' => $product,
            'img_manu_dir' => _THEME_MANU_DIR_,
            'bon_ps_version' => _PS_VERSION_,
            'bon_display_box' => Configuration::get('BON_BRAND_PRODUCT_DISPLAY'),
            'bon_display_name' => Configuration::get('BON_BRAND_PRODUCT_NAME'),
            'bon_display_image' => Configuration::get('BON_BRAND_PRODUCT_IMAGE'),
            'bon_display_type' => Configuration::get('BON_BRAND_PRODUCT_TYPE'),
        ));

        return $this->display(__FILE__, 'bonbrand-product.tpl');
    }

    public function hookdisplayProductPriceBlock($params)
    {

        $id_product = '';

        if ($params['type'] != 'weight') {
            return;
        }

        if (isset($params['product']->id) && $params['product']->id) {
            $id_product = $params['product']->id;
        } elseif (isset($params['product']['id_product']) && $params['product']['id_product']) {
            $id_product = $params['product']['id_product'];
        }

        $product = new Product($id_product, true, $this->context->shop->id);

        $this->smarty->assign(array(
            'module_page_name' => $this->context->controller->php_self,
            'img_manu_dir' => _THEME_MANU_DIR_,
            'bon_ps_version' => _PS_VERSION_,
            'products_list' => $product,
            'bon_list_box' => Configuration::get('BON_BRAND_LIST_DISPLAY'),
            'bon_list_name' => Configuration::get('BON_BRAND_LIST_NAME'),
            'bon_list_image' => Configuration::get('BON_BRAND_LIST_IMAGE'),
            'bon_list_type' => Configuration::get('BON_BRAND_LIST_TYPE'),
        ));

        return $this->display(__FILE__, 'bonbrand-list.tpl');
    }

    public function hookDisplayRightColumnProduct()
    {
        return $this->hookDisplayProductButtons();
    }

    public function hookDisplayTopColumn()
    {
        return $this->hookDisplayHome();
    }

    public function hookDisplayFooter()
    {
        return $this->hookDisplayHome();
    }

    protected function checkItemFields()
    {
        $errors = array();

        if ((!Validate::isInt(Tools::getValue('BON_BRAND_DISPLAY_ITEM_NB'))
            || Tools::getValue('BON_BRAND_DISPLAY_ITEM_NB') < 1)) {
            $errors[] = $this->l('"Items" value error. Only integer numbers are allowed.');
        }

        if (Tools::isEmpty(Tools::getValue('BON_BRAND_DISPLAY_ITEM_NB'))) {
            $errors[] = $this->l('"Items" value empty.');
        }

        if ((!Validate::isInt(Tools::getValue('BON_BRAND_CAROUCEL_NB'))
            || Tools::getValue('BON_BRAND_CAROUCEL_NB') < 1)) {
            $errors[] = $this->l('"Items" value error. Only integer numbers are allowed.');
        }

        if (Tools::isEmpty(Tools::getValue('BON_BRAND_CAROUCEL_NB'))) {
            $errors[] = $this->l('"Items" value empty.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
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

    protected function sortManufacturers($res)
    {
        $sorted = array();

        foreach ($res as $sort) {
            $sorted[$sort['id_manufacturer']] = $sort;
        }

        sort($sorted);

        while (list($k, $i) = each($sorted)) {
            $sorted[$k] = $i;
        }

        return $sorted;
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
}
