<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Collection Manager with Photos and Videos
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

include_once(_PS_MODULE_DIR_ . 'boncollection/classes/ClassBoncollection.php');
include_once(_PS_MODULE_DIR_ . 'boncollection/classes/ClassBoncollectionSubcategory.php');

class Boncollection extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'boncollection';
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
        $this->displayName = $this->l('Collection Manager with Photos and Videos');
        $this->description = $this->l('Allows you to create multifunctional collections with videos and images, displays a carousel with collections on the home page.');
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
                $tab->name[$language['id_lang']] = 'boncollection';
            }
        }
        $tab->class_name = 'AdminAjaxBoncollection';
        $tab->module = $this->name;
        $tab->id_parent = -1;

        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxBoncollection')) {
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
            $this->registerHook('displayCustonBoncollection');
    }

    public function hookModuleRoutes()
    {
        $main_route = Configuration::get('BON_COLLECTION_MAINE_ROUTE') ? Configuration::get('BON_COLLECTION_MAINE_ROUTE') : 'collection';

        return array(
            'module-boncollection-main' => array(
                'controller' => 'main',
                'rule'       => $main_route,
                'keywords'   => array(),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'boncollection',
                ),
            ),
            'module-boncollection-collection' => array(
                'controller' => 'collection',
                'rule'       => $main_route . '/collection{/:id_tab}_{:link_rewrite}',
                'keywords' => array(
                    'id_tab' => array('regexp' => '[0-9]+', 'param' => 'id_tab'),
                    'link_rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*'),
                ),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'boncollection',
                ),
            ),
        );
    }

    protected function installSamples()
    {
        $now = date('Y-m-d H:i:00');
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 2; ++$i) {
            $item = new ClassBoncollection();
            $item->id_shop = (int)$this->context->shop->id;
            $item->status = 1;
            $item->date_public = $now;
            $item->sort_order = $i;
            $item->author_name = 'Maria Stone';
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'New Sports Bike Model';
                $item->url[$language['id_lang']] = 'our best collection';
                $item->image[$language['id_lang']] = 'sample-' . $i . '.jpg';
                $item->author_img[$language['id_lang']] = 'author-1.jpg';
                $item->description[$language['id_lang']] = '<p>Sed ut perspiciatis unde omnis iste natus error sit tatem accusantium doloremque laudantium, totam rem aperiam. Cusantium doloremque laudantium, totam rem aperiam.</p>';
            }
            $item->add();
            for ($j = 1; $j <= 2; ++$j) {
                $sub = new ClassBoncollectionSubcategory();
                $sub->id_shop = (int)$this->context->shop->id;
                $sub->id_tab = $i;
                $sub->status = 1;
                $sub->sort_order = $j;
                $sub->type = 'image';
                foreach ($languages as $language) {
                    $sub->title[$language['id_lang']] = 'Vestibulum lorem sed risus ultricies!';
                    $sub->image[$language['id_lang']] = 'sub-' . $j . '.jpg';
                    $sub->description[$language['id_lang']] = '<p>Vulputate odio ut enim blandit. Dolor purus non enim praesent elementum. Felis imperdiet proin fermentum leo vel orci porta non pulvinar. Tempor orci dapibus ultrices in iaculis nunc sed.</p>';
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
            'BON_COLLECTION_MAINE_ROUTE' => 'collection',
            'BON_NUMBER_COLLECTION' => 6,
            'BON_COLLECTION_LIMIT' => 6,
            'BON_COLLECTION_DISPLAY_CAROUSEL' => true,
            'BON_COLLECTION_DISPLAY_ITEM_NB' => 6,
            'BON_COLLECTION_CAROUSEL_NB' => 3,
            'BON_COLLECTION_CAROUSEL_LOOP' => false,
            'BON_COLLECTION_CAROUSEL_NAV' => true,
            'BON_COLLECTION_CAROUSEL_DOTS' => false,
            'BON_ADD_SHAREBUTTONS' => true,
        );

        return $settings;
    }

    public function getContent()
    {

        $output = '';
        $result = '';

        if (((bool)Tools::isSubmit('submitBoncollectionSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->collectionProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBoncollection')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addBoncollection();
            } else {
                $output = $result;
                $output .= $this->renderBoncollectionCategoryForm();
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBoncollectionSub')) {
            if (!$result = $this->preValidateFormSub()) {
                $output .= $this->addBoncollectionSub();
            } else {
                $output = $result;
                $output .= $this->renderBoncollectionSubcategoryForm();
            }
        }
        if (Tools::getIsset('updateboncollection') || Tools::getValue('updateboncollection')) {
            $output .= $this->renderBoncollectionCategoryForm();
        } elseif ((bool)Tools::isSubmit('addboncollection')) {
            $output .= $this->renderBoncollectionCategoryForm();
        } elseif ((bool)Tools::isSubmit('viewboncollection')) {
            $output .= $this->renderBoncollectionSubcategoryList();
        } elseif (Tools::getIsset('updateboncollection_sub') || Tools::getValue('updateboncollection_sub')) {
            $output .= $this->renderBoncollectionSubcategoryForm();
        } elseif ((bool)Tools::isSubmit('addsubboncollection')) {
            $output .= $this->renderBoncollectionSubcategoryForm();
        } elseif ((bool)Tools::isSubmit('statusboncollection')) {
            $output .= $this->updateStatusTab();
        } elseif ((bool)Tools::isSubmit('statusboncollection_sub')) {
            $output .= $this->updateStatusSubcategory();
        } elseif ((bool)Tools::isSubmit('deleteboncollection')) {
            $output .= $this->deleteBoncollection();
            $output .= $this->renderBoncollectionCategoryList();
            $output .= $this->renderFormSettings();
        } elseif ((bool)Tools::isSubmit('deleteboncollection_sub')) {
            $output .= $this->deleteBoncollectionSub();
            $output .= $this->renderBoncollectionSubcategoryList();
        } elseif (!$result) {
            $output .= $this->renderBoncollectionCategoryList();
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
        $helper->submit_action = 'submitBoncollectionSettingModule';
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
                        'label' => $this->l('Name of main collection page'),
                        'name' => 'BON_COLLECTION_MAINE_ROUTE',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Number of collection on the main page'),
                        'name' => 'BON_NUMBER_COLLECTION',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Display item on home page'),
                        'name' => 'BON_COLLECTION_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Add social media share buttons'),
                        'name' => 'BON_ADD_SHAREBUTTONS',
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
                        'type' => 'switch',
                        'label' => $this->l('Carousel on home page:'),
                        'name' => 'BON_COLLECTION_DISPLAY_CAROUSEL',
                        'desc' => $this->l('Display banner in the carousel.'),
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
                        'form_group_class' => 'display-collection-block',
                        'type' => 'text',
                        'label' => $this->l('Items:'),
                        'name' => 'BON_COLLECTION_CAROUSEL_NB',
                        'col' => 2,
                        'desc' => $this->l('The number of items you want to see on the screen.'),
                    ),
                    array(
                        'form_group_class' => 'display-collection-block',
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BON_COLLECTION_CAROUSEL_LOOP',
                        'desc' => $this->l('Infinity loop. Duplicate last and first items to get loop illusion.'),
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
                        'form_group_class' => 'display-collection-block',
                        'type' => 'switch',
                        'label' => $this->l('Nav:'),
                        'name' => 'BON_COLLECTION_CAROUSEL_NAV',
                        'desc' => $this->l('Show next/prev buttons.'),
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
                        'form_group_class' => 'display-collection-block',
                        'type' => 'switch',
                        'label' => $this->l('Dots:'),
                        'name' => 'BON_COLLECTION_CAROUSEL_DOTS',
                        'desc' => $this->l('Show dots navigation.'),
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

        if (Tools::isEmpty(Tools::getValue('BON_COLLECTION_MAINE_ROUTE'))) {
            $errors[] = $this->l('Name of main collection page is required.');
        }

        if (Tools::isEmpty(Tools::getValue('BON_NUMBER_COLLECTION'))) {
            $errors[] = $this->l('Number of collection on the main page is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_NUMBER_COLLECTION'))) {
                $errors[] = $this->l('Bad number of collection format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_COLLECTION_LIMIT'))) {
            $errors[] = $this->l('Limit is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_COLLECTION_LIMIT'))) {
                $errors[] = $this->l('Bad limit format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_COLLECTION_CAROUSEL_NB'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_COLLECTION_CAROUSEL_NB'))) {
                $errors[] = $this->l('Bad item format');
            }
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

    protected function collectionProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getBoncollectionSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    // Collection Category Settings
    protected function renderBoncollectionCategoryForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update collection category') : $this->l('Add collection category')),
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
                        'type' => 'text',
                        'label' => $this->l('Link Rewrit'),
                        'name' => 'url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'files_lang',
                        'label' => $this->l('Image'),
                        'name' => 'image',
                        'lang' => true,
                        'col' => 6,
                        'desc' => $this->l('format file .png, .jpg, .gif'),
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
                        'type' => 'datetime',
                        'label' => $this->l('Public Date'),
                        'name' => 'date_public',
                        'col' => 6,
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Author'),
                        'name' => 'author_name',
                        'col' => 3,
                        'desc' => $this->l('Format file .png, .jpg, .gif.'),
                    ),
                    array(
                        'type' => 'files_lang_author',
                        'label' => $this->l('Author image'),
                        'name' => 'author_img',
                        'lang' => true,
                        'form_group_class' => 'files_lang_author',
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

        if ((bool)Tools::getIsset('updateboncollection') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBoncollection((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
            $fields_form['form']['images'] = $tab->image;
            $fields_form['form']['author_img'] = $tab->author_img;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBoncollection';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBoncollectionFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBoncollectionFormValues()
    {
        if ((bool)Tools::getIsset('updateboncollection') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBoncollection((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassBoncollection();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'url' => Tools::getValue('url', $tab->url),
            'image' => Tools::getValue('image', $tab->image),
            'author_img' => Tools::getValue('author_img', $tab->author_img),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
            'date_public' => Tools::getValue('date_public', $tab->date_public),
            'author_name' => Tools::getValue('author_name', $tab->author_name),
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

    public function renderBoncollectionCategoryList()
    {
        if (!$tabs = ClassBoncollection::getBoncollectionCategoryList()) {
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
            'images' => array(
                'title' => $this->l('Label'),
                'type'  => 'box_image_category',
                'align' => 'center',
                'search' => false,
            ),
            'date_public' => array(
                'title' => $this->l('Collection create date'),
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
        $helper->table = 'boncollection';
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
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' . (int)$this->context->shop->id;

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

    protected function addBoncollection()
    {
        $errors = array();
        
        if ((int)Tools::getValue('id_tab') > 0) {
            $item = new ClassBoncollection((int)Tools::getValue('id_tab'));
        } else {
            $item = new ClassBoncollection();
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->status = (int)Tools::getValue('status');
 
        $item->date_public = Tools::getValue('date_public');
        $item->author_name = Tools::getValue('author_name');

        if ((int)Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
            $item->description[$language['id_lang']] = Tools::getValue('description_' . $language['id_lang']);
            $item->url[$language['id_lang']] = Tools::getValue('url_' . $language['id_lang']);
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_' . $language['id_lang']]['name'], '.'), 1));
            $type_author_img = Tools::strtolower(Tools::substr(strrchr($_FILES['author_img_' . $language['id_lang']]['name'], '.'), 1));

            if (isset($_FILES['author_img_' . $language['id_lang']]) && in_array($type_author_img, array('jpg', 'gif', 'jpeg', 'png', 'webp'))) {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['author_img_' . $language['id_lang']]['tmp_name'], dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['author_img_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['author_img_' . $language['id_lang']]) && isset($_FILES['author_img_' . $language['id_lang']]['tmp_name']) && !empty($_FILES['author_img_' . $language['id_lang']]['tmp_name'])) {
                        $item->author_img[$language['id_lang']] = $salt . '_' . $_FILES['author_img_' . $language['id_lang']]['name'];
                    } elseif (Tools::getValue('author_img_old_' . $language['id_lang']) != '') {
                        $item->author_img[$language['id_lang']] = Tools::getValue('author_img_old_' . $language['id_lang']);
                    }
                }
            }
            
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

        $class = new ClassBoncollection((int)Tools::getValue('id_tab'));
     
        $old_image = $class->image;
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

        if (!$old_image && (!isset($_FILES['image_' .  $this->default_language['id_lang']]) || Tools::isEmpty($_FILES['image_' .  $this->default_language['id_lang']]['tmp_name'])))  {

            $errors[] = $this->l('The file is required.');
        }

        if (Tools::isEmpty(Tools::getValue('date_public'))) {
            $errors[] = $this->l('The date start is required.');
        }

        if (!Validate::isDate(Tools::getValue('date_public'))) {
            $errors[] = $this->l('Invalid date field');
        }

        foreach ($languages as $lang) {
            if (!empty($_FILES['author_img_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['author_img_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Author Image format not recognized, allowed format is: .gif, .jpg, .png');
                }
            }
            if (!Tools::isEmpty($_FILES['image_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
                }
            }
        }
        
        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of collection is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of collection format.');
        }

        if (Tools::isEmpty(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The link rewrit is required.');
        } elseif (!Validate::isUrl(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad link rewrit format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBoncollection()
    {
        $tab = new ClassBoncollection(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if ($tab->delete()) {
            $tabs = ClassBoncollectionSubcategory::getBoncollectionSubcategoryList((int)Tools::getValue('id_tab'));
            if ($tabs) {
                foreach ($tabs as $tab) {
                    $tab = new ClassBoncollectionSubcategory($tab['id_tab']);
                    $tab->delete();
                }
            }

            $this->_confirmations = $this->l('Collection deleted.');
        }

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassBoncollection(Tools::getValue('id_tab'));

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

    // Collection Subcategory Settings
    protected function renderBoncollectionSubcategoryForm()
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
                        'href'  => AdminController::$currentIndex.'&configure='.$this->name.'&viewboncollection&id_tab='.Tools::getValue('id_tab').'&token='.Tools::getAdminTokenLite('AdminModules') .'&id_shop='. (int)$this->context->shop->id,
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

        if ((bool)Tools::getIsset('updateboncollection_sub') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBoncollectionSubcategory((int)Tools::getValue('id_sub'));
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
        $helper->submit_action = 'submitUpdateBoncollectionSub';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name . '&viewboncollection&id_tab=' .Tools::getValue('id_tab'). '&id_shop=' . (int)$this->context->shop->id;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBoncollectionSubcategoryFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
            'image_baseurl_video' => $this->_path . 'views/img/'
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBoncollectionSubcategoryFormValues()
    {
        if ((bool)Tools::getIsset('updateboncollection_sub') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBoncollectionSubcategory((int)Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBoncollectionSubcategory();
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

    public function renderBoncollectionSubcategoryList()
    {
        if (!$tabs = ClassBoncollectionSubcategory::getBoncollectionSubcategoryList(Tools::getValue('id_tab'))) {
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
        $helper->table = 'boncollection_sub';
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
  
    protected function addBoncollectionSub()
    {
        $errors = array();

        if ((int)Tools::getValue('id_sub') > 0) {
            $item = new ClassBoncollectionSubcategory((int)Tools::getValue('id_sub'));
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item = new ClassBoncollectionSubcategory();
            $item->sort_order = $item->getMaxSortOrder((int)Tools::getValue('id_tab'));
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->id_tab = (int)Tools::getValue('id_tab');
        $item->status = (int)Tools::getValue('status');
        $item->type = Tools::getValue('type');

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);

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

        $class = new ClassBoncollectionSubcategory((int)Tools::getValue('id_sub'));
        

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
            if (!empty($_FILES['author_img_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['author_img_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Author Image format not recognized, allowed format is: .gif, .jpg, .png');
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

    protected function deleteBoncollectionSub()
    {
        $tab = new ClassBoncollectionSubcategory(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the subcategory'));
        }

        return $this->displayConfirmation($this->l('The subcategory is successfully deleted'));
    }
    
    protected function updateStatusSubcategory()
    {
        $tab = new ClassBoncollectionSubcategory(Tools::getValue('id_sub'));

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
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBoncollection'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBoncollection'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . 'views/js/boncollection_back.js');
        $this->context->controller->addCSS($this->_path . 'views/css/boncollection_back.css');
    }

    public function hookHeader()
    {
        if (isset($this->context->controller->page_name) && $this->context->controller->page_name == "module-boncollection-collection") {
            $this->context->controller->addJS($this->_path . 'views/js/fancybox.umd.js');
            $this->context->controller->addCSS($this->_path . 'views/css/fancybox.css', 'all');
        }
        $this->context->controller->addJS($this->_path . 'views/js/slick.js');
        $this->context->controller->addCSS($this->_path . 'views/css/slick.css', 'all');
        $this->context->controller->addCSS($this->_path . 'views/css/slick-theme.css', 'all');
        $this->context->controller->addJS($this->_path . '/views/js/boncollection_front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/boncollection_front.css');

        $this->context->smarty->assign('settings', $this->getBoncollectionSettings());
   
        return $this->display($this->_path, '/views/templates/hook/boncollection-header.tpl');
    }

    public function hookDisplayHome()
    {
        $boncollection_front = new ClassBoncollection();
        $tabs = $boncollection_front->getTopFrontItems($this->id_shop, true);
        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['id'] = $tab['id_tab'];
            $result[$key]['title'] = mb_strimwidth($tab['title'], 0, 15, '...');
            $result[$key]['description'] = $tab['description'];
            $result[$key]['image'] = $tab['image'];
            $result[$key]['url'] = str_replace(' ', '_', $tab['url']);
            $result[$key]['date_public'] = $tab['date_public'];
            $result[$key]['author_name'] = $tab['author_name'];
        }
       
        $this->smarty->assign(array(
            'display_carousel' => Configuration::get('BON_COLLECTION_DISPLAY_CAROUSEL'),
            'items'=> $result,
            'collection_page'=> __PS_BASE_URI__ . Configuration::get('BON_COLLECTION_MAINE_ROUTE'),
            'image_baseurl'=> $this->_path . 'views/img/',
            'limit'=> Configuration::get('BON_COLLECTION_LIMIT')
        ));

        return $this->display(__FILE__, 'views/templates/hook/boncollection-home.tpl');
    }
    
    public function hookdisplayCustonBoncollection()
    {
        return $this->hookDisplayHome();
    }
}
