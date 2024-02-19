<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Trends
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

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once(_PS_MODULE_DIR_.'productpurchase/classes/ClassProductPurchase.php');

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class Productpurchase extends Module
{
    public function __construct()
    {
        $this->name = 'productpurchase';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '5844c069bbb049343411eea072050db2';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Latest purchase');
        $this->description = $this->l('Display latest purchase products.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        if (Configuration::get('PS_SSL_ENABLED')) {
            $this->ssl = 'https://';
        } else {
            $this->ssl = 'http://';
        }
        $this->id_shop = Context::getContext()->shop->id;
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'productpurchase';
            }
        }
        $tab->class_name = 'AdminAjaxProductPurchase';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxProductPurchase')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');

        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
        $this->registerHook('displayHeader') &&
        $this->createAjaxController() &&
        $this->registerHook('displayBackOfficeHeader') &&
        $this->registerHook('displayProductPurchaseBlock') &&
        $this->registerHook('displayBeforeBodyClosingTag');
    }

    protected function getModuleSettings()
    {
        $settings = array(
            'PURCHASE_TIME_SHOW' => 7000,
            'PURCHASE_TIME_ACTIVE' => 15000,
        );
        return $settings;
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall()
        && $this->removeAjaxContoller();
    }

    public function getContent()
    {
        $output = '';
        $result = '';

        if (((bool)Tools::isSubmit('submitBonPurchaseSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool)Tools::isSubmit('submitUpdate')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addTab();
            } else {
                $output = $result;
                $output .= $this->renderTabForm();
            }
        }

        if ((bool)Tools::isSubmit('statusproductpurchase')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deleteproductpurchase')) {
            $output .= $this->deleteTab();
        }

        if (Tools::getIsset('updateproductpurchase') || Tools::getValue('updateproductpurchase')) {
            $output .= $this->renderTabForm();
        } elseif ((bool)Tools::isSubmit('addproductpurchase')) {
            $output .= $this->renderTabForm();
        } elseif (!$result) {
            $output .= $this->renderTabList();
            $output .= $this->renderFormSettings();
        }

        return $output;
    }

    protected function renderFormSettings()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBonPurchaseSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValuesSettings(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }


    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'text',
                        'label' => $this->l('Show item:'),
                        'name' => 'PURCHASE_TIME_SHOW',
                        'col' => 2,
                        'required' => true,
                        'suffix' => 'milliseconds',
                    ),
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'text',
                        'label' => $this->l('Animation speed:'),
                        'name' => 'PURCHASE_TIME_ACTIVE',
                        'col' => 2,
                        'required' => true,
                        'suffix' => 'milliseconds',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    protected function validateSettings()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('PURCHASE_TIME_ACTIVE'))) {
            $errors[] = $this->l('Animation speed is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('PURCHASE_TIME_ACTIVE'))) {
                $errors[] = $this->l('Bad animation speed format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('PURCHASE_TIME_SHOW'))) {
            $errors[] = $this->l('Duration of item display is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('PURCHASE_TIME_SHOW'))) {
                $errors[] = $this->l('Bad duration format');
            }
        }

        if ($errors) {
            return $this->displayError(implode('<br />', $errors));
        } else {
            return false;
        }
    }

    protected function getConfigFormValuesSettings()
    {
        $filled_settings = array();
        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            $filled_settings[$name] = Configuration::get($name);
        }

        return $filled_settings;
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

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getProductpurchaseSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    protected function renderTabForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update tab') : $this->l('Add tab')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'form_group_class' => 'display-block-product',
                        'type' => 'select_product',
                        'label' => $this->l('Select a product:'),
                        'class' => 'id_product',
                        'name' => 'id_product',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Buyer and place of purchase'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'datetime',
                        'label' => $this->l('Start Date'),
                        'name' => 'data_start',
                        'col' => 6,
                        'required' => true
                    ),
                    array(
                        'type' => 'datetime',
                        'label' => $this->l('End Date'),
                        'name' => 'data_end',
                        'col' => 6,
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Time of purchase'),
                        'name' => 'time',
                        'lang' => true,
                        'required' => true,
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

        if ((bool)Tools::getIsset('updateproductpurchase') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassProductPurchase((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdate';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'image_baseurl' => $this->_path.'images/',
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
        );
        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigFormValues()
    {
        if ((bool)Tools::getIsset('updateproductpurchase') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassProductPurchase((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassProductPurchase();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_product' => $tab->id_product,
            'product_name' => ClassProductPurchase::getProductName($tab->id_product),
            'link_rewrite' => ClassProductPurchase::getProductLinkRewrite($tab->id_product),
            'title' => Tools::getValue('title', $tab->title),
            'time' => Tools::getValue('time', $tab->time),
            'data_start' => Tools::getValue('data_start', $tab->data_start),
            'data_end' => Tools::getValue('data_end', $tab->data_end),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        );

        return $fields_values;
    }

    public function renderTabList()
    {
        if (!$tabs = ClassProductPurchase::getProductPurchaseList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id tab'),
                'type'  => 'id_tab',
                'align' => 'center',
                'search' => false,
            ),
            'id_product' => array(
                'title' => $this->l('Id product'),
                'type'  => 'id_product',
                'align' => 'center',
                'search' => false,
            ),
            'title' => array(
                'title' => $this->l('Name'),
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
            'data_start' => array(
                'title' => $this->l('Start Data'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'data_end' => array(
                'title' => $this->l('End Data'),
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
            )
        );

        $helper = new HelperList();

        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_tab';
        $helper->table = 'productpurchase';
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
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'images/',
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addTab()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassProductPurchase((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassProductPurchase();
        }

        $tab->id_shop = (int)$this->context->shop->id;
        $tab->status = (int)Tools::getValue('status');
        $tab->id_product = (int)Tools::getValue('id_product');
        $tab->data_start = Tools::getValue('data_start');
        $tab->data_end = Tools::getValue('data_end');


        if ((int)Tools::getValue('id_tab') > 0) {
            $tab->sort_order = (int)Tools::getValue('sort_order');
        } else {
            $tab->sort_order = $tab->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);
        foreach ($languages as $language) {
            $tab->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $tab->time[$language['id_lang']] = Tools::getValue('time_'.$language['id_lang']);
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$tab->add()) {
                    return $this->displayError($this->l('The tab could not be added.'));
                }
            } elseif (!$tab->update()) {
                return $this->displayError($this->l('The tab could not be updated.'));
            }
            return $this->displayConfirmation($this->l('The tab is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();
        $from = Tools::getValue('data_start');
        $to = Tools::getValue('data_end');
        
        if (Tools::isEmpty(Tools::getValue('data_start'))) {
            $errors[] = $this->l('The data start is required.');
        }

        if (Tools::isEmpty(Tools::getValue('data_end'))) {
            $errors[] = $this->l('The data end is required.');
        }

        if (!Validate::isDate($to) || !Validate::isDate($from)) {
            $errors[] = $this->l('Invalid date field');
        } elseif (strtotime($to) <= strtotime($from)) {
            $errors[] = $this->l('Invalid date range');
        }

        if (Tools::isEmpty(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Buyer and place of purchase is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad buyer and place of purchase format.');
        }

        if (Tools::isEmpty(Tools::getValue('time_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Time of purchase is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('time_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad time format.');
        }

        if (Tools::isEmpty(Tools::getValue('id_product'))) {
            $errors[] = $this->l('The product is required.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function deleteTab()
    {
        $tab = new ClassProductPurchase(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassProductPurchase(Tools::getValue('id_tab'));

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

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxProductLabel'));
        Media::addJsDefL('file_theme_url', $this->_path);
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxProductPurchase'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxProductPurchase'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/product_purchase_admin.js');
        $this->context->controller->addCSS($this->_path.'views/css/product_purchase_admin.css');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/product_purchase.css');
        $this->context->controller->addJS($this->_path.'views/js/product_purchase.js');
        $this->context->smarty->assign('settings', $this->getProductpurchaseSettings());

        return $this->display($this->_path, '/views/templates/hook/product_purchase_header.tpl');
    }

    public function hookDisplayBeforeBodyClosingTag()
    {
        $tabs = ClassProductPurchase::getFrontItems();
        $result = array();

        if (_PS_VERSION_ < 1.7) {
            if (is_array($tabs)) {
                foreach ($tabs as $product) {
                    $result[] = new Product((int)$product['id_product'], true, $this->context->language->id, $this->id_shop);
                }
            }

            $this->smarty->assign(array(
                'purchase_products_id_language' => $this->context->language->id,
            ));

            $this->context->smarty->assign(array(
                'purchase_products' => $result
            ));

            return $this->display(__FILE__, 'views/templates/hook/product_purchase.tpl');
        } else {
            if (is_array($tabs)) {
                foreach ($tabs as $key => $tab) {
                    $image = new Image();
                    $product = (new ProductAssembler($this->context))->assembleProduct(array('id_product' => $tab['id_product']));
                    $presenterFactory = new ProductPresenterFactory($this->context);
                    $presentationSettings = $presenterFactory->getPresentationSettings();
                    $presenter = new ProductListingPresenter(new ImageRetriever($this->context->link), $this->context->link, new PriceFormatter(), new ProductColorsRetriever(), $this->context->getTranslator());
                    $result[$key]['info'] = $presenter->present($presentationSettings, $product, $this->context->language);
                    $result[$key]['image'] = $image->getCover($tab['id_product']);
                    $result[$key]['title'] = $tab['title'];
                    $result[$key]['time'] = $tab['time'];
                }
            }

            $this->smarty->assign(array(
                'purchase_products_id_language' => $this->context->language->id,
            ));

            $this->context->smarty->assign(array(
                'purchase_products' => $result
            ));

            return $this->display(__FILE__, 'views/templates/hook/product_purchase_1_7.tpl');
        }
    }

    public function hookdisplayProductPurchaseBlock()
    {
        return $this->hookDisplayBeforeBodyClosingTag();
    }
}
