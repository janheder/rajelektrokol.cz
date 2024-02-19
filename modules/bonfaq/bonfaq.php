<?php
/**
* 2015-2020 Bonpresta
*
* Bonpresta Frequently Asked Questions
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

include_once(_PS_MODULE_DIR_.'bonfaq/classes/ClassFaq.php');

class Bonfaq extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonfaq';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->author = 'Bonpresta';
        $this->module_key = '287a2ff8d173caf8bc02f9184b2541c0';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Frequently Asked Questions');
        $this->description = $this->l('Display page frequently asked questions.');
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->controllers = array(
            'faq'
        );
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'bonfaq';
            }
        }
        $tab->class_name = 'AdminAjaxFaq';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxFaq')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->createAjaxController() &&
            $this->registerHook('moduleRoutes') &&
            $this->registerHook('customerAccount') &&
            $this->registerHook('displayMyAccountBlock') &&
            // $this->registerHook('displayBanner') &&
            $this->registerHook('displayBackOfficeHeader');
    }

    public function hookModuleRoutes()
    {
        return array(
            'module-bonfaq-faq' => array(
                'controller' => 'faq',
                'rule'       => 'faq',
                'keywords'   => array(),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'bonfaq',
                ),
            ),
        );
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
        $result ='';

        if ((bool)Tools::isSubmit('submitUpdateFaq')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addFaq();
            } else {
                $output = $result;
                $output .= $this->renderFaqForm();
            }
        }

        if ((bool)Tools::isSubmit('statusbonfaq')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deletebonfaq')) {
            $output .= $this->deleteFaq();
        }

        if (Tools::getIsset('updatebonfaq') || Tools::getValue('updatebonfaq')) {
            $output .= $this->renderFaqForm();
        } elseif ((bool)Tools::isSubmit('addbonfaq')) {
            $output .= $this->renderFaqForm();
        } elseif (!$result) {
            $output .= $this->renderFaqList();
        }

        return $output;
    }
    protected function renderFaqForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update Faq') : $this->l('Add Faq')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
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

        if ((bool)Tools::getIsset('updatebonfaq') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassFaq((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateFaq';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFaqFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigFaqFormValues()
    {
        if ((bool)Tools::getIsset('updatebonfaq') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassFaq((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassFaq();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
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

    public function renderFaqList()
    {
        if (!$tabs = ClassFaq::getFaqList()) {
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
        $helper->table = 'bonfaq';
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

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addFaq()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $faq = new ClassFaq((int)Tools::getValue('id_tab'));
        } else {
            $faq = new ClassFaq();
        }

        $faq->id_shop = (int)$this->context->shop->id;
        $faq->status = (int)Tools::getValue('status');

        if ((int)Tools::getValue('id_tab') > 0) {
            $faq->sort_order = Tools::getValue('sort_order');
        } else {
            $faq->sort_order = $faq->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $faq->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $faq->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$faq->add()) {
                    return $this->displayError($this->l('The faq could not be added.'));
                }
            } elseif (!$faq->update()) {
                return $this->displayError($this->l('The faq could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The faq is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('The faq name is required.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteFaq()
    {
        $tab = new ClassFaq(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassFaq(Tools::getValue('id_tab'));

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

        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxFaq'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxFaq'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/faq-back.js');
        $this->context->controller->addCSS($this->_path.'views/css/faq-back.css');
    }

    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'/views/css/faq-front.css');
    }

    public function hookCustomerAccount()
    {
        if (_PS_VERSION_ >= 1.7) {
            return $this->display(__FILE__, 'views/templates/hook/faq-my-account_1_7.tpl');
        } else {
            return $this->display(__FILE__, 'views/templates/hook/faq-my-account.tpl');
        }
    }

    public function hookDisplayMyAccountBlock()
    {
        return $this->hookCustomerAccount();
    }

    // public function hookDisplayBanner()
    // {
    //     return $this->hookCustomerAccount();
    // }
 
}
