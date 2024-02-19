<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Cart
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

class Boncart extends Module
{
    public function __construct()
    {
        $this->name = 'boncart';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '501dfbfe7bed75b0385446410aff54db';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Shopping cart');
        $this->description = $this->l('Display shopping cart.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'CART_ENABLE' => true,
            'CART_PHONE' => '777050708',
            'CART_POSITION' => 'right',
            'CART_COLOR' => '#2ecc71',
            'CART_ANIMATION' => 'bon_tada',
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
        $this->registerHook('displayBonCart') &&
        $this->registerHook('displayHeader');
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
                        'label' => $this->l('Enable:'),
                        'name' => 'CART_ENABLE',
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
                    /*array(
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Mobile phone:'),
                        'name' => 'CART_PHONE',
                        'col' => 2
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Position:'),
                        'name' => 'CART_POSITION',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'left',
                                    'name' => $this->l('Left')),
                                array(
                                    'id' => 'right',
                                    'name' => $this->l('Right')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background button:'),
                        'name' => 'CART_COLOR',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Animation:'),
                        'name' => 'CART_ANIMATION',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'bon_tada',
                                    'name' => $this->l('Tada')),
                                array(
                                    'id' => 'bon_swing',
                                    'name' => $this->l('Swing')),
                                array(
                                    'id' => 'bon_rotate',
                                    'name' => $this->l('Rotate')),
                                array(
                                    'id' => 'bon_buzz',
                                    'name' => $this->l('Buzz')),
                                array(
                                    'id' => 'bon_backward',
                                    'name' => $this->l('Backward')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),*/
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
            'fields_value' => $this->getConfigFieldsValues(),
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

        /*if (Tools::isEmpty(Tools::getValue('CART_PHONE'))) {
            $errors[] = $this->l('The id phone required.');
        } else {
            if (!Validate::isPhoneNumber(Tools::getValue('CART_PHONE'))) {
                $errors[] = $this->l('Bad phone format');
            }
        }

        if (!Validate::isColor(Tools::getValue('CART_COLOR'))) {
            $errors[] = $this->l('"Background button" format error.');
        }
*/
        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    public function hookDisplayHeader()
    {
        if (Configuration::get('CART_ENABLE')) {
            $this->context->controller->addJS($this->_path . '/views/js/boncart.js');
            $this->context->controller->addCSS($this->_path . '/views/css/boncart.css');
        }
    }

    private function getCartSummaryURL()
    {
        return $this->context->link->getPageLink(
            'cart',
            null,
            $this->context->language->id,
            array(
                'action' => 'show'
            ),
            false,
            null,
            true
        );
    }

    public function hookDisplayBonCart()
    {
        if (Configuration::get('CART_ENABLE')) {
            $cart_url = $this->getCartSummaryURL();
            $this->context->smarty->assign(array(
                'cart_url' => $cart_url
            ));
            return $this->display($this->_path, '/views/templates/hook/boncart.tpl');
        }
    }
}
