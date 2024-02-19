<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Google Map
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

include_once(_PS_MODULE_DIR_.'bongooglemap/classes/ClassGooglemap.php');

class Bongooglemap extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bongooglemap';
        $this->tab = 'front_office_features';
        $this->version = '1.0.2';
        $this->author = 'Bonpresta';
        $this->module_key = 'addaf557e295ea62ec6540d143103871';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Google Map');
        $this->description = $this->l('Display google map');
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->controllers = array(
            'googlemap'
        );
        if (Configuration::get('PS_SSL_ENABLED')) {
            $this->ssl = 'https://';
        } else {
            $this->ssl = 'http://';
        }
    }

    public function install()
    {

        include(dirname(__FILE__).'/sql/install.php');

        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('moduleRoutes') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayGoogleMap');
    }

    public function hookModuleRoutes()
    {
        return array(
            'module-bongooglemap-googlemap' => array(
                'controller' => 'googlemap',
                'rule'       => 'googlemap',
                'keywords'   => array(),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'bongooglemap',
                ),
            ),
        );
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall();
    }

    protected function getModuleSettings()
    {
        $settings = array(
            'BON_GOOGLE_KEY' => 'AIzaSyA-3t-iZiIPpsze7aXFrqDyPeZcTQG8erg',
            'BON_GOOGLE_LAT' => 26.00998700,
            'BON_GOOGLE_LONG' => -80.29447200,
            'BON_GOOGLE_TYPE' => 'roadmap',
            'BON_GOOGLE_ZOOM' => 8,
            'BON_GOOGLE_SCROLL' => 0,
            'BON_GOOGLE_TYPE_CONTROL' => 0,
            'BON_GOOGLE_STREET_VIEW' => 1,
            'BON_GOOGLE_ANIMATION' => 1,
            'BON_GOOGLE_POPUP' => 1
        );
        return $settings;
    }

    public function getContent()
    {

        $output = '';
        $result ='';

        if (((bool)Tools::isSubmit('submitBongooglemapSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Settings save.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool)Tools::isSubmit('submitUpdateGooglemap')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addGooglemap();
            } else {
                $output = $result;
                $output .= $this->renderGooglemapForm();
            }
        }

        if ((bool)Tools::isSubmit('statusbongooglemap')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deletebongooglemap')) {
            $output .= $this->deleteGooglemap();
        }

        if (Tools::getIsset('updatebongooglemap') || Tools::getValue('updatebongooglemap')) {
            $output .= $this->renderGooglemapForm();
        } elseif ((bool)Tools::isSubmit('addbongooglemap')) {
            $output .= $this->renderGooglemapForm();
        } elseif (!$result) {
            $output .= $this->renderGooglemapList();
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
        $helper->submit_action = 'submitBongooglemapSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'image_path' => $this->_path.'views/img',
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
                        'label' => $this->l('Google Key:'),
                        'name' => 'BON_GOOGLE_KEY',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Default Latitude:'),
                        'name' => 'BON_GOOGLE_LAT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Default Longitude:'),
                        'name' => 'BON_GOOGLE_LONG',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Map Type:'),
                        'name' => 'BON_GOOGLE_TYPE',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'roadmap',
                                    'name' => $this->l('Roadmap')),
                                array(
                                    'id' => 'satellite',
                                    'name' => $this->l('Satellite')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Zoom Level:'),
                        'name' => 'BON_GOOGLE_ZOOM',
                        'required' => true,
                        'col' => 2,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Zoom scroll:'),
                        'name' => 'BON_GOOGLE_SCROLL',
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
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Street view:'),
                        'name' => 'BON_GOOGLE_STREET_VIEW',
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
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Map controls:'),
                        'name' => 'BON_GOOGLE_TYPE_CONTROL',
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
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Bounce marker:'),
                        'name' => 'BON_GOOGLE_ANIMATION',
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
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display Popup:'),
                        'name' => 'BON_GOOGLE_POPUP',
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
                        )
                    )
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

        if (Tools::isEmpty(Tools::getValue('BON_GOOGLE_KEY'))) {
            $errors[] = $this->l('Google key is required.');
        }

        if (Tools::isEmpty(Tools::getValue('BON_GOOGLE_LAT'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isCoordinate(Tools::getValue('BON_GOOGLE_LAT'))) {
                $errors[] = $this->l('Bad latitude format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_GOOGLE_LONG'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isCoordinate(Tools::getValue('BON_GOOGLE_LONG'))) {
                $errors[] = $this->l('Bad longitude format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_GOOGLE_ZOOM'))) {
            $errors[] = $this->l('Zoom is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_GOOGLE_ZOOM'))) {
                $errors[] = $this->l('Bad zoom format');
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

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getGooglemapSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    protected function renderGooglemapForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update store') : $this->l('Add store')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select a store'),
                        'class' => 'id_store',
                        'name' => 'id_store',
                        'options' => array(
                            'query' => $this->getLocation(),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'filemanager_image',
                        'label' => $this->l('Marker'),
                        'name' => 'image',
                        'col' => 6,
                        'required' => true
                    ),
                    array(
                        'type' => 'textarea',
                        'autoload_rte' => true,
                        'label' => $this->l('Content'),
                        'name' => 'content',
                        'lang' => true
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

        if ((bool)Tools::getIsset('updatebongooglemap') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassGooglemap((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateGooglemap';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigGooglemapFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigGooglemapFormValues()
    {
        if ((bool)Tools::getIsset('updatebongooglemap') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassGooglemap((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassGooglemap();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_store' => Tools::getValue('id_store', $tab->id_store),
            'status' => Tools::getValue('status', $tab->status),
            'image' => Tools::getValue('image', $tab->image),
        );

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields_values['content'][$lang['id_lang']] = Tools::getValue(
                'content_' . (int) $lang['id_lang'],
                isset($tab->content[$lang['id_lang']]) ? $tab->content[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    public function renderGooglemapList()
    {
        if (!$tabs = ClassGooglemap::getGooglemapList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'name' => array(
                'title' => $this->l('Store name'),
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
            )
        );

        $helper = new HelperList();

        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_tab';
        $helper->table = 'bongooglemap';
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

    private function getLocation()
    {
        $res = array();

        $array = ClassGooglemap::getStoresId();

        if (is_array($array)) {
            foreach ($array as $arr) {
                array_push($res, array('id' => $arr['id_store'], 'name' => $arr['name']));
            }
        }

        return $res;
    }

    protected function addGooglemap()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $googlemap = new ClassGooglemap((int)Tools::getValue('id_tab'));
        } else {
            $googlemap = new ClassGooglemap();
        }

        $googlemap->id_store = Tools::getValue('id_store');
        $googlemap->id_shop = Context::getContext()->shop->id;
        $googlemap->status = (int)Tools::getValue('status');
        $googlemap->content = pSql(trim(Tools::getValue('content')));
        $googlemap->image = Tools::getValue('image');

        foreach (Language::getLanguages(false) as $lang) {
            $googlemap->content[$lang['id_lang']] = Tools::getValue('content_'.$lang['id_lang']);
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$googlemap->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$googlemap->update()) {
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

        $location = Tools::getValue('id_store');

        if (Tools::isEmpty(Tools::getValue('image'))) {
            $errors[] = $this->l('Image is empty');
        }

        if (!(int)Tools::getValue('id_tab')) {
            if ((bool)ClassGooglemap::getIdStore($location)) {
                $errors[] = $this->l('Shop already added');
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function deleteGooglemap()
    {
        $tab = new ClassGooglemap(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassGooglemap(Tools::getValue('id_tab'));

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

        $this->context->controller->addJquery();
        $this->context->controller->addJquery();
        $this->context->controller->addJS(_PS_JS_DIR_.'tiny_mce/tiny_mce.js');
        $this->context->controller->addJS(_PS_JS_DIR_.'admin/tinymce.inc.js');
        $this->context->controller->addJS($this->_path.'views/js/googlemap_back.js');
    }

    public function hookHeader()
    {
        if ($this->context->controller->php_self == "contact") {
            $stores = array();
            $array = ClassGooglemap::getInfoStore();

            if (is_array($array)) {
                foreach ($array as $arr) {
                    $stores[] = new Store((int)$arr['id_store'], true, $this->context->language->id, $this->context->shop->id);
                }
            }

            $this->context->smarty->assign(
                array(
                    'json_encode_store' => $stores,
                    'json_encode_info' => $array,
                )
            );

            $status = true;
            $script = '//maps.google.com/maps/api/js?key=' . Configuration::get('BON_GOOGLE_KEY') . '&amp;sensor=true';
            $load = '//maps.google.com/maps/api/js?key=' . Configuration::get('BON_GOOGLE_KEY') . '&amp;sensor=true';

            if (!in_array($script, $this->context->controller->js_files) && !in_array($load, $this->context->controller->js_files)) {
                $status = false;
            }

            $defaultLat = Configuration::get('BON_GOOGLE_LAT');
            $defaultLong = Configuration::get('BON_GOOGLE_LONG');

            Media::addJsDef(array(
                'status_map' => $status,
                'defaultLat' => $defaultLat,
                'defaultLong' => $defaultLong,
                'infoWindow' => '',
                'markers' => array(),
                'map' => '',
                'img_store_dir' => _THEME_STORE_DIR_,
                'img_ps_dir' => _THEME_IMG_DIR_,
                'image_url' => __PS_BASE_URI__,
                'json_encode_store' => $stores,
                'json_encode_info' => $array,
                'google_ps_version' => _PS_VERSION_,
                'google_language' => $this->context->language->id

            ));

            $this->context->smarty->assign('settings', $this->getGooglemapSettings());

            $this->context->controller->addCSS($this->_path . '/views/css/googlemap_front.css');
            $this->context->controller->addJS($this->_path . '/views/js/googlemap_front.js');

            return $this->display($this->_path, '/views/templates/hook/googlemap-header.tpl');
        }
    }

    public function hookDisplayHome()
    {
        return $this->display(__FILE__, 'views/templates/hook/googlemap-front.tpl');
    }

    public function hookDisplayFooter()
    {
        return $this->hookDisplayHome();
    }
    public function hookdisplayGoogleMap()
    {
        return $this->hookDisplayHome();
    }
}
