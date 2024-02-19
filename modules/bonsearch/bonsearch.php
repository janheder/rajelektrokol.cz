<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Advanced Ajax Live Search Product
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

class Bonsearch extends Module
{
    public $category = array();

    public function __construct()
    {
        $this->name = 'bonsearch';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '01d13b432a310ab8b79cc97da1d473d5';
        parent::__construct();
        $this->no_product = $this->l('No products found');
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Advanced Ajax Live Search Product');
        $this->description = $this->l('Display advanced ajax live search product.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'BON_SEARCH_COUNT' => 5,
            'BON_SEARCH_PRICE' => true,
            'BON_SEARCH_IMAGE' => true,
            'BON_SEARCH_NAME' => true,
            'BON_SEARCH_REFERENCE' => false,
            'BON_SEARCH_STYLE' => 'style_3',
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
        $this->registerHook('displayTop') &&
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

        if ((bool)Tools::isSubmit('submitSettings')) {
            if (!$errors = $this->checkItemFields()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output .= $errors;
            }
        }

        return $output.$this->renderTabForm();
    }

    protected function checkItemFields()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('BON_SEARCH_COUNT'))) {
            $errors[] = $this->l('Product count is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_SEARCH_COUNT'))) {
                $errors[] = $this->l('Bad product count format');
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
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
                        'label' => $this->l('Enable Image'),
                        'name' => 'BON_SEARCH_IMAGE',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Name'),
                        'name' => 'BON_SEARCH_NAME',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Reference'),
                        'name' => 'BON_SEARCH_REFERENCE',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Price'),
                        'name' => 'BON_SEARCH_PRICE',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Number products:'),
                        'name' => 'BON_SEARCH_COUNT',
                        'col' => 1,
                        'required' => true,
                    ),
                    /*array(
                        'type' => 'select',
                        'label' => $this->l('Style:'),
                        'name' => 'BON_SEARCH_STYLE',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'style_1',
                                    'name' => $this->l('Style 1')),
                                array(
                                    'id' => 'style_2',
                                    'name' => $this->l('Style 2')),
                                array(
                                    'id' => 'style_3',
                                    'name' => $this->l('Style 3')),
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

    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/jquery.nice-select.min.js');
        $this->context->controller->addCSS($this->_path . '/views/css/nice-select.css');
        $this->context->controller->addJS($this->_path . '/views/js/bonsearch.js');
        $this->context->controller->addCSS($this->_path . '/views/css/bonsearch.css');
        Media::addJsDefL('bon_search_url', $this->_path.'/controllers/ajax.php');
        Media::addJsDefL('static_token_bon_search', Tools::getToken(false));
    }
    public function getCategoriesList()
    {
        $category = new Category();
        $this->getItemCategories($category->getNestedCategories((int)Configuration::get('PS_HOME_CATEGORY')));
    }
 
    public function getItemCategories($categories)
    {
        foreach ($categories as $category) {
            
            array_push(
                $this->category,
                array(
                    'id' => (int)$category['id_category'],
                    'name' => $category['name'],
                    'level_depth' => (int)$category['level_depth'],
                    'id_parent' => (int)$category['id_parent']
                )
            );

            if (isset($category['children']) && !empty($category['children'])) {
                $this->getItemCategories($category['children']);
            }
        }
    }

    public function hookDisplayTop()
    {
        if (_PS_VERSION_ >= 1.7) {
            $front_class = 'version_1_7';
        } else {
            $front_class = 'version_1_6';
        }
        $this->getCategoriesList();

        array_shift($this->category);
        
 
        $this->smarty->assign(array(
            'categories' =>  $this->category,
            'root_url' => _PS_BASE_URL_.__PS_BASE_URI__,
            'front_class' => $front_class,
            'bon_search_front_style' => Configuration::get('BON_SEARCH_STYLE'),
        ));

        return $this->display($this->_path, '/views/templates/hook/bonsearch.tpl');
    }

    public function hookDisplayNav1()
    {
        return $this->hookDisplayTop();
    }

    public function hookDisplayNav2()
    {
        return $this->hookDisplayTop();
    }

    public function hookDisplaySearch()
    {
        return $this->hookDisplayTop();
    }

    public function hookDisplayBonSearch()
    {
        return $this->hookDisplayTop();
    }

    public function hookDisplayNavFullWidth()
    {
        return $this->hookDisplayTop();
    }
}
