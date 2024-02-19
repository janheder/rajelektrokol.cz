<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Customer Reassurance With Icons
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

include_once(_PS_MODULE_DIR_.'bonreassurance/classes/ClassBonreassurance.php');

class Bonreassurance extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonreassurance';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = '9ae2e17e4bb93dd10507ed1d016c04c0';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Customer Reassurance With Icons');
        $this->description = $this->l('Display html content with icons and slider for your customers');
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
                $tab->name[$language['id_lang']] = 'bonreassurance';
            }
        }
        $tab->class_name = 'AdminAjaxBonreassurance';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxBonreassurance')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        $this->installSamples();
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
        $this->registerHook('header') &&
        $this->createAjaxController() &&
        $this->registerHook('displayBackOfficeHeader') &&
        $this->registerHook('displayProductAdditionalInfo') &&
        $this->registerHook('displayBonreassuranceCustom');
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 3; ++$i) {
            $item = new ClassBonreassurance();
            $item->id_shop = (int)$this->context->shop->id;
            $item->status = 1;
            $item->sort_order = $i;
            $item->specific_class = '';
            $item->type_icon = 'outicons';
            $item->font_size = '27';
            $item->font_color = '#3a3a3a';

            if ($i == 1) {
                $item->icon = 'fl-outicons fl-outicons-truck72';
                foreach ($languages as $language) {
                    $item->description[$language['id_lang']] = '<p>Free Delivery</p>';
                }
            } elseif ($i == 2) {
                $item->icon = 'fl-outicons fl-outicons-headphones46';
                foreach ($languages as $language) {
                    $item->description[$language['id_lang']] = '<p>Customer Support</p>';
                }
            } elseif ($i == 3) {
                $item->icon = 'fl-outicons fl-outicons-sales2';
                foreach ($languages as $language) {
                    $item->description[$language['id_lang']] = '<p>Payment Secured</p>';
                }
            }

            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'html';
                $item->url[$language['id_lang']] = '6-accessories';
            }

            $item->add();
        }
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

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
            'BON_REAS_LIMIT' => 4,
            'BON_REAS_DISPLAY_CAROUSEL' => false,
            'BON_REAS_CAROUSEL_NB' => 4,
            'BON_REAS_CAROUSEL_LOOP' => false,
            'BON_REAS_CAROUSEL_NAV' => true,
            'BON_REAS_CAROUSEL_DOTS' => true,
        );
        return $settings;
    }

    public function getContent()
    {

        $output = '';
        $result ='';

        if (((bool)Tools::isSubmit('submitBonreassuranceSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool)Tools::isSubmit('submitUpdateBonreassurance')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addBonreassurance();
            } else {
                $output = $result;
                $output .= $this->renderBonreassuranceForm();
            }
        }

        if ((bool)Tools::isSubmit('statusBonreassurance')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deletebonreassurance')) {
            $output .= $this->deleteBonreassurance();
        }

        if (Tools::getIsset('updatebonreassurance') || Tools::getValue('updatebonreassurance')) {
            $output .= $this->renderBonreassuranceForm();
        } elseif ((bool)Tools::isSubmit('addbonreassurance')) {
            $output .= $this->renderBonreassuranceForm();
        } elseif (!$result) {
            $output .= $this->renderBonreassuranceList();
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
        $helper->submit_action = 'submitBonreassuranceSettingModule';
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
                        'label' => $this->l('Display item'),
                        'name' => 'BON_REAS_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Carousel:'),
                        'name' => 'BON_REAS_DISPLAY_CAROUSEL',
                        'desc' => $this->l('Display content in the carousel on home page.'),
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
                        'form_group_class' => 'display-block-bonreassurance',
                        'type' => 'text',
                        'label' => $this->l('Items:'),
                        'name' => 'BON_REAS_CAROUSEL_NB',
                        'col' => 2,
                        'desc' => $this->l('The number of items you want to see on the screen.'),
                    ),
                    array(
                        'form_group_class' => 'display-block-bonreassurance',
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BON_REAS_CAROUSEL_LOOP',
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
                        'form_group_class' => 'display-block-bonreassurance',
                        'type' => 'switch',
                        'label' => $this->l('Nav:'),
                        'name' => 'BON_REAS_CAROUSEL_NAV',
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
                        'form_group_class' => 'display-block-bonreassurance',
                        'type' => 'switch',
                        'label' => $this->l('Dots:'),
                        'name' => 'BON_REAS_CAROUSEL_DOTS',
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

        if (Tools::isEmpty(Tools::getValue('BON_REAS_LIMIT'))) {
            $errors[] = $this->l('Limit is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_REAS_LIMIT'))) {
                $errors[] = $this->l('Bad limit format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_REAS_CAROUSEL_NB'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_REAS_CAROUSEL_NB'))) {
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

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getBonreassuranceSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    protected function renderBonreassuranceForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update html content') : $this->l('Add html content')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title:'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter URL'),
                        'name' => 'url',
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Specific class:'),
                        'name' => 'specific_class',
                        'col' => 2
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content:'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_modules_icons_type',
                        'label' => $this->l('Select icon family'),
                        'name' => 'type_icon',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'outicons',
                                    'name' => $this->l('Outicons')
                                ),
                                array(
                                    'id' => 'material_icons',
                                    'name' => $this->l('Material Icons')
                                ),
                                array(
                                    'id' => 'puppets',
                                    'name' => $this->l('Puppets Icons')
                                ),
                                array(
                                    'id' => 'thin',
                                    'name' => $this->l('Thin Icons')
                                ),
                            ),
                            'name' => 'name',
                            'id' => 'id',
                            'index' => 'type_icon'
                        ),
                        'col' => 2,
                    ),
                    array(
                        'type' => 'select',
                        'form_group_class' => 'bon_modules_icons',
                        'label' => $this->l('Select an icon'),
                        'name' => 'icon',
                        'options' => array(
                            'query' => $this->getIcons(),
                            'id' => 'id_option',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Icon font size:'),
                        'name' => 'font_size',
                        'suffix' => 'px',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Icon color:'),
                        'name' => 'font_color',
                        'required' => true,
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

        if ((bool)Tools::getIsset('updatebonreassurance') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonreassurance((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonreassurance';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonreassuranceFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonreassuranceFormValues()
    {
        if ((bool)Tools::getIsset('updatebonreassurance') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonreassurance((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassBonreassurance();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'url' => Tools::getValue('url', $tab->url),
            'description' => Tools::getValue('description', $tab->description),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
            'specific_class' => Tools::getValue('specific_class', $tab->specific_class),
            'icon' => Tools::getValue('icon', $tab->icon),
            'type_icon' => Tools::getValue('type_icon', $tab->type_icon),
            'font_size' => Tools::getValue('font_size', $tab->font_size),
            'font_color' => Tools::getValue('font_color', $tab->font_color),
        );

        return $fields_values;
    }

    public function renderBonreassuranceList()
    {
        if (!$tabs = ClassBonreassurance::getBonreassuranceList()) {
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
            'icon' => array(
                'title' => $this->l('Icon'),
                'type' => 'box_icon',
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
        $helper->table = 'bonreassurance';
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
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'images/',
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonreassurance()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $item = new ClassBonreassurance((int)Tools::getValue('id_tab'));
        } else {
            $item = new ClassBonreassurance();
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->status = (int)Tools::getValue('status');
        $item->specific_class = pSql(Tools::getValue('specific_class'));
        $item->icon = pSql(Tools::getValue('icon'));
        $item->type_icon = pSql(Tools::getValue('type_icon'));
        $item->font_color = pSql(Tools::getValue('font_color'));
        $item->font_size = pSql(Tools::getValue('font_size'));

        if ((int)Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $item->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
            $item->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
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

        if (!Tools::isEmpty(Tools::getValue('specific_class'))) {
            if (!$this->isSpecificClass(Tools::getValue('specific_class'))) {
                $errors[] = $this->l('Bad specific class format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('The title is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad title format.');
        } elseif (!Validate::isPrice(Tools::getValue('font_size'))) {
            $errors[] = $this->l('Bad font size format.');
        } elseif (Tools::isEmpty(Tools::getValue('font_size'))) {
            $errors[] = $this->l('The font size is required.');
        } elseif (Tools::isEmpty(Tools::getValue('font_color'))) {
            $errors[] = $this->l('The font color is required.');
        } elseif (!Validate::isColor(Tools::getValue('font_color'))) {
            $errors[] = $this->l('Theme color format error.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonreassurance()
    {
        $tab = new ClassBonreassurance(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassBonreassurance(Tools::getValue('id_tab'));

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

    protected function isSpecificClass($class)
    {
        if (!ctype_alpha(Tools::substr($class, 0, 1)) || preg_match('/[\'^?$%&*()}{\x20@#~?><>,|=+¬]/', $class)) {
            return false;
        }

        return true;
    }

    public function getIcons()
    {
        $icons = array(
            array('id_option' => 'material-icons phone', 'name' => '&#xe0cd;', ),
            array('id_option' => 'material-icons store', 'name' => '&#xe8d1;'),
            array('id_option' => 'material-icons headset_mic', 'name' => '&#xe311;'),
            array('id_option' => 'people material-icons', 'name' => '&#xe7fb;'),
            array('id_option' => 'material-icons access_alarms', 'name' => '&#xe191;'),
            array('id_option' => 'material-icons account_circle', 'name' => '&#xe853;'),
            array('id_option' => 'material-icons build', 'name' => '&#xe869;'),
            array('id_option' => 'material-icons brush', 'name' => '&#xe3ae;'),
            array('id_option' => 'material-icons camera_alt', 'name' => '&#xe3b0;'),
            array('id_option' => 'material-icons card_giftcard', 'name' => '&#xe8f6;'),
            array('id_option' => 'material-icons chat', 'name' => '&#xe0b7;'),
            array('id_option' => 'material-icons chat_bubble', 'name' => '&#xe0ca;'),
            array('id_option' => 'material-icons chat_bubble_outline', 'name' => '&#xe0cb;'),
            array('id_option' => 'material-icons chevron_left', 'name' => '&#xe5cb;'),
            array('id_option' => 'material-icons chevron_right', 'name' => '&#xe5cc;'),
            array('id_option' => 'material-icons collections', 'name' => '&#xe3b6;'),
            array('id_option' => 'material-icons contacts', 'name' => '&#xe0ba;'),
            array('id_option' => 'material-icons quick_contacts_dialer', 'name' => '&#xe0cf;'),
            array('id_option' => 'material-icons color_lens', 'name' => '&#xe3b7;'),
            array('id_option' => 'material-icons computer', 'name' => '&#xe30a;'),
            array('id_option' => 'material-icons create', 'name' => '&#xe150;'),
            array('id_option' => 'material-icons crop_original', 'name' => '&#xe3c4;'),
            array('id_option' => 'material-icons desktop_mac', 'name' => '&#xe30b;'),
            array('id_option' => 'material-icons email', 'name' => '&#xe0be;'),
            array('id_option' => 'material-icons expand_less', 'name' => '&#xe5ce;'),
            array('id_option' => 'material-icons expand_more', 'name' => '&#xe5cf;'),
            array('id_option' => 'material-icons favorite', 'name' => '&#xe87e;'),
            array('id_option' => 'material-icons file_download', 'name' => '&#xe2c4;'),
            array('id_option' => 'material-icons forum', 'name' => '&#xe0bf;'),
            array('id_option' => 'material-icons help', 'name' => '&#xe887;'),
            array('id_option' => 'material-icons help_outline', 'name' => '&#xe8fd;'),
            array('id_option' => 'material-icons insert_comment', 'name' => '&#xe24c;'),
            array('id_option' => 'material-icons insert_invitation', 'name' => '&#xe24f;'),
            array('id_option' => 'material-icons insert_link', 'name' => '&#xe250;'),
            array('id_option' => 'material-icons insert_photo', 'name' => '&#xe251;'),
            array('id_option' => 'material-icons local_offer', 'name' => '&#xe54e;'),
            array('id_option' => 'material-icons location_on', 'name' => '&#xe0c8;'),
            array('id_option' => 'material-icons phone_android', 'name' => '&#xe324;'),
            array('id_option' => 'material-icons settings', 'name' => '&#xe8b8;'),
            array('id_option' => 'fl-outicons fl-outicons-headphones46', 'name' => '&#57383;'),
            array('id_option' => 'fl-outicons fl-outicons-house204', 'name' => '&#xE029;'),
            array('id_option' => 'fl-outicons fl-outicons-book270', 'name' => '&#xE007;'),
            array('id_option' => 'fl-outicons fl-outicons-chevron1', 'name' => '&#57357;'),
            array('id_option' => 'fl-outicons fl-outicons-chevron3', 'name' => '&#57359;'),
            array('id_option' => 'fl-outicons fl-outicons-chevron', 'name' => '&#57360;'),
            array('id_option' => 'fl-outicons fl-outicons-chevron2', 'name' => '&#57358;'),
            array('id_option' => 'fl-outicons fl-outicons-building106', 'name' => '&#57353;'),
            array('id_option' => 'fl-outicons fl-outicons-news', 'name' => '&#57401;'),
            array('id_option' => 'fl-outicons fl-outicons-question5', 'name' => '&#57415;'),
            array('id_option' => 'fl-outicons fl-outicons-sales2', 'name' => '&#57419;'),
            array('id_option' => 'fl-outicons fl-outicons-magnifying glass34', 'name' => '&#57394;'),
            array('id_option' => 'fl-outicons fl-outicons-phone14', 'name' => '&#57407;'),
            array('id_option' => 'fl-outicons fl-outicons-photo-camera5', 'name' => '&#57408;'),
            array('id_option' => 'fl-outicons fl-outicons-picture54', 'name' => '&#57409;'),
            array('id_option' => 'fl-outicons fl-outicons-pin12', 'name' => '&#57410;'),
            array('id_option' => 'fl-outicons fl-outicons-play127', 'name' => '&#57411;'),
            array('id_option' => 'fl-outicons fl-outicons-speech bubble34', 'name' => '&#57428;'),
            array('id_option' => 'fl-outicons fl-outicons-speech-balloon2', 'name' => '&#57427;'),
            array('id_option' => 'fl-outicons fl-outicons-truck72', 'name' => '&#57436;'),
            array('id_option' => 'fl-outicons fl-outicons-user189', 'name' => '&#57440;'),
            array('id_option' => 'fl-outicons fl-outicons-treasure', 'name' => '&#57435;'),
            array('id_option' => 'fl-outicons fl-outicons-print', 'name' => '&#57414;'),
            array('id_option' => 'fl-outicons fl-outicons-share53', 'name' => '&#57421;'),
            array('id_option' => 'fl-outicons fl-outicons-pencil9', 'name' => '&#57406;'),
            array('id_option' => 'fl-outicons fl-outicons-heart373', 'name' => '&#57384;'),
            array('id_option' => 'fl-outicons fl-outicons-download194', 'name' => '&#57369;'),
            array('id_option' => 'fl-outicons fl-outicons-gear40', 'name' => '&#57380;'),
            array('id_option' => 'fl-outicons fl-outicons-mail2', 'name' => '&#57396;'),
            array('id_option' => 'puppets fl-puppets-audio-bars', 'name' => '&#57344;'),
            array('id_option' => 'puppets fl-puppets-balance7', 'name' => '&#57345;'),
            array('id_option' => 'puppets fl-puppets-bank17', 'name' => '&#57346;'),
            array('id_option' => 'puppets fl-puppets-basket36', 'name' => '&#57347;'),
            array('id_option' => 'puppets fl-puppets-bills5', 'name' => '&#57348;'),
            array('id_option' => 'puppets fl-puppets-book-bag', 'name' => '&#57351;'),
            array('id_option' => 'puppets fl-puppets-calendar184', 'name' => '&#57353;'),
            array('id_option' => 'puppets fl-puppets-chat-bubble', 'name' => '&#57357;'),
            array('id_option' => 'puppets fl-puppets-circular-clock', 'name' => '&#57359;'),
            array('id_option' => 'puppets fl-puppets-computer203', 'name' => '&#57363;'),
            array('id_option' => 'puppets fl-puppets-diamond', 'name' => '&#57370;'),
            array('id_option' => 'puppets fl-puppets-dollar-symbol1', 'name' => '&#57375;'),
            array('id_option' => 'puppets fl-puppets-euro-coin', 'name' => '&#57379;'),
            array('id_option' => 'puppets fl-puppets-gallery1', 'name' => '&#57380;'),
            array('id_option' => 'puppets fl-puppets-gold-ingots', 'name' => '&#57382;'),
            array('id_option' => 'puppets fl-puppets-letter2', 'name' => '&#57384;'),
            array('id_option' => 'puppets fl-puppets-light102', 'name' => '&#57386;'),
            array('id_option' => 'puppets fl-puppets-magnifier58', 'name' => '&#57389;'),
            array('id_option' => 'puppets fl-puppets-map-point1', 'name' => '&#57390;'),
            array('id_option' => 'puppets fl-puppets-market1', 'name' => '&#57391;'),
            array('id_option' => 'puppets fl-puppets-money163', 'name' => '&#57394;'),
            array('id_option' => 'puppets fl-puppets-money-card', 'name' => '&#57396;'),
            array('id_option' => 'puppets fl-puppets-nut1', 'name' => '&#57401;'),
            array('id_option' => 'puppets fl-puppets-padlock75', 'name' => '&#57402;'),
            array('id_option' => 'puppets fl-puppets-picture42', 'name' => '&#57410;'),
            array('id_option' => 'puppets fl-puppets-present27', 'name' => '&#57413;'),
            array('id_option' => 'puppets fl-puppets-rubbish12', 'name' => '&#57418;'),
            array('id_option' => 'puppets fl-puppets-savings3', 'name' => '&#57419;'),
            array('id_option' => 'puppets fl-puppets-shop', 'name' => '&#57425;'),
            array('id_option' => 'puppets fl-puppets-telephone113', 'name' => '&#57427;'),
            array('id_option' => 'puppets fl-puppets-telesales', 'name' => '&#57432;'),
            array('id_option' => 'puppets fl-puppets-telephone116', 'name' => '&#57430;'),
            array('id_option' => 'puppets fl-puppets-thumb56', 'name' => '&#57438;'),
            array('id_option' => 'puppets fl-puppets-woman154', 'name' => '&#57443;'),
            array('id_option' => 'puppets fl-puppets-science28', 'name' => '&#57421;'),
            array('id_option' => 'thin thin-icon-volume-on', 'name' => '&#59392;'),
            array('id_option' => 'thin thin-icon-gift', 'name' => '&#59393;'),
            array('id_option' => 'thin thin-icon-tag', 'name' => '&#59397;'),
            array('id_option' => 'thin thin-icon-chat', 'name' => '&#59398;'),
            array('id_option' => 'thin thin-icon-clock', 'name' => '&#59399;'),
            array('id_option' => 'thin thin-icon-map-marker', 'name' => '&#59401;'),
            array('id_option' => 'thin thin-icon-phone-support', 'name' => '&#59408;'),
            array('id_option' => 'thin thin-icon-phone-call', 'name' => '&#59415;'),
            array('id_option' => 'thin thin-icon-briefcase-2', 'name' => '&#59416;'),
            array('id_option' => 'thin thin-icon-support', 'name' => '&#59418;'),
            array('id_option' => 'thin thin-icon-pull', 'name' => '&#59419;'),
            array('id_option' => 'thin thin-icon-desktop', 'name' => '&#59420;'),
            array('id_option' => 'thin thin-icon-email', 'name' => '&#59423;'),
            array('id_option' => 'thin thin-icon-house', 'name' => '&#59425;'),
            array('id_option' => 'thin thin-icon-external-right', 'name' => '&#59429;'),
            array('id_option' => 'thin thin-icon-email-open', 'name' => '&#59430;'),
            array('id_option' => 'thin thin-icon-email-search', 'name' => '&#59433;'),
            array('id_option' => 'thin thin-icon-cart', 'name' => '&#59447;'),
            array('id_option' => 'thin thin-icon-headphones', 'name' => '&#59453;'),
            array('id_option' => 'thin thin-icon-ambulance', 'name' => '&#59467;'),
            array('id_option' => 'thin thin-icon-briefcase', 'name' => '&#59468;'),
            array('id_option' => 'thin thin-icon-trash', 'name' => '&#59472;'),
            array('id_option' => 'thin thin-icon-user', 'name' => '&#59482;'),
            array('id_option' => 'thin thin-icon-love', 'name' => '&#59483;'),
        );

        return $icons;
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonreassurance'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonreassurance'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/bonreassurance_back.js');
        $this->context->controller->addCSS($this->_path.'views/css/bonreassurance_back.css');
        $this->context->controller->addCSS($this->_path.'views/css/fl-outicons.css');
        $this->context->controller->addCSS($this->_path.'views/css/fl-puppets.css');
        $this->context->controller->addCSS($this->_path.'views/css/thin.css');
    }

    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/bonreassurance_front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/bonreassurance_front.css');
        $this->context->controller->addJS($this->_path.'views/js/slick.js');
        $this->context->controller->addCSS($this->_path.'views/css/slick.css', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/slick-theme.css', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/thin.css');
        $this->context->controller->addCSS($this->_path.'views/css/fl-outicons.css');
        $this->context->controller->addCSS($this->_path.'views/css/fl-puppets.css');


        $this->context->smarty->assign('settings', $this->getBonreassuranceSettings());

        return $this->display($this->_path, '/views/templates/hook/bonreassurance-header.tpl');
    }

    public function hookDisplayHome()
    {
        $bonreassurance_front = new ClassBonreassurance();
        $tabs = $bonreassurance_front->getTopFrontItems($this->id_shop, true);
        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['title'] = $tab['title'];
            $result[$key]['description'] = $tab['description'];
            $result[$key]['url'] = $tab['url'];
            $result[$key]['specific_class'] = $tab['specific_class'];
            $result[$key]['icon'] = $tab['icon'];
            $result[$key]['type_icon'] = $tab['type_icon'];
            $result[$key]['font_size'] = $tab['font_size'];
            $result[$key]['font_color'] = $tab['font_color'];
        }


        $this->smarty->assign(array(
            'display_carousel' => Configuration::get('BON_REAS_DISPLAY_CAROUSEL'),
            'items'=> $result,
            'limit'=> Configuration::get('BON_REAS_LIMIT')
        ));

        return $this->display(__FILE__, 'views/templates/hook/bonreassurance-front.tpl');
    }

    public function hookdisplayFooterBefore()
    {
        return $this->hookDisplayHome();
    }
    public function hookdisplayProductAdditionalInfo()
    {
        return $this->hookDisplayHome();
    }
    public function hookdisplayBonreassuranceCustom()
    {
        return $this->hookDisplayHome();
    }
}
