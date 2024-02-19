<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Rollover Image
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

class Rolloverimage extends Module
{
    public function __construct()
    {
        $this->name = 'rolloverimage';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '3f8fb748601e011de2f70da7951d6444';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Rollover Image With Animation Effects');
        $this->description = $this->l('Display rollover image with effects.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'ROLLOVER_ITEM_STATUS' => true,
            'ROLLOVER_ITEM_TYPE' => 'opacity',
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
        $this->registerHook('actionProductAdd') &&
        $this->registerHook('actionProductSave') &&
        $this->registerHook('actionProductUpdate') &&
        $this->registerHook('actionProductDelete') &&
        $this->registerHook('displayRolloverImage');
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
                        'label' => $this->l('Enable: '),
                        'name' => 'ROLLOVER_ITEM_STATUS',
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
                        'type' => 'select',
                        'label' => $this->l('Type hover:'),
                        'name' => 'ROLLOVER_ITEM_TYPE',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'hr_hover',
                                    'name' => $this->l('Horizontal hover')),
                                array(
                                    'id' => 'opacity',
                                    'name' => $this->l('Opacity')),
                                array(
                                    'id' => 'vr_hover',
                                    'name' => $this->l('Vertical hover'))
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
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

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function getSmartyConfigurations()
    {
        return array(
            'status' => Configuration::get('ROLLOVER_ITEM_STATUS'),
        );
    }

    protected function getStringValueType($data)
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

    protected function getRolloverSettings()
    {
        $settings = $this->getConfigurations();
        $get_settings = array();

        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    public function hookActionProductAdd()
    {
        $this->clearCache();
    }

    public function hookActionProductSave()
    {
        $this->clearCache();
    }

    public function hookActionProductUpdate()
    {
        $this->clearCache();
    }

    public function hookActionProductDelete()
    {
        $this->clearCache();
    }

    protected function clearCache()
    {
        $this->_clearCache('homefeatured.tpl');
        $this->_clearCache('blocknewproducts_home.tpl');
        $this->_clearCache('blockspecials-home.tpl');
        $this->_clearCache('blockbestsellers-home.tpl');
        $this->_clearCache('rollover_image.tpl');
        $this->_clearCache('rollover-header.tpl');
    }

    public function getCacheId($id_product = null)
    {
        return parent::getCacheId().'|'.(int)$id_product;
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/rollover_image.js');
        $this->context->controller->addCSS($this->_path . '/views/css/rollover_image.css');

        if (Configuration::get('ROLLOVER_ITEM_STATUS')) {
            if (!$this->isCached('rollover-header.tpl', $this->getCacheId())) {
                $this->context->smarty->assign('settings', $this->getRolloverSettings());
            }
            return $this->display($this->_path, '/views/templates/hook/rollover-header.tpl', $this->getCacheId());
        }
    }

    public function hookDisplayRolloverImage($params)
    {
        $id_product = (int)$params['product']['id_product'];
        if (!$this->isCached('rollover_image.tpl', $this->getCacheId($id_product))) {
            $product = new Product($id_product);

            $this->smarty->assign(array(
                'images' => $product->getImages($this->context->language->id),
                'product' => $params['product'],
                'configurations' => $this->getSmartyConfigurations(),
                'link' => new Link()
            ));
        }
        return $this->display($this->_path, '/views/templates/hook/rollover_image.tpl', $this->getCacheId($id_product));
    }
}