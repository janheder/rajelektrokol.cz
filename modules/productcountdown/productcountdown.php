<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Discounts with Countdown
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

include_once(_PS_MODULE_DIR_.'productcountdown/classes/ClassProductCountdown.php');

class Productcountdown extends Module
{
    public function __construct()
    {
        $this->name = 'productcountdown';
        $this->tab = 'front_office_features';
        $this->version = '1.0.2';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '73b295a3c47eff0e7b90131db04cc7c4';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Product Discounts with Countdown');
        $this->description = $this->l('Module add product discounts with countdown.');
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
                $tab->name[$language['id_lang']] = 'productcountdown';
            }
        }
        $tab->class_name = 'AdminAjaxProductCountdown';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxProductCountdown')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
        $this->registerHook('displayHeader') &&
        $this->createAjaxController() &&
        $this->registerHook('displayBackOfficeHeader') &&
        $this->registerHook('displayProductPriceBlock') &&
        $this->registerHook('displayBeforeBodyClosingTag') &&
        $this->registerHook('displayProductCountdownBlock');
    }


    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall()
        && $this->removeAjaxContoller();
    }

    public function getContent()
    {
        $output = '';
        $result = '';

        if ((bool)Tools::isSubmit('submitUpdate')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addTab();
            } else {
                $output = $result;
                $output .= $this->renderTabForm();
            }
        }

        if ((bool)Tools::isSubmit('statusproductcountdown')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deleteproductcountdown')) {
            $output .= $this->deleteTab();
        }

        if (Tools::getIsset('updateproductcountdown') || Tools::getValue('updateproductcountdown')) {
            $output .= $this->renderTabForm();
        } elseif ((bool)Tools::isSubmit('addproductcountdown')) {
            $output .= $this->renderTabForm();
        } elseif (!$result) {
            $output .= $this->renderTabList();
        }

        return $output;
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
                        'type' => 'select_product',
                        'label' => $this->l('Select a product:'),
                        'class' => 'id_product',
                        'name' => 'id_product',
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
                        'label' => $this->l('Discount price'),
                        'col' => 2,
                        'required' => true,
                        'name' => 'discount_price',
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'reduction_type',
                        'options' => array(
                            'id' => 'id_option',
                            'name' => 'name',
                            'query' => array(
                                array(
                                    'id_option' => 'amount',
                                    'name' => 'amount'
                                ),
                                array(
                                    'id_option' => 'percentage',
                                    'name' => '%'
                                ),
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'reduction_tax',
                        'options' => array(
                            'id' => 'id_option',
                            'name' => 'name',
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => 'Tax excluded'
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => 'Tax included'
                                ),
                            )
                        )
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

        if ((bool)Tools::getIsset('updateproductcountdown') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassProductCountdown((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_specific_price', 'value' => $tab->id_specific_price);
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
            'pr_img_dir' => _THEME_PROD_DIR_,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
        );
        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigFormValues()
    {
        if ((bool)Tools::getIsset('updateproductcountdown') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassProductCountdown((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassProductCountdown();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_product' => $tab->id_product,
            'product_name' => ClassProductCountdown::getProductName($tab->id_product),
            'link_rewrite' => ClassProductCountdown::getProductLinkRewrite($tab->id_product),
            'data_start' => Tools::getValue('data_start', $tab->data_start),
            'data_end' => Tools::getValue('data_end', $tab->data_end),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
            'id_specific_price' => Tools::getValue('id_specific_price', $tab->id_specific_price),
            'discount_price' => Tools::getValue('discount_price', $tab->discount_price),
            'reduction_type' => Tools::getValue('reduction_type', $tab->reduction_type),
            'reduction_tax' => Tools::getValue('reduction_tax', $tab->reduction_tax)
        );

        return $fields_values;
    }

    public function renderTabList()
    {
        if (!$tabs = ClassProductCountdown::getProductCountdownList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id tab'),
                'type'  => 'id_tab',
                'align' => 'center',
                'search' => false,
            ),
            'id_specific_price' => array(
                'title' => $this->l('Id specific price'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'block_image' => array(
                'title' => $this->l('Product image'),
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
            'discount_price' => array(
                'title' => $this->l('Discount price'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'reduction_type' => array(
                'title' => $this->l('Reduction type'),
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
        $helper->table = 'productcountdown';
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
            'pr_img_dir' => _THEME_PROD_DIR_,
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
            $tab = new ClassProductCountdown((int)Tools::getValue('id_tab'));
            $specificPrice = new SpecificPrice($tab->id_specific_price);
        } else {
            $tab = new ClassProductCountdown();
            $specificPrice = new SpecificPrice();
        }

        $tab->id_shop = (int)$this->context->shop->id;
        $tab->status = (int)Tools::getValue('status');
        $tab->id_product = (int)Tools::getValue('id_product');
        $tab->data_start = Tools::getValue('data_start');
        $tab->data_end = Tools::getValue('data_end');
        $tab->discount_price = Tools::getValue('discount_price');
        $tab->reduction_type = Tools::getValue('reduction_type');
        $tab->reduction_tax = Tools::getValue('reduction_tax');

        if ((int)Tools::getValue('id_tab') > 0) {
            $tab->sort_order = (int)Tools::getValue('sort_order');
        } else {
            $tab->sort_order = $tab->getMaxSortOrder((int)$this->id_shop);
        }

        $specificPrice->id_product = Tools::getValue('id_product');
        $specificPrice->id_shop = $this->context->shop->id;
        $specificPrice->id_currency = 0;
        $specificPrice->id_country = 0;
        $specificPrice->id_group = 0;
        $specificPrice->id_customer = 0;
        $specificPrice->from_quantity = 1;
        $specificPrice->price = -1;
        $specificPrice->reduction_type = Tools::getValue('reduction_type');

        if ($tab->reduction_type != 'amount') {
            $specificPrice->reduction = Tools::getValue('discount_price') / 100;
        } else {
            $specificPrice->reduction = Tools::getValue('discount_price');
        }

        $specificPrice->reduction_tax = Tools::getValue('reduction_tax');
        $specificPrice->from = Tools::getValue('data_start');
        $specificPrice->to = Tools::getValue('data_end');

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$specificPrice->add()) {
                    return $this->displayError($this->l('The specific price could not be added.'));
                } else {
                    $tab->id_specific_price = $specificPrice->id;
                }
            } else {
                if (!$specificPrice->update()) {
                    return $this->displayError($this->l('The specific price could not be updated.'));
                } else {
                    $tab->id_specific_price = Tools::getValue('id_specific_price');
                }
            }
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
        $discount_price = Tools::getValue('discount_price');

        if (!Validate::isPrice($discount_price)) {
            $errors[] = $this->l('Invalid price field');
        }

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
        $tab = new ClassProductCountdown(Tools::getValue('id_tab'));
        $specific_price = new SpecificPrice($tab->id_specific_price);

        $specific_price->delete();
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassProductCountdown(Tools::getValue('id_tab'));

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

        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxProductCountdown'));
        Media::addJsDefL('file_theme_url', $this->_path);
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxProductCountdown'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/productcountdown_admin.js');
        $this->context->controller->addCSS($this->_path.'views/css/productcountdown_admin.css');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/jquery.countdown.js');
        $this->context->controller->addJS($this->_path.'views/js/productcountdown.js');
        $this->context->controller->addCSS($this->_path.'views/css/productcountdown.css');
    }

    public function hookdisplayProductCountdownBlock($params)
    {
        $id_product = '';

        if (isset($params['product']->id) && $params['product']->id) {
            $id_product = $params['product']->id;
        } elseif (isset($params['product']['id_product']) && $params['product']['id_product']) {
            $id_product = $params['product']['id_product'];
        }

        $tabs = ClassProductCountdown::getFrontItems($id_product, $this->id_shop, true);
        
        $result = array();

        if ($tabs) {
            foreach ($tabs as $key => $tab) {
                $result[$key]['data_end'] = $tab['data_end'];
            }
        }

        $this->context->smarty->assign('items', $result);
        $this->context->smarty->assign('countdown_ps_version', _PS_VERSION_);

        return $this->display(__FILE__, 'views/templates/hook/productcountdown.tpl');
    }

    public function hookdisplayProductPriceBlock($params)
    {
        $id_product = '';

        if ($params['type'] != 'before_price') {
            return;
        }

        if (isset($params['product']->id) && $params['product']->id) {
            $id_product = $params['product']->id;
        } elseif (isset($params['product']['id_product']) && $params['product']['id_product']) {
            $id_product = $params['product']['id_product'];
        }

        $tabs = ClassProductCountdown::getFrontItems($id_product, $this->id_shop, true);

        $result = array();

        if ($tabs) {
            foreach ($tabs as $key => $tab) {
                $result[$key]['data_end'] = $tab['data_end'];
            }
        }
        
        $this->context->smarty->assign('countdown_ps_version', _PS_VERSION_);
        $this->context->smarty->assign('items', $result);

        return $this->display(__FILE__, 'views/templates/hook/productcountdown.tpl');
    }

    public function hookDisplayBeforeBodyClosingTag()
    {
        return $this->display($this->_path, '/views/templates/hook/productcountdown-script.tpl');
    }
}
