<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Custom Tab
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

include_once(_PS_MODULE_DIR_.'customtab/classes/ClassCustomTab.php');

class Customtab extends Module
{
    public function __construct()
    {
        $this->name = 'customtab';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '5285337c523cf793ea57f1d46ed61367';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Product Custom Tab');
        $this->description = $this->l('Module display product custom tab.');
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
                $tab->name[$language['id_lang']] = 'customtab';
            }
        }
        $tab->class_name = 'AdminAjaxCustomTab';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxCustomTab')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        $this->clearCache();
        include(dirname(__FILE__).'/sql/install.php');

        if (_PS_VERSION_ >= 1.7) {
            return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayProductTab') &&
            $this->registerHook('displayProductTabContent') &&
            $this->registerHook('productFooter');
        } else {
            return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('productFooter');
        }
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

        if ((bool)Tools::isSubmit('statuscustomtab')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deletecustomtab')) {
            $output .= $this->deleteTab();
        }

        if (Tools::getIsset('updatecustomtab') || Tools::getValue('updatecustomtab')) {
            $output .= $this->renderTabForm();
        } elseif ((bool)Tools::isSubmit('addcustomtab')) {
            $output .= $this->renderTabForm();
        } elseif (!$result) {
            $output .= $this->renderTabList();
        }

        return $output;
    }

    protected function clearCache()
    {
        $this->_clearCache('customtab.tpl');
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

        if ((bool)Tools::getIsset('updatecustomtab') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassCustomTab((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
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
        );
        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigFormValues()
    {
        if ((bool)Tools::getIsset('updatecustomtab') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassCustomTab((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassCustomTab();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_product' => $tab->id_product,
            'product_name' => ClassCustomTab::getProductName($tab->id_product),
            'link_rewrite' => ClassCustomTab::getProductLinkRewrite($tab->id_product),
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

    public function renderTabList()
    {
        if (!$tabs = ClassCustomTab::getCustomTabList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id tab'),
                'type'  => 'id_tab',
                'align' => 'center',
                'search' => false,
            ),
            'id_product' => array(
                'title' => $this->l('Id product'),
                'type'  => 'id_product',
                'align' => 'center',
                'search' => false,
            ),
            'image' => array(
                'title' => $this->l('Image'),
                'type'  => 'block_image',
                'align' => 'center',
                'search' => false,
            ),
            'title' => array(
                'title' => $this->l('Name'),
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
        $helper->table = 'customtab';
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
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addTab()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassCustomTab((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassCustomTab();
        }

        $tab->id_shop = (int)$this->context->shop->id;
        $tab->status = (int)Tools::getValue('status');
        $tab->id_product = (int)Tools::getValue('id_product');

        if ((int)Tools::getValue('id_tab') > 0) {
            $tab->sort_order = (int)Tools::getValue('sort_order');
        } else {
            $tab->sort_order = $tab->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);
        foreach ($languages as $language) {
            $tab->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $tab->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
        }

        if (!$errors) {
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

        if (Tools::isEmpty(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('The title is required.');
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
        $tab = new ClassCustomTab(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassCustomTab(Tools::getValue('id_tab'));

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
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxCustomTab'));
        Media::addJsDefL('file_theme_url', $this->_path);
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxCustomTab'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/customtab_admin.js');
        $this->context->controller->addCSS($this->_path.'views/css/customtab_admin.css');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/customtab.css');
    }

    public function hookDisplayProductTab()
    {
        $product = $this->context->controller->getProduct();
        $id_product = $product->id;

        $class = new ClassCustomTab;
        $tabs = $class->getFrontItems($id_product, $this->id_shop, true);
        $result = array();

        if ($tabs) {
            foreach ($tabs as $key => $tab) {
                $result[$key]['id_tab'] = $tab['id_tab'];
                $result[$key]['title'] = $tab['title'];
            }

            $this->context->smarty->assign('customtabs', $result);
        }

        return $this->display(__FILE__, 'views/templates/hook/customtab.tpl');
    }

    public function hookDisplayProductTabContent()
    {
        $product = $this->context->controller->getProduct();
        $id_product = $product->id;

        $class = new ClassCustomTab;
        $tabs = $class->getFrontItems($id_product, $this->id_shop, true);
        $result = array();

        if ($tabs) {
            foreach ($tabs as $key => $tab) {
                $result[$key]['id_tab'] = $tab['id_tab'];
                $result[$key]['title'] = $tab['title'];
                $result[$key]['description'] = $tab['description'];
            }

            $this->context->smarty->assign('customtabs', $result);
        }

        return $this->display(__FILE__, 'views/templates/hook/customtab-content.tpl');
    }

    public function hookProductFooter()
    {
        $product = $this->context->controller->getProduct();
        $id_product = $product->id;

        $class = new ClassCustomTab;
        $tabs = $class->getFrontItems($id_product, $this->id_shop, true);
        $result = array();

        if ($tabs) {
            foreach ($tabs as $key => $tab) {
                $result[$key]['title'] = $tab['title'];
                $result[$key]['description'] = $tab['description'];
            }

            $this->context->smarty->assign('customtabs', $result);
        }

        return $this->display(__FILE__, 'views/templates/hook/customtab-footer.tpl');
    }
}
