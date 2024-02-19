<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Portfolio with Masonry Effect
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

include_once(_PS_MODULE_DIR_ . 'bonportfolio/classes/ClassBonportfolio.php');
include_once(_PS_MODULE_DIR_ . 'bonportfolio/classes/ClassBonportfolioSubcategory.php');

class Bonportfolio extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonportfolio';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = '2a9a35bb078c36832bef985c8939911c';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Portfolio with Masonry Effect');
        $this->description = $this->l('Allows you to create beautiful portfolio page with masonry effect.');
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        if (Configuration::get('PS_SSL_ENABLED')) {
            $this->ssl = 'https://';
        } else {
            $this->ssl = 'http://';
        }
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'bonportfolio';
            }
        }
        $tab->class_name = 'AdminAjaxBonportfolio';
        $tab->module = $this->name;
        $tab->id_parent = -1;

        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxBonportfolio')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include(dirname(__FILE__) . '/sql/install.php');
        $this->installSamples();
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
            $this->registerHook('header') &&
            $this->createAjaxController() &&
            $this->registerHook('moduleRoutes') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayCustonBonportfolio');
    }

    public function hookModuleRoutes()
    {
        $main_route = Configuration::get('BON_PORTFOLIO_MAINE_ROUTE') ? Configuration::get('BON_PORTFOLIO_MAINE_ROUTE') : 'portfolio';

        return array(
            'module-bonportfolio-main' => array(
                'controller' => 'main',
                'rule'       => $main_route,
                'keywords'   => array(),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'bonportfolio',
                ),
            ),
        );
    }

    protected function installSamples()
    {
        $now = date('Y-m-d H:i:00');
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 2; ++$i) {
            $item = new ClassBonportfolio();
            $item->id_shop = (int)$this->context->shop->id;
            $item->status = 1;
            $item->sort_order = $i;
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'New Motorcycles';
            }
            $item->add();
            for ($j = 1; $j <= 3; ++$j) {
                $sub = new ClassBonportfolioSubcategory();
                $sub->id_shop = (int)$this->context->shop->id;
                $sub->id_tab = $i;
                $sub->status = 1;
                $sub->sort_order = $j;
                $sub->type = 'image';
                foreach ($languages as $language) {
                    $sub->title[$language['id_lang']] = 'Buy New Motorcycle Parts';
                    $sub->image[$language['id_lang']] = 'sample-'.$i . '-'. $j . '.jpg';
                    $sub->description[$language['id_lang']] = 'Vulputate odio ut enim blandit. Dolor purus non enim praesent elementum. ';
                }
                $sub->add();
            }
        }
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');

        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall()
            && $this->removeAjaxContoller();
    }

    protected function getModuleSettings()
    {
        $settings = array(
            'BON_PORTFOLIO_MAINE_ROUTE' => 'portfolio',
            'BONPORTFOLIO_ADD_SHAREBUTTONS' => false,
        );

        return $settings;
    }

    public function getContent()
    {

        $output = '';
        $result = '';

        if (((bool)Tools::isSubmit('submitBonportfolioSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->portfolioProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBonportfolio')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addBonportfolio();
            } else {
                $output = $result;
                $output .= $this->renderBonportfolioCategoryForm();
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBonportfolioSub')) {
            if (!$result = $this->preValidateFormSub()) {
                $output .= $this->addBonportfolioSub();
            } else {
                $output = $result;
                $output .= $this->renderBonportfolioSubcategoryForm();
            }
        }
        if (Tools::getIsset('updatebonportfolio') || Tools::getValue('updatebonportfolio')) {
            $output .= $this->renderBonportfolioCategoryForm();
        } elseif ((bool)Tools::isSubmit('addbonportfolio')) {
            $output .= $this->renderBonportfolioCategoryForm();
        } elseif ((bool)Tools::isSubmit('viewbonportfolio')) {
            $output .= $this->renderBonportfolioSubcategoryList();
        } elseif (Tools::getIsset('updatebonportfolio_sub') || Tools::getValue('updatebonportfolio_sub')) {
            $output .= $this->renderBonportfolioSubcategoryForm();
        } elseif ((bool)Tools::isSubmit('addsubbonportfolio')) {
            $output .= $this->renderBonportfolioSubcategoryForm();
        } elseif ((bool)Tools::isSubmit('statusbonportfolio')) {
            $output .= $this->updateStatusTab();
            $output .= $this->renderBonportfolioCategoryList();
            $output .= $this->renderFormSettings();
        } elseif ((bool)Tools::isSubmit('statusbonportfolio_sub')) {
            $output .= $this->updateStatusSubcategory();
            $output .= $this->renderBonportfolioSubcategoryList();
        } elseif ((bool)Tools::isSubmit('deletebonportfolio')) {
            $output .= $this->deleteBonportfolio();
            $output .= $this->renderBonportfolioCategoryList();
            $output .= $this->renderFormSettings();
        } elseif ((bool)Tools::isSubmit('deletebonportfolio_sub')) {
            $output .= $this->deleteBonportfolioSub();
            $output .= $this->renderBonportfolioSubcategoryList();
        } elseif (!$result) {
            $output .= $this->renderBonportfolioCategoryList();
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
        $helper->submit_action = 'submitBonportfolioSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'image_path' => $this->_path . 'views/img',
            'fields_value' => $this->getConfigFormValuesSettings(), /* Add values for your inputs */
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
                        'type' => 'text',
                        'label' => $this->l('Name of main portfolio page'),
                        'name' => 'BON_PORTFOLIO_MAINE_ROUTE',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Add social media share buttons'),
                        'name' => 'BONPORTFOLIO_ADD_SHAREBUTTONS',
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
                ),
            ),
        );
    }

    protected function validateSettings()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('BON_PORTFOLIO_MAINE_ROUTE'))) {
            $errors[] = $this->l('Name of portfolio is required.');
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

    protected function portfolioProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getBonportfolioSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    // Portfolio Category Settings
    protected function renderBonportfolioCategoryForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update portfolio category') : $this->l('Add portfolio category')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Name'),
                        'name' => 'title',
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
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonportfolio') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonportfolio((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonportfolio';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonportfolioFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonportfolioFormValues()
    {
        if ((bool)Tools::getIsset('updatebonportfolio') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonportfolio((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassBonportfolio();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        );

        return $fields_values;
    }

    public function renderBonportfolioCategoryList()
    {
        if (!$tabs = ClassBonportfolio::getBonportfolioCategoryList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'title' => array(
                'title' => $this->l('Title'),
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
        $helper->table = 'bonportfolio';
        $helper->actions = array('view', 'edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&add' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new item')
        );
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name . '&id_shop=' . (int)$this->context->shop->id;
        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonportfolio()
    {
        $errors = array();
        
        if ((int)Tools::getValue('id_tab') > 0) {
            $item = new ClassBonportfolio((int)Tools::getValue('id_tab'));
        } else {
            $item = new ClassBonportfolio();
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->status = (int)Tools::getValue('status');
 
        if ((int)Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The item is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonportfolio((int)Tools::getValue('id_tab'));
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of portfolio is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of portfolio format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonportfolio()
    {
        $tab = new ClassBonportfolio(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if ($tab->delete()) {
            $tabs = ClassBonportfolioSubcategory::getBonportfolioSubcategoryList((int)Tools::getValue('id_tab'));
            if ($tabs) {
                foreach ($tabs as $tab) {
                    $tab = new ClassBonportfolioSubcategory($tab['id_tab']);
                    $tab->delete();
                }
            }

            $this->_confirmations = $this->l('Portfolio deleted.');
        }

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassBonportfolio(Tools::getValue('id_tab'));

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

    // Portfolio Subcategory Settings
    protected function renderBonportfolioSubcategoryForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_sub') ? $this->l('Update subcategory') : $this->l('Add subcategory')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col'   => 2,
                        'type'  => 'text',
                        'name'  => 'id_tab',
                        'class' => 'hidden'
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Type:'),
                        'name' => 'type',
                        'form_group_class' => 'content_type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'image',
                                    'name' => $this->l('Image')
                                ),
                                array(
                                    'id' => 'video',
                                    'name' => $this->l('Video')
                                ),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'files_lang_cover',
                        'label' => $this->l('Cover image'),
                        'name' => 'cover',
                        'lang' => true,
                        'form_group_class' => 'files_lang_cover',
                        'desc' => $this->l('Format file .png, .jpg, .gif.'),
                    ),
                    array(
                        'type' => 'files_lang_sub',
                        'label' => $this->l('Image / Video'),
                        'name' => 'image',
                        'lang' => true,
                        'col' => 6,
                        'desc' => $this->l('If the content`s type is image - format file .png, .jpg, .gif. If the content`s type is video - format file .mp4, .webm, .ogv.'),
                        'required' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
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
                    'type'  => 'submit',
                ),
                'buttons' => array(
                    array(
                        'href'  => AdminController::$currentIndex.'&configure='.$this->name.'&viewbonportfolio&id_tab='.Tools::getValue('id_tab').'&token='.Tools::getAdminTokenLite('AdminModules') .'&id_shop='. (int)$this->context->shop->id,
                        'title' => $this->l('Cancel'),
                        'icon'  => 'process-icon-cancel'
                    ),
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to main page'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonportfolio_sub') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonportfolioSubcategory((int)Tools::getValue('id_sub'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_sub', 'value' => (int)$tab->id);
            $fields_form['form']['cover'] = $tab->cover;
            $fields_form['form']['images'] = $tab->image;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonportfolioSub';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name . '&viewbonportfolio&id_tab=' .Tools::getValue('id_tab'). '&id_shop=' . (int)$this->context->shop->id;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonportfolioSubcategoryFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
            'image_baseurl_video' => $this->_path . 'views/img/'
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonportfolioSubcategoryFormValues()
    {
        if ((bool)Tools::getIsset('updatebonportfolio_sub') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonportfolioSubcategory((int)Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBonportfolioSubcategory();
        }
        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_sub' => Tools::getValue('id_sub'),
            'title' => Tools::getValue('title', $tab->title),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
            'cover' => Tools::getValue('cover', $tab->cover),
            'image' => Tools::getValue('image', $tab->image),
            'type' => Tools::getValue('type', $tab->type),
        );

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields_values['description'][$lang['id_lang']] = Tools::getValue(
                'description_' . (int) $lang['id_lang'],
                isset($tab->description[$lang['id_lang']]) ? $tab->description[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    public function renderBonportfolioSubcategoryList()
    {
        if (!$tabs = ClassBonportfolioSubcategory::getBonportfolioSubcategoryList(Tools::getValue('id_tab'))) {
            $tabs = array();
        }

        $fields_list = array(
            'id_sub' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'id_tab' => array(
                'title' => ($this->l('Id tab')),
                'type'  => 'text',
                'class' => 'hidden id_tab',
                'search' => false,
                'orderby' => false,
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'type' => array(
                'title' => $this->l('Type'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'images' => array(
                'title' => $this->l('Label'),
                'type'  => 'box_image',
                'align' => 'center',
                'search' => false,
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
            ),
            
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_sub';
        $helper->table = 'bonportfolio_sub';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&addsub' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules')
                . '&id_shop=' . (int)$this->context->shop->id
                . '&id_tab=' .Tools::getValue('id_tab'),
            'desc' => $this->l('Add new item')
        );
        $helper->toolbar_btn['back'] = array(
            'href' => AdminController::$currentIndex.'&configure='.$this->name .'&token='.Tools::getAdminTokenLite('AdminModules') . '&id_shop=' . (int)$this->context->shop->id,
            'desc' => $this->l('Back to main page')
        );
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' . (int)$this->context->shop->id . '&id_tab=' .Tools::getValue('id_tab');

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
            'image_baseurl_video' => $this->_path . 'views/img/'

        );

        return $helper->generateList($tabs, $fields_list);
    }
  
    protected function addBonportfolioSub()
    {
        $errors = array();

        if ((int)Tools::getValue('id_sub') > 0) {
            $item = new ClassBonportfolioSubcategory((int)Tools::getValue('id_sub'));
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item = new ClassBonportfolioSubcategory();
            $item->sort_order = $item->getMaxSortOrder((int)Tools::getValue('id_tab'));
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->id_tab = (int)Tools::getValue('id_tab');
        $item->status = (int)Tools::getValue('status');
        $item->type = Tools::getValue('type');

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
            $item->description[$language['id_lang']] = Tools::getValue('description_' . $language['id_lang']);
            $type_cover = Tools::strtolower(Tools::substr(strrchr($_FILES['cover_' . $language['id_lang']]['name'], '.'), 1));
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_' . $language['id_lang']]['name'], '.'), 1));

            if (isset($_FILES['cover_' . $language['id_lang']]) && in_array($type_cover, array('jpg', 'gif', 'jpeg', 'png', 'webp'))) {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['cover_' . $language['id_lang']]['tmp_name'], dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['cover_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['cover_' . $language['id_lang']]) && isset($_FILES['cover_' . $language['id_lang']]['tmp_name']) && !empty($_FILES['cover_' . $language['id_lang']]['tmp_name'])) {
                        $item->cover[$language['id_lang']] = $salt . '_' . $_FILES['cover_' . $language['id_lang']]['name'];
                    } elseif (Tools::getValue('cover_old_' . $language['id_lang']) != '') {
                        $item->cover[$language['id_lang']] = Tools::getValue('cover_old_' . $language['id_lang']);
                    }
                }
            }

            if (Tools::getValue('type') == 'video') {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['image_' . $language['id_lang']]['tmp_name'], dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['image_' . $language['id_lang']]) && isset($_FILES['image_' . $language['id_lang']]['tmp_name'])
                    && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])) {
                        $item->image[$language['id_lang']] = $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'];
                    } elseif (Tools::getValue('image_old_' . $language['id_lang']) != '') {
                        $item->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
                    }
                }
            } elseif (Tools::getValue('type') == 'image') {
                $imagesize = $_FILES['image_'.$language['id_lang']]["tmp_name"] != '' ? @getimagesize($_FILES['image_'.$language['id_lang']]["tmp_name"]) : '';
                if (isset($_FILES['image_' . $language['id_lang']])
                    && isset($_FILES['image_' . $language['id_lang']]['tmp_name'])
                    && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])
                    && !empty($imagesize)
                    && in_array(
                        Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)),
                        array('jpg', 'gif', 'jpeg', 'png', 'webp')
                    )
                    && in_array($type, array('jpg', 'gif', 'jpeg', 'png', 'webp'))
                ) {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ($error = ImageManager::validateUpload($_FILES['image_' . $language['id_lang']])) {
                        $errors[] = $error;
                    } elseif (!$temp_name || !move_uploaded_file($_FILES['image_' . $language['id_lang']]['tmp_name'], $temp_name)) {
                        return false;
                    } elseif (!ImageManager::resize($temp_name, dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'], null, null, $type)) {
                        $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                    }

                    if (isset($temp_name)) {
                        @unlink($temp_name);
                    }
                    $item->image[$language['id_lang']] = $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'];
                } elseif (Tools::getValue('image_old_' . $language['id_lang']) != '') {
                    $item->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
                }
            }
        }

        if (!$errors) {
            if (!Tools::getValue('id_sub')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The subcategory is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateFormSub()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonportfolioSubcategory((int)Tools::getValue('id_sub'));

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of item is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of item format.');
        }
        foreach ($languages as $lang) {
            if (!empty($_FILES['cover_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['cover_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
                }
            }
        }

        if (Tools::getValue('type') == 'image') {
            foreach ($languages as $lang) {
                if (!Tools::isEmpty($_FILES['image_' . $lang['id_lang']]['type'])) {
                    if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
                        $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
                    }
                }
            }
        }

        if (Tools::getValue('type') == 'video') {
            $info = new SplFileInfo($_FILES['image_' . $this->default_language['id_lang']]['name']);
            if ($_FILES['image_' . $this->default_language['id_lang']]['name'] != '') {
                if ($info->getExtension() != 'mp4' && $info->getExtension() != 'webm' && $info->getExtension() != 'ogv') {
                    $errors[] = $this->l('Video format not recognized, allowed format is: .mp4, .webm, .ogv');
                }
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonportfolioSub()
    {
        $tab = new ClassBonportfolioSubcategory(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the subcategory'));
        }

        return $this->displayConfirmation($this->l('The subcategory is successfully deleted'));
    }
    
    protected function updateStatusSubcategory()
    {
        $tab = new ClassBonportfolioSubcategory(Tools::getValue('id_sub'));

        if ($tab->status == 1) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The subcategory status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The subcategory status is successfully updated.'));
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonportfolio'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonportfolio'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . 'views/js/bonportfolio_back.js');
        $this->context->controller->addCSS($this->_path . 'views/css/bonportfolio_back.css');
    }

    public function hookHeader()
    {
        if (isset($this->context->controller->page_name) && $this->context->controller->page_name == "module-bonportfolio-main") {
            $this->context->controller->addJS($this->_path . 'views/js/fancybox.umd.js');
            $this->context->controller->addJS($this->_path . 'views/js/masonry.pkgd.min.js');
            $this->context->controller->addCSS($this->_path . 'views/css/fancybox.css', 'all');
            $this->context->controller->addJS($this->_path . '/views/js/bonportfolio_front.js');
            $this->context->controller->addCSS($this->_path . '/views/css/bonportfolio_front.css');
            $this->context->smarty->assign('settings', $this->getBonportfolioSettings());
            return $this->display($this->_path, '/views/templates/hook/bonportfolio-header.tpl');
        }
    }

    public function hookdisplayCustonBonportfolio()
    {
        return $this->hookDisplayHome();
    }
}
