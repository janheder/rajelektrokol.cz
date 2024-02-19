<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Call
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
 * @author    Bonpresta
 * @copyright 2015-2021 Bonpresta
 * @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Boncall extends Module
{
    public function __construct()
    {
        $this->name = 'boncall';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '6732b5ed179f4da4905ebcb9059aaeef';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->displayName = $this->l('Call Back');
        $this->description = $this->l('Allows customers to request a call back.');
        $this->invalidName = $this->l('Invalid your name.');
        $this->invalidEmail = $this->l('Invalid email.');
        $this->invalidPhone = $this->l('Invalid phone number');
        $this->successAlert = $this->l('Thank you. We will call you soon.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'BON_CALL_EMAIL' => '',
            'BON_CALL_PHONE' => '+33-976-8754',
            'BON_CALL_POSITION' => 'left',
            'BON_CALL_EMAIL_DISPLAY' => true
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
            $this->registerHook('displayWrapperBottom');
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
                        'type' => 'select',
                        'label' => $this->l('Position:'),
                        'name' => 'BON_CALL_POSITION',
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
                        'type' => 'text',
                        'label' => $this->l('Email:'),
                        'name' => 'BON_CALL_EMAIL',
                        'required' => true,
                        'col' => 2,                  
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display Email:'),
                        'name' => 'BON_CALL_EMAIL_DISPLAY',
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
                        'label' => $this->l('Phone:'),
                        'name' => 'BON_CALL_PHONE',
                        'required' => true,
                        'col' => 2,
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
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
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

        if (Tools::isEmpty(Tools::getValue('BON_CALL_EMAIL'))) {
            $errors[] = $this->l('Email is required.');
        } else {
            if (!Validate::isEmail(Tools::getValue('BON_CALL_EMAIL'))) {
                $errors[] = $this->l('Email format error');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_CALL_PHONE'))) {
            $errors[] = $this->l('Phone is required.');
        } else {
            if (!Validate::isPhoneNumber(Tools::getValue('BON_CALL_PHONE'))) {
                $errors[] = $this->l('Phone format error');
            }
        }
        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/boncall.js');
        $this->context->controller->addCSS($this->_path . '/views/css/boncall.css');
        Media::addJsDefL('bon_call_url', $this->_path . '/controllers/front/ajax.php');
        Media::addJsDefL('static_token_bon_call', Tools::getToken(false));
        Media::addJsDefL('bon_call_position', Configuration::get('BON_CALL_POSITION'));
    }
    public function hookDisplayTop()
    {
        $this->context->smarty->assign(array(
            'bon_call_phone' => Configuration::get('BON_CALL_PHONE'),
            'bon_call_email' => Configuration::get('BON_CALL_EMAIL'),
            'bon_call_email_display' => Configuration::get('BON_CALL_EMAIL_DISPLAY'),
            'bon_call_position' => Configuration::get('BON_CALL_POSITION')
        ));

        return $this->display(__FILE__, 'views/templates/hook/boncall.tpl');
    }

    public function hookDisplayBonCallBack()
    {
        return $this->hookDisplayTop();
    }
    public function hookDisplayNav2()
    {
        return $this->hookDisplayTop();
    }
    public function hookdisplayWrapperBottom()
    {
        return $this->hookDisplayTop();
    }
}
