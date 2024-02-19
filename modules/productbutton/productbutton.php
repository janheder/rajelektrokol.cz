<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Previous and Next navigation buttons to the  product page
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

class Productbutton extends Module
{
    public function __construct()
    {
        $this->name = 'productbutton';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = 'c5d647deb02e15a13a6ec32bbcce1cd9';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Previous and Next navigation buttons to the product page');
        $this->description = $this->l('Adding Previous and Next navigation buttons to the  product page.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'BUTTON_ITEM_STATUS' => true,
            'BUTTON_ITEM_HOVER' => true,
            'BUTTON_ITEM_WIDTH' => 150,
        );

        return $configurations;
    }

    public function install()
    {

        $configurations = $this->getConfigurations();

        foreach ($configurations as $name => $config) {
            Configuration::updateValue($name, $config);
        }

        return parent::install() &&
        $this->registerHook('displayHeader') &&
        $this->registerHook('displayProductButton') &&
        $this->registerHook('displayHome');
         
        
    }

    public function uninstall()
    {
        $configurations = $this->getConfigurations();

        foreach (array_keys($configurations) as $config) {
            Configuration::deleteByName($config);
        }

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';
        $result = '';

        if ((bool)Tools::isSubmit('submitSettings')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output = $result;
                $output .= $this->renderTabForm();
            }
        }

        if (!$result) {
            $output .= $this->renderTabForm();
        }

        return $output;
    }

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
                        'label' => $this->l('Enable'),
                        'name' => 'BUTTON_ITEM_STATUS',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enable',
                                'value' => 1,
                                'label' => $this->l('Yes')),
                            array(
                                'id' => 'disable',
                                'value' => 0,
                                'label' => $this->l('No')),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable hover box'),
                        'name' => 'BUTTON_ITEM_HOVER',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enable',
                                'value' => 1,
                                'label' => $this->l('Yes')),
                            array(
                                'id' => 'disable',
                                'value' => 0,
                                'label' => $this->l('No')),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Width hover box:'),
                        'name' => 'BUTTON_ITEM_WIDTH',
                        'col' => 2,
                        'suffix' => 'pixel',
                    ),
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
        $helper->submit_action = 'submitSettings';
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

    protected function preValidateForm()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('BUTTON_ITEM_WIDTH'))) {
            $errors[] = $this->l('Width is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BUTTON_ITEM_WIDTH'))) {
                $errors[] = $this->l('Bad width format');
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function getSmartyConfigurations()
    {
        return array(
            'status' => Configuration::get('BUTTON_ITEM_STATUS'),
            'hover' => Configuration::get('BUTTON_ITEM_HOVER'),
            'width' => Configuration::get('BUTTON_ITEM_WIDTH'),
        );
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/productbutton.js');
        $this->context->controller->addCSS($this->_path . '/views/css/productbutton.css');
    }
    

    public function productButton()
    {
        if (Configuration::get('BUTTON_ITEM_STATUS')) {
            $this->context->smarty->assign('configurations', $this->getSmartyConfigurations());
            $link = new Link();
            $prev_link = array();
            $prev_name = array();
            $next_link = array();
            $next_name = array();
            $prev_id = array();
            $prev_link_rewrite = array();
            $next_id = array();
            $next_link_rewrite = array();
            $prev_price = array();

            
            $product = $this->context->controller->getProduct();

            $this->context->smarty->assign(array( 'product_price' => $product->price));

            $id_product = Tools::getValue('id_product');
            $product = new Product($id_product, false, $this->context->cookie->id_lang);
            $product_last_visited = Product::idIsOnCategoryId($id_product, array('0' => array('id_category' => $this->context->cookie->last_visited_category)));

            if ((!isset($this->context->cookie->last_visited_category) || !$product_last_visited)) {
                $this->context->cookie->last_visited_category = $product->id_category_default;
            }

            $category = new Category($this->context->cookie->last_visited_category, $this->context->cookie->id_lang);
            $pr_category = $category->getProducts($this->context->cookie->id_lang, 1, 1000000);

            if (is_array($pr_category)) {
                for ($i = 0; $i < sizeof($pr_category); $i++) {
                    if ($pr_category[$i]['id_product'] == $id_product) {
                        if ($i > 0) {
                            $cat_product = new Product($pr_category[$i - 1]['id_product'], false, $this->context->cookie->id_lang);
                            $prev_link = $link->getProductLink($pr_category[$i - 1]['id_product'], $cat_product->link_rewrite, $category->link_rewrite, $cat_product->ean13);
                            $prev_name = $pr_category[$i - 1]['name'];
                            $prev_id = $pr_category[$i - 1]['id_product'];
                            $prev_link_rewrite = $pr_category[$i - 1]['link_rewrite'];
                           
                        }

                        if ($i < sizeof($pr_category) - 1) {
                            $cat_product = new Product($pr_category[$i + 1]['id_product'], false, $this->context->cookie->id_lang);
                            $next_link = $link->getProductLink($pr_category[$i + 1]['id_product'], $cat_product->link_rewrite, $category->link_rewrite, $cat_product->ean13);
                            $next_name = $pr_category[$i + 1]['name'];
                            $next_id = $pr_category[$i + 1]['id_product'];
                            $next_link_rewrite = $pr_category[$i + 1]['link_rewrite'];
                        }
                    }
                }
            }

            $this->context->smarty->assign(
                array(
                    'prev_link' => $prev_link,
                    'prev_name' => $prev_name,
                    'prev_id' => $prev_id,
                    'prev_link_rewrite' => $prev_link_rewrite,
                    'next_link' => $next_link,
                    'next_name' => $next_name,
                    'next_id' => $next_id,
                    'next_link_rewrite' => $next_link_rewrite
                )
            );

            if ($category->id == 1) {
                $this->context->cookie->last_visited_category = $product->id_category_default;
            }

            return $this->display($this->_path, '/views/templates/hook/productbutton.tpl');
        }
    }

    public function hookProductFooter()
    {
        return $this->hookExtraRight();
    }

    public function hookExtraLeft()
    {
        return $this->hookExtraRight();
    }

    public function hookExtraRight()
    {
        return $this->productButton();
    }

    public function hookDisplayHome()
    {
        if (Configuration::get('BUTTON_ITEM_STATUS')) {
            $this->context->cookie->last_visited_category = 1;
        }
    }

    public function hookdisplayProductButtons()
    {
        return $this->hookExtraRight();
    }

    public function hookdisplayProductAdditionalInfo()
    {
        return $this->productButton();
    }

    public function hookdisplayProductButton()
    {
        $page_name = Dispatcher::getInstance()->getController();
        if ($page_name == 'product') {
        return $this->productButton();
        }
    }
}