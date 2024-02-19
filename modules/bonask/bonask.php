<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Quick Question
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

class Bonask extends Module
{
    public function __construct()
    {
        $this->name = 'bonask';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '6732b5ed179f4da4905ebcb9059aaeef';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->displayName = $this->l('Bonask');
        $this->description = $this->l('The user can ask a question by mail');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->invalidName = $this->l('Invalid your name');
        $this->invalidPhone = $this->l('Invalid phone number');
        $this->invalidEmail = $this->l('Invalid email');
        $this->invalidQuestion = $this->l('The question field is empty');
        $this->successAlert = $this->l('Thank you. We will call you soon.');
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'BON_ASK_EMAIL' => '',
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
        $this->registerHook('displayProductPopup') &&
        $this->registerHook('displayBeforeBodyClosingTag');
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
                        'type' => 'text',
                        'label' => $this->l('Email:'),
                        'name' => 'BON_ASK_EMAIL',
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

        if (Tools::isEmpty(Tools::getValue('BON_ASK_EMAIL'))) {
            $errors[] = $this->l('Email is required.');
        } else {
            if (!Validate::isEmail(Tools::getValue('BON_ASK_EMAIL'))) {
                $errors[] = $this->l('Email format error');
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    public function hookHeader()
    {
        $this->context->controller->addJqueryPlugin('fancybox');
        $this->context->controller->addJS($this->_path.'/views/js/bonask.js');
        $this->context->controller->addCSS($this->_path.'/views/css/bonask.css');
        Media::addJsDefL('bon_ask_url', $this->_path.'/controllers/front/ajax.php');
        Media::addJsDefL('static_token_bon_ask', Tools::getToken(false));
    }

    public function hookProductActions()
    {
        return $this->display(__FILE__, 'views/templates/hook/bonask-button.tpl');
    }
    public function hookDisplayProductPopup()
    {
        return $this->hookProductActions();
    }
    public function hookDisplayBeforeBodyClosingTag()
    {
        if ($this->context->controller->php_self == "product") {
            $product = new Product((int)Tools::getValue('id_product'));

            $this->context->smarty->assign(array(
                'product_name' => $product->name[$this->context->language->id],
                'bon_ask_id_product' => (int)Tools::getValue('id_product'),
                'bon_ask_phone' => $this->context->cookie->bon_ask_phone,
                'bon_ask_name' => $this->context->cookie->bon_ask_name,
                'bon_ask_mail' => $this->context->cookie->bon_ask_mail,
                'bon_ask_question' => $this->context->cookie->bon_ask_question,
            ));

            return $this->display(__FILE__, 'views/templates/hook/bonask.tpl');
        }
    }
}
