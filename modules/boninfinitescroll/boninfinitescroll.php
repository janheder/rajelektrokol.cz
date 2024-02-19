<?php
/**
 * 2015-2021 Bonpresta
 *
 * Infinite Scroll
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

class Boninfinitescroll extends Module
{
    public function __construct()
    {
        $this->name = 'boninfinitescroll';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Infinite Scroll');
        $this->description = $this->l('Enable infinite scroll');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'THEME_ENABLE' => true,
            'SCROLL_TYPE' => 'button'
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
       
        $this->registerHook('displayButtonScroll') &&
        
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
                        'type' => 'select',
                        'label' => $this->l('Loader Type:'),
                        'name' => 'SCROLL_TYPE',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'scroll',
                                    'name' => $this->l('scroll')),
                                array(
                                    'id' => 'button',
                                    'name' => $this->l('button')),
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
        
        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    public function hookDisplayHeader()
    {
        Media::addJsDefL('SCROLL_TYPE', Configuration::get('SCROLL_TYPE'));
        $queryPar =  rawurldecode($_SERVER['QUERY_STRING']);

        if (!empty($queryPar)) {
            Media::addJsDefL('query', $queryPar);
        } elseif (empty($queryPar)) {
            $queryPar = 0;
            Media::addJsDefL('query', $queryPar);
        }

        $this->context->controller->addCSS($this->_path.'/views/css/boninfinitescroll.css');
        
        if ($this->context->controller->php_self == "index") {
            $this->context->controller->addJS($this->_path . '/views/js/boninfinitescroll.js');
           
        } else {
            $this->context->controller->addJS($this->_path . '/views/js/boninfinitescroll-category.js');

        }

    }

    public function hookDisplayButtonScroll($params)
    {
         Media::addJsDefL('infinity_URL', $params['url']);
         Media::addJsDefL('parentDOM', $params['parent']);

        if (Configuration::get('SCROLL_TYPE') == 'button') {
            return $this->display(__FILE__, 'views/templates/hook/boninfinitescroll.tpl');
        }
    }

    public function hookDisplayButtonScrollCategory()
    {
        if (Configuration::get('SCROLL_TYPE') == 'button') {
            return $this->display(__FILE__, 'views/templates/hook/boninfinitescroll.tpl');
        }
    }
}
